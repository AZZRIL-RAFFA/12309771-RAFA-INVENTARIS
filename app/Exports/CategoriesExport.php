<?php

namespace App\Exports;

use App\Models\Category; 
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CategoriesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $index = 0;

    public function collection()
    {
        return Category::withCount('items')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Category Name',
            'Division Pj',
            'Total Items',
            'Last Updated',
        ];
    }

    public function map($category): array
    {
        $this->index++;

        return [
            $this->index,
            $category->name,
            $category->division_pj,
            $category->items_count,
            $category->updated_at->format('M d, Y'),
        ];
    }
}