<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Product;
use App\Models\Purchase;
use App\Exports\PurchasesExport;
use App\Models\Business;
use App\Models\PurchaseItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::select('id', 'number', 'currency_id', 'purchase_date', 'invoice_number', 'total', 'total')->filter()->orderBy('id', 'desc')->paginate(25);

        $data = compact('purchases');
        return view('purchases.index', $data);
    }

    public function new()
    {
        $products = Product::select('id', 'name')->with('barcodes')->get();

        $data = compact('products');
        return view('purchases.new', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'purchase_date' => 'required|date',
            'invoice_number' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.cost' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $path = null;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = time() . '.' . $ext;
                $image = Image::make($file);
                $image->fit(300, 300, function ($constraint) {
                    $constraint->upsize();
                });
                $image->save(public_path('uploads/purchases/' . $filename));
                $path = '/uploads/purchases/' . $filename;
            }

            $purchase = Purchase::create([
                'number' => Purchase::generate_number(),
                'currency_id' => auth()->user()->currency_id,
                'purchase_date' => $request->purchase_date,
                'invoice_number' => $request->invoice_number,
                'notes' => $request->notes,
                'total' => 0,
                'image' => $path,
            ]);

            $total = 0;

            foreach ($request->items as $item) {
                $lineTotal = $item['quantity'] * $item['cost'];
                $total += $lineTotal;
                $product = Product::findOrFail($item['product_id']);

                $product->update([
                    'quantity' => ($product->quantity + $item['quantity']),
                ]);

                $purchase->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'cost' => $item['cost'],
                    'total' => $lineTotal,
                ]);
            }

            $purchase->update(['total' => $total]);

            Log::create([
                'text' => ucwords(auth()->user()->name) . " created new Purchase NO: {$purchase->number}, datetime: " . now(),
            ]);

            DB::commit();

            return redirect()->route('purchases')->with('success', 'Purchase created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong while creating the purchase.');
        }
    }

    public function show(Purchase $purchase)
    {
        $business = Business::firstOrFail();
        return view('purchases.show', compact('purchase', 'business'));
    }

    public function edit(Purchase $purchase)
    {
        $products = Product::select('id', 'name')->with('barcodes')->get();

        $data = compact('purchase', 'products');
        return view('purchases.edit', $data);
    }

    public function update(Purchase $purchase, Request $request)
    {
        $request->validate([
            'purchase_date' => 'required|date',
            'invoice_number' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'items' => 'nullable|array',
            'items.*.product_id' => 'nullable|exists:products,id',
            'items.*.quantity' => 'nullable|numeric|min:0.01',
            'items.*.cost' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $total = 0;
            $path = $purchase->image;

            if ($request->filled('items')) {
                foreach ($request->items as $item) {
                    $lineTotal = $item['quantity'] * $item['cost'];
                    $total += $lineTotal;

                    $product = Product::findOrFail($item['product_id']);
                    $product->update([
                        'quantity' => $product->quantity + $item['quantity'],
                    ]);

                    $purchase->items()->create([
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'cost' => $item['cost'],
                        'total' => $lineTotal,
                    ]);
                }
            } else {
                $total = $purchase->total;
            }

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = time() . '.' . $ext;
                $image = Image::make($file);
                $image->fit(300, 300, function ($constraint) {
                    $constraint->upsize();
                });
                $image->save(public_path('uploads/purchases/' . $filename));
                $path = '/uploads/purchases/' . $filename;
            }

            $purchase->update([
                'purchase_date' => $request->purchase_date,
                'invoice_number' => $request->invoice_number,
                'notes' => $request->notes,
                'total' => $total,
                'image' => $path,
            ]);

            Log::create([
                'text' => ucwords(auth()->user()->name) . " updated Purchase NO: {$purchase->number}, datetime: " . now(),
            ]);

            DB::commit();

            return redirect()->route('purchases')->with('success', 'Purchase updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong while updating the purchase. ' . $e->getMessage());
        }
    }

    public function destroy(Purchase $purchase)
    {
        if ($purchase->can_delete()) {
            $text = ucwords(auth()->user()->name) . " deleted Purchase NO: " . $purchase->number . ", datetime :   " . now();

            foreach ($purchase->items as $item) {
                $item->product->update([
                    'quantity' => ($item->product->quantity - $item->quantity),
                ]);

                $item->delete();
            }

            Log::create([
                'text' => $text,
            ]);
            $purchase->delete();

            return redirect()->back()->with('error', 'Purchase deleted successfully and Products returned!');
        } else {
            return redirect()->back()->with('error', 'Unothorized Access...');
        }
    }

    public function purchase_item_destroy(PurchaseItem $purchase_item)
    {
        $purchase_item->product->update([
            'quantity' => ($purchase_item->product->quantity - $purchase_item->quantity),
        ]);

        $text = ucwords(auth()->user()->name) . " returned " . $purchase_item->quantity . " of " . ucwords($purchase_item->product->name) . " from Purchase NO: " . $purchase_item->purchase->number . ", datetime :   " . now();

        Log::create([
            'text' => $text,
        ]);

        $purchase_item->delete();

        return redirect()->back()->with('error', 'Purchase Item returned successfully!');
    }

    public function export(Request $request)
    {
        $filters = $request->all();
        return Excel::download(new PurchasesExport($filters), 'Purchases.xlsx');
    }

    public function pdf(Request $request)
    {
        $purchases = Purchase::filter()->get();

        $pdf = Pdf::loadView('purchases.pdf', compact('purchases'));

        return $pdf->download('Purchases.pdf');
    }
}
