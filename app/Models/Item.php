<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Lending;
 
class Item extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'total',
        'repair',   
        'lending'   
    ];
 
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
 
    public function lendings()
    {
        return $this->hasMany(Lending::class);
    }
}