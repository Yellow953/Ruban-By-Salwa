<?php

namespace App\Exports;

use App\Models\Reservation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReservationsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        return Reservation::with('client', 'table')->filter()->get();
    }

    public function headings(): array
    {
        return [
            'Client',
            'Table',
            'Reservation Date & Time',
            'Number of People',
            'Status',
            'Notes',
            'Created At',
        ];
    }

    public function map($row): array
    {
        return [
            $row->client->name,
            $row->table->code,
            $row->reservation_time,
            $row->number_of_people,
            $row->status,
            $row->notes,
            $row->created_at,
        ];
    }
}
