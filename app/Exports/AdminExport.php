<?php
namespace App\Exports;
 
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Str;
 
class AdminExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection() {
        return User::where('role', 'admin')->get(); 
    }
 
    public function headings(): array {
        return ['Name', 'Email', 'Password'];
    }
 
    public function map($user): array {
        $pw = ($user->password_status == 'changed') ? 'This account already edited the password' : Str::lower(Str::substr($user->email, 0, 4)) . $user->id;
        return [$user->name, $user->email, $pw];
    }
}