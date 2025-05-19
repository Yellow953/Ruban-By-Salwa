<?php

namespace App\Exports;

use App\Models\Subscription;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SubscriptionsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        return Subscription::with('user')->filter()->get();
    }

    public function headings(): array
    {
        return [
            'User',
            'Starts At',
            'Ends At',
            'Is Active',
            'Type',
            'Plan',
            'Created At',
        ];
    }

    public function map($row): array
    {
        return [
            $row->user->name,
            $row->start_at,
            $row->end_at,
            $row->is_active,
            $row->type,
            $row->plan,
            $row->created_at,
        ];
    }
}
