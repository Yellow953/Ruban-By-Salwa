<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        return Product::with('category')->filter()->get();
    }

    public function headings(): array
    {
        return [
            'Category',
            'Name',
            'Quantity',
            'Cost',
            'Price',
            'Description',
            'Location',
            'Created At',
        ];
    }

    public function map($row): array
    {
        return [
            $row->category->name,
            $row->name,
            $row->quantity,
            $row->cost,
            $row->price,
            $row->description,
            $row->location,
            $row->created_at,
        ];
    }
}
