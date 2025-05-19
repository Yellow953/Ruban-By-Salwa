<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        return Report::with('currency')->filter()->get();
    }

    public function headings(): array
    {
        return [
            'Date',
            'Start Cash',
            'End Cash',
            'Currency',
            'Created At',
        ];
    }

    public function map($row): array
    {
        return [
            $row->date,
            $row->start_cash,
            $row->end_cash,
            $row->currency_code,
            $row->created_at,
        ];
    }
}
