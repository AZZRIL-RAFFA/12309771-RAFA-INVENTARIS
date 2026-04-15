<?php
 
namespace App\Http\Controllers;
 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Exports\AdminExport;
use App\Exports\OperatorExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
 
class UserController extends Controller
{
    public function indexAdmin()
    {
        $users = User::where('role', 'admin')->get();
        $title = "Admin Accounts";
        return view('admin.users.index', compact('users', 'title'));
    }
 
    public function indexOperator()
    {
        $users = User::where('role', 'operator')->get();
        $title = "Operator Accounts";
        return view('admin.operators.index', compact('users', 'title'));
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,operator,staff'
        ]);
 
        $emailPrefix = Str::lower(Str::substr($request->email, 0, 4));
 
        $currentRoleCount = User::where('role', $request->role)->count();
        $nextNumber = $currentRoleCount + 1;
 
        $plainPassword = $emailPrefix . $nextNumber;
 
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($plainPassword),
        ]);
 
        return redirect()->back()->with('success_password', "Berhasil! Password untuk akun ini adalah: " . $plainPassword);
    }
 
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
 
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'new_password' => 'nullable|min:5'
        ]);
 
        $user->name = $request->name;
        $user->email = $request->email;
 
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }
 
        $user->save();
 
        return redirect()->back()->with('success', 'Account updated successfully!');
    }
 
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Account deleted!');
    }
 
    public function exportAdmin()
    {
        return Excel::download(new AdminExport, 'admin-accounts.xlsx');
    }
 
    public function exportOperator()
    {
        return Excel::download(new OperatorExport, 'operator-accounts.xlsx');
    }
 
    public function editStaff()
    {
        $user = Auth::user();
        return view('staff.users.index', compact('user'));
    }
 
    public function updateStaff(Request $request)
    {
        $user = User::findOrFail(Auth::id());
 
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:5'
        ]);
 
        $user->name = $request->name;
        $user->email = $request->email;
 
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
 
        $user->save();
 
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}