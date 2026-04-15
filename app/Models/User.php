<?php
 
namespace App\Models;
 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Models\Lending;
 
class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
 
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];
 
    public function lendings()
    {
        return $this->hasMany(Lending::class);
    }
}