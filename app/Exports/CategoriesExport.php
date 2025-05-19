<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CategoriesExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        return Category::select('name', 'description', 'created_at')->filter()->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Description',
            'Created At',
        ];
    }
}
