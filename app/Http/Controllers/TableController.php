<?php

namespace App\Http\Controllers;

use App\Exports\TablesExport;
use App\Models\Table;
use App\Models\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TableController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $tables = Table::select('id', 'code', 'seats', 'location', 'status')->filter()->orderBy('id', 'desc')->paginate(25);

        return view('tables.index', compact('tables'));
    }

    public function new()
    {
        return view('tables.new');
    }

    public function create(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:tables|max:255',
            'seats' => 'required|integer|min:1',
            'location' => 'required|max:255',
            'status' => 'required|in:available,occupied,reserved,maintenance',
            'notes' => 'nullable',
        ]);

        $table = Table::create([
            'code' => $request->code,
            'seats' => $request->seats,
            'location' => $request->location,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        $text = ucwords(auth()->user()->name) . " created new Table : " . $table->code . ", datetime: " . now();

        Log::create([
            'text' => $text,
        ]);

        return redirect()->route('tables')->with('success', 'Table created successfully!');
    }

    public function edit(Table $table)
    {
        $data = compact('table');
        return view('tables.edit', $data);
    }

    public function update(Table $table, Request $request)
    {
        $request->validate([
            'code' => 'required|max:255|unique:tables,code,' . $table->id,
            'seats' => 'required|integer|min:1',
            'location' => 'required|max:255',
            'status' => 'required|in:available,occupied,reserved,maintenance',
            'notes' => 'nullable',
        ]);

        if ($table->code != trim($request->code)) {
            $text = ucwords(auth()->user()->name) . ' updated Table ' . $table->code . " to " . $request->code . ", datetime: " . now();
        } else {
            $text = ucwords(auth()->user()->name) . ' updated Table ' . $table->code . ", datetime: " . now();
        }

        $table->update(
            $request->all()
        );

        Log::create([
            'text' => $text,
        ]);

        return redirect()->route('tables')->with('warning', 'Table updated successfully!');
    }

    public function destroy(Table $table)
    {
        if ($table->can_delete()) {
            $text = ucwords(auth()->user()->name) . " deleted table: " . $table->code . ", datetime: " . now();

            Log::create([
                'text' => $text,
            ]);
            $table->delete();

            return redirect()->back()->with('error', 'Table deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unauthorized Access...');
        }
    }

    public function export(Request $request)
    {
        $filters = $request->all();
        return Excel::download(new TablesExport($filters), 'Tables.xlsx');
    }

    public function pdf(Request $request)
    {
        $tables = Table::select('code', 'seats', 'location', 'status', 'notes', 'created_at')->filter()->get();

        $pdf = Pdf::loadView('tables.pdf', compact('tables'));

        return $pdf->download('Tables.pdf');
    }
}
