<?php
 
namespace App\Exports;
 
use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
 
class ItemsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Ambil data beserta kategorinya
        return Item::with('category')->get();
    }
 
    // ngatur Header Excel
    public function headings(): array
    {
        return [
            'Category',
            'Name Item',
            'Total',
            'Repair Total',
            'Last Updated',
        ];
    }
 
    // ngatur isi data dan format (Mapping)
    public function map($item): array
    {
        return [
            $item->category->name,
            $item->name,
            $item->total,
            // Jika repair 0, tampilkan "-", jika tidak tampilkan angkanya
            $item->repair == 0 ? '-' : $item->repair,
            // Format tanggal: Nama Bulan Tanggal, Tahun (Jan 14, 2023)
            $item->updated_at->format('M d, Y'),
        ];
    }
}
 
 
 