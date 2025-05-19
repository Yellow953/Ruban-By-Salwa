<?php

namespace App\Exports;

use App\Models\Table;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TablesExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        return Table::select('code', 'seats', 'location', 'status', 'notes', 'created_at')->filter()->get();
    }

    public function headings(): array
    {
        return [
            'Code',
            'Number of Seats',
            'Location',
            'Status',
            'Notes',
            'Created At',
        ];
    }
}
