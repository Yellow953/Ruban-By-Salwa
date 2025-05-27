<?php

namespace App\Http\Controllers;

use App\Exports\ReportsExport;
use App\Models\Currency;
use App\Models\Log;
use App\Models\Order;
use App\Models\Report;
use App\Models\ReportItem;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::select('id', 'user_id', 'start_datetime', 'end_datetime', 'total_sales', 'total_tax', 'total_discounts', 'cash_amount', 'transaction_count', 'currency_id')->with('currency', 'user')->filter()->orderBy('end_datetime', 'desc')->paginate(25);
        $users = User::select('id', 'name')->get();

        $data = compact('reports', 'users');
        return view('reports.index', $data);
    }

    public function create(Request $request)
    {
        $lastReport = Report::latest()->first();
        $startDate = $lastReport ? $lastReport->end_datetime : Order::oldest()->value('created_at') ?? now();

        // Get orders in this period
        $orders = Order::with('items')
            ->whereBetween('created_at', [$startDate, now()])
            ->get();

        // Calculate totals
        $totals = $this->calculateOrderTotals($orders);

        // Create the report
        $report = Report::create([
            'user_id' => auth()->id(),
            'start_datetime' => $startDate,
            'end_datetime' => now(),
            'total_sales' => $totals['total_sales'],
            'total_tax' => $totals['total_tax'],
            'total_discounts' => $totals['total_discount'],
            'cash_amount' => $totals['cash_amount'],
            'transaction_count' => $orders->count(),
            'currency_id' => $request->input('currency_id', Currency::default()->id)
        ]);

        // Save report items
        $this->saveReportItems($report, $orders);

        // Log the action
        Log::create([
            'text' => "Z Report #{$report->id} generated covering " .
                $startDate->format('Y-m-d H:i') . " to " . now()->format('Y-m-d H:i')
        ]);

        return redirect()->route('reports.show', $report)
            ->with('success', 'Z Report generated successfully');
    }

    public function show(Report $report)
    {
        $report->load(['items.product', 'user', 'currency']);
        return view('reports.show', compact('report'));
    }

    public function edit(Report $report)
    {
        $currencies = Currency::select('id', 'name')->get();
        $data = compact('currencies', 'report');

        return view('reports.edit', $data);
    }

    public function update(Request $request, Report $report)
    {
        $request->validate([
            'start_cash' => 'required|numeric|min:0',
            'end_cash' => 'required|numeric|min:0',
            'date' => 'required|date',
            'currency_id' => 'required',
        ]);

        $report->update([
            'start_cash' => $request->start_cash,
            'end_cash' => $request->end_cash,
            'date' => $request->date,
            'currency_id' => $request->currency_id,
        ]);

        $text = "Report of " . $report->date . " updated in " . Carbon::now();
        Log::create(['text' => $text]);

        return redirect()->route('reports')->with('success', 'Report was successfully updated.');
    }

    public function destroy(Report $report)
    {
        foreach ($report->items as $item) {
            $item->delete();
        }

        Log::create([
            'text' => "Z Report #{$report->id} deleted"
        ]);

        $report->delete();

        return back()->with('success', 'Report deleted successfully');
    }

    public function export(Request $request)
    {
        $filters = $request->all();
        return Excel::download(new ReportsExport($filters), 'Reports.xlsx');
    }

    public function pdf(Request $request)
    {
        $reports = Report::with('currency', 'user')->filter()->get();

        $pdf = Pdf::loadView('reports.pdf', compact('reports'));

        return $pdf->download('Reports.pdf');
    }

    public function new_report(Request $request)
    {
        $request->validate([
            'start_cash' => 'required|numeric|min:0',
            'end_cash' => 'required|numeric|min:0',
            'currency_id' => 'required',
            'date' => 'required|date',
        ]);

        $report = Report::create([
            'start_cash' => $request->start_cash,
            'end_cash' => $request->end_cash,
            'date' => $request->date,
            'currency_id' => $request->currency_id,
        ]);

        $text = "Report of " . $report->date . " created in " . Carbon::now();
        Log::create(['text' => $text]);

        return response()->json(['success' => true, 'message' => 'Report created successfully!']);
    }

    protected function calculateOrderTotals($orders)
    {
        return [
            'total_sales' => $orders->sum('total'),
            'total_tax' => $orders->sum('tax'),
            'total_discount' => $orders->sum('discount'),
            'cash_amount' => $orders->where('payment_currency', 'USD')->sum('amount_paid')
        ];
    }

    protected function saveReportItems($report, $orders)
    {
        $itemsData = [];

        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $itemsData[] = [
                    'report_id' => $report->id,
                    'product_id' => $item->product_id,
                    'quantity_sold' => $item->quantity,
                    'total_amount' => $item->total,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }

        ReportItem::insert($itemsData);
    }
}
