<?php

namespace App\Http\Controllers;

use App\Exports\OrdersExport;
use App\Models\Business;
use App\Models\Client;
use App\Models\Log;
use App\Models\Order;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::select('id', 'order_number', 'cashier_id', 'client_id', 'currency_id', 'sub_total', 'tax', 'discount', 'total', 'products_count')->filter()->orderBy('id', 'desc')->paginate(25);
        $users = User::select('id', 'name')->get();
        $clients = Client::select('id', 'name')->get();

        $data = compact('orders', 'users', 'clients');
        return view('orders.index', $data);
    }

    public function show(Order $order)
    {
        $business = Business::firstOrFail();
        $currency = $order->currency;

        $data = compact('order', 'business', 'currency');
        return view('orders.show', $data);
    }

    public function destroy(Order $order)
    {
        if ($order->can_delete()) {
            $text = ucwords(auth()->user()->name) .  " deleted Order " . $order->id . ", datetime: " . now();

            foreach ($order->items() as $item) {
                $item->product->update([
                    'quantity' => ($item->product->quantity + $item->quantity),
                ]);
                $item->delete();
            }

            $order->delete();
            Log::create(['text' => $text]);

            return redirect()->back()->with('success', "Order successfully deleted and Products returned!");
        } else {
            return redirect()->back()->with('danger', 'Unable to delete');
        }
    } //end of order

    public function export(Request $request)
    {
        $filters = $request->all();
        return Excel::download(new OrdersExport($filters), 'Orders.xlsx');
    }

    public function pdf(Request $request)
    {
        $orders = Order::with('cashier', 'client')->filter()->get();

        $pdf = Pdf::loadView('orders.pdf', compact('orders'));

        return $pdf->download('Orders.pdf');
    }

    public function return(Order $order)
    {
        $currency = $order->currency;
        return view('orders.return', compact('order', 'currency'));
    }

    public function processReturn(Request $request, Order $order)
    {
        $request->validate([
            'return_quantities' => 'required|array',
            'return_quantities.*' => 'required|integer|min:0'
        ]);

        try {
            DB::beginTransaction();

            $returnQuantities = $request->return_quantities;
            $totalReturnAmount = 0;
            $returnedItems = [];

            foreach ($order->items as $item) {
                $returnQuantity = $returnQuantities[$item->id] ?? 0;

                if ($returnQuantity > 0) {
                    if ($returnQuantity > $item->quantity) {
                        throw new \Exception("Return quantity cannot be greater than original quantity for item: {$item->product->name}");
                    }

                    // Update product quantity
                    $item->product->update([
                        'quantity' => $item->product->quantity + $returnQuantity
                    ]);

                    // Calculate return amount
                    $returnAmount = $returnQuantity * $item->unit_price;
                    $totalReturnAmount += $returnAmount;

                    // Update order item return status
                    $item->update([
                        'returned' => true,
                        'returned_quantity' => $returnQuantity,
                        'returned_at' => now(),
                        'total' => $item->total - $returnAmount,
                    ]);

                    $returnedItems[] = [
                        'product' => $item->product,
                        'return_quantity' => $returnQuantity,
                        'unit_price' => $item->unit_price,
                        'return_amount' => $returnAmount,
                        'variant_details' => $item->variant_details
                    ];
                }
            }

            if (empty($returnedItems)) {
                throw new \Exception('No items selected for return');
            }

            $order->update([
                'sub_total' => ($order->sub_total - $totalReturnAmount),
                'total' => ($order->total - $totalReturnAmount),
            ]);

            // Log the return
            $text = 'User ' . ucwords(auth()->user()->name) . ' processed return for Order NO: ' . $order->order_number . ' { ';
            foreach ($returnedItems as $item) {
                $text .= "Product: {$item['product']->name}, Quantity: {$item['return_quantity']}, Amount: {$item['return_amount']} | ";
            }
            $text .= " } , Total Return Amount: {$totalReturnAmount}, datetime: " . now();

            Log::create(['text' => $text]);

            DB::commit();

            // Return the receipt view
            $business = Business::first();
            $currency = $order->currency;

            return view('orders.return-receipt', compact('order', 'returnedItems', 'totalReturnAmount', 'business', 'currency'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to process return: ' . $e->getMessage())
                ->withInput();
        }
    }
}
