<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        return User::select('name', 'email', 'phone', 'role', 'currency_id', 'created_at')->filter()->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Phone',
            'Role',
            'Currency',
            'Created At',
        ];
    }

    public function map($row): array
    {
        return [
            $row->name,
            $row->email,
            $row->phone,
            $row->role,
            $row->currency->code,
            $row->created_at,
        ];
    }
}
