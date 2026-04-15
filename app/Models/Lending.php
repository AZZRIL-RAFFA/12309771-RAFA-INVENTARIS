<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Lending extends Model
{
    protected $fillable = [
        'item_id',
        'user_id',
        'name',      // Nama peminjam
        'total',     // Jumlah yang dipinjam
        'notes',     // Keterangan
        'date',      // Tanggal pinjam
        'is_returned',
        'returned_to'

    ];
 
    // Casting agar date otomatis menjadi objek Carbon
    protected $casts = [
        'date' => 'date',
        'is_returned' => 'boolean',
    ];
 
    // Relasi: Peminjaman merujuk ke satu barang
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
 
    // Relasi: Peminjaman dicatat oleh satu user (operator)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}