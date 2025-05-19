<?php

namespace App\Exports;

use App\Models\Business;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BusinessesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        return Business::with('tax')->filter()->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Phone',
            'Address',
            'Website',
            'Tax',
            'Created At',
        ];
    }

    public function map($row): array
    {
        return [
            $row->name,
            $row->email,
            $row->phone,
            $row->address,
            $row->website,
            $row->tax->name,
            $row->created_at,
        ];
    }
}
