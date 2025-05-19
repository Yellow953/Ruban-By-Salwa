<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        return Order::with('cashier', 'client')->filter()->get();
    }

    public function headings(): array
    {
        return [
            'Cashier',
            'Client',
            'Order Number',
            'Sub Total',
            'Tax',
            'Discount',
            'Total',
            'Products Count',
            'Note',
            'Created At',
        ];
    }

    public function map($row): array
    {
        return [
            $row->cashier->name,
            $row->client->name,
            $row->order_number,
            $row->sub_total,
            $row->tax,
            $row->discount,
            $row->total,
            $row->products_count,
            $row->note,
            $row->created_at,
        ];
    }
}
