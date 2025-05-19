<?php

namespace App\Exports;

use App\Models\Tax;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TaxesExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        return Tax::select('name', 'rate', 'created_at')->filter()->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Rate',
            'Created At',
        ];
    }
}
