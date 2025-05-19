<?php

namespace App\Http\Controllers;

use App\Exports\TaxesExport;
use App\Models\Log;
use App\Models\Tax;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TaxController extends Controller
{
    public function index()
    {
        $taxes = Tax::select('id', 'name', 'rate')->filter()->paginate(25);

        return view('taxes.index', compact('taxes'));
    }

    public function new()
    {
        return view('taxes.new');
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:taxes',
            'rate' => 'required|numeric|min:0|max:100',
        ]);

        $tax =  Tax::create($data);

        $text = ucwords(auth()->user()->name) . " created new Tax : " . $tax->name . ", datetime :   " . now();
        Log::create([
            'text' => $text,
        ]);

        return redirect()->route('taxes')->with('success', 'Tax created successfully!');
    }

    public function edit(Tax $tax)
    {
        return view('taxes.edit', compact('tax'));
    }

    public function update(Tax $tax, Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'rate' => 'required|numeric|min:0|max:100'
        ]);

        $text = "Tax: " . $tax->name . " changed to " . $request->rate . " in " . Carbon::now();

        $tax->update($data);
        Log::create([
            'text' => $text
        ]);

        return redirect()->back()->with('success', 'Tax successfully updated...');
    }

    public function destroy(Tax $tax)
    {
        if ($tax->can_delete()) {
            $user = auth()->user();
            $text = ucwords($user->name) . " deleted Tax : " . $tax->name . ", datetime :   " . now();

            Log::create([
                'text' => $text,
            ]);
            $tax->delete();

            return redirect()->back()->with('error', 'Tax deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unothorized Access...');
        }
    }

    public function export(Request $request)
    {
        $filters = $request->all();
        return Excel::download(new TaxesExport($filters), 'Taxes.xlsx');
    }
    public function pdf(Request $request)
    {
        $taxes = Tax::select('name', 'rate', 'created_at')->filter()->get();

        $pdf = Pdf::loadView('taxes.pdf', compact('taxes'));

        return $pdf->download('Taxes.pdf');
    }
}
