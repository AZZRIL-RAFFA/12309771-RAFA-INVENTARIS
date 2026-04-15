<?php

namespace App\Exports;

use App\Models\Lending;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LendingExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Lending::with(['item', 'user'])->latest()->get();
    }

    public function headings(): array
    {
        return [
            'Item',
            'Total',
            'Borrower',
            'Notes',
            'Date',
            'Status',
            'Returned To',
            'Edited By',
        ];
    }

    public function map($lending): array
    {
        return [
            $lending->item->name ?? '-',
            $lending->total,
            $lending->name,
            $lending->notes ?? '-',
            $lending->date ? $lending->date->format('Y-m-d') : '-',
            $lending->is_returned ? 'returned' : 'not returned',
            $lending->returned_to ?? '-',
            $lending->user->name ?? '-',
        ];
    }
}
