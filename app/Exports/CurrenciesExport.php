<?php

namespace App\Exports;

use App\Models\Currency;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CurrenciesExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        return Currency::select('code', 'name', 'symbol', 'rate', 'created_at')->filter()->get();
    }

    public function headings(): array
    {
        return [
            'Code',
            'Name',
            'Symbol',
            'Rate',
            'Created At',
        ];
    }
}
