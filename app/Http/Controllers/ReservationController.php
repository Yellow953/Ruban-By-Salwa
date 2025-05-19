<?php

namespace App\Http\Controllers;

use App\Exports\ReservationsExport;
use App\Models\Reservation;
use App\Models\Client;
use App\Models\Table;
use App\Models\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $reservations = Reservation::with(['client', 'table'])
            ->filter()
            ->orderBy('reservation_time', 'desc')
            ->paginate(25);

        $clients = Client::select('id', 'name')->orderBy('name')->get();
        $tables = Table::select('id', 'code')->orderBy('code')->get();

        return view('reservations.index', compact('reservations', 'clients', 'tables'));
    }

    public function new()
    {
        $clients = Client::select('id', 'name')->orderBy('name')->get();
        $tables = Table::where('status', 'available')->select('id', 'code', 'seats', 'location')->orderBy('code')->get();

        return view('reservations.new', compact('clients', 'tables'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'table_id' => 'required|exists:tables,id',
            'reservation_time' => 'required|date|after:now',
            'number_of_people' => 'required|integer|min:1',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,canceled,completed',
        ]);

        $existingReservation = Reservation::where('table_id', $request->table_id)
            ->where('status', '!=', 'canceled')
            ->whereDate('reservation_time', date('Y-m-d', strtotime($request->reservation_time)))
            ->exists();

        if ($existingReservation) {
            return redirect()->back()->with('error', 'This table is already reserved for the selected date.');
        }

        $reservation = Reservation::create([
            'client_id' => $request->client_id,
            'table_id' => $request->table_id,
            'reservation_time' => $request->reservation_time,
            'number_of_people' => $request->number_of_people,
            'notes' => $request->notes,
            'status' => $request->status,
        ]);

        if ($request->status == 'confirmed') {
            $table = Table::find($request->table_id);
            $table->update(['status' => 'reserved']);
        }

        $text = ucwords(auth()->user()->name) . " created new Reservation for client: " .
            $reservation->client->name . " at table: " . $reservation->table->code . ", datetime: " . now();

        Log::create(['text' => $text]);

        return redirect()->route('reservations')->with('success', 'Reservation created successfully!');
    }

    public function edit(Reservation $reservation)
    {
        $clients = Client::select('id', 'name')->orderBy('name')->get();
        $tables = Table::select('id', 'code', 'seats', 'location')
            ->where(function ($query) use ($reservation) {
                $query->where('status', 'available')
                    ->orWhere('id', $reservation->table_id);
            })
            ->orderBy('code')
            ->get();

        return view('reservations.edit', compact('reservation', 'clients', 'tables'));
    }

    public function update(Reservation $reservation, Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'table_id' => 'required|exists:tables,id',
            'reservation_time' => 'required|date',
            'number_of_people' => 'required|integer|min:1',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,canceled,completed',
        ]);

        if ($reservation->table_id != $request->table_id && $request->status != 'canceled') {
            $existingReservation = Reservation::where('table_id', $request->table_id)
                ->where('id', '!=', $reservation->id)
                ->where('status', '!=', 'canceled')
                ->whereDate('reservation_time', date('Y-m-d', strtotime($request->reservation_time)))
                ->exists();

            if ($existingReservation) {
                return redirect()->back()->withInput()->with('error', 'This table is already reserved for the selected date.');
            }
        }

        $oldTableId = $reservation->table_id;
        $oldStatus = $reservation->status;

        $reservation->update($request->all());

        if ($oldStatus != $request->status || $oldTableId != $request->table_id) {
            if ($oldTableId != $request->table_id && $oldStatus == 'confirmed') {
                $oldTable = Table::find($oldTableId);
                $oldTable->update(['status' => 'available']);
            }

            $table = Table::find($request->table_id);
            if ($request->status == 'confirmed') {
                $table->update(['status' => 'reserved']);
            } elseif ($request->status == 'canceled' && $oldStatus == 'confirmed' && $oldTableId == $request->table_id) {
                $table->update(['status' => 'available']);
            }
        }

        $text = ucwords(auth()->user()->name) . ' updated Reservation for client: ' .
            $reservation->client->name . " at table: " . $reservation->table->code . ", datetime: " . now();

        Log::create(['text' => $text]);

        return redirect()->route('reservations')->with('warning', 'Reservation updated successfully!');
    }

    public function destroy(Reservation $reservation)
    {
        if ($reservation->can_delete()) {
            if ($reservation->status == 'confirmed') {
                $table = Table::find($reservation->table_id);
                $table->update(['status' => 'available']);
            }

            $text = ucwords(auth()->user()->name) . " deleted reservation for client: " .
                $reservation->client->name . " at table: " . $reservation->table->code . ", datetime: " . now();

            Log::create(['text' => $text]);
            $reservation->delete();

            return redirect()->back()->with('error', 'Reservation deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unauthorized Access...');
        }
    }

    public function export(Request $request)
    {
        $filters = $request->all();
        return Excel::download(new ReservationsExport($filters), 'Reservations.xlsx');
    }

    public function pdf(Request $request)
    {
        $reservations = Reservation::with('client', 'table')->filter()->get();

        $pdf = Pdf::loadView('reservations.pdf', compact('reservations'));

        return $pdf->download('Reservations.pdf');
    }
}
