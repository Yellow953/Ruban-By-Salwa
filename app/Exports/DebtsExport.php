<?php

namespace App\Exports;

use App\Models\Debt;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DebtsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        return Debt::with('currency', 'supplier', 'client')->filter()->get();
    }

    public function headings(): array
    {
        return [
            'Type',
            'Supplier',
            'Client',
            'Amount',
            'Currency',
            'Date',
            'Note',
            'Created At',
        ];
    }

    public function map($row): array
    {
        return [
            $row->type,
            $row->supplier->name,
            $row->client->name,
            $row->amount,
            $row->currency->code,
            $row->date,
            $row->note,
            $row->created_at,
        ];
    }
}
