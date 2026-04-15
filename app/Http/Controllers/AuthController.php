<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
class AuthController extends Controller
{
    public function showLogin()
    {
        return view('landing');
    }
 
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
 
        $credentials = $request->only('email', 'password');
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            $role = Auth::user()->role;
 
            if ($role == 'admin') {
                return redirect()->intended('/admin/dashboard');
            }
 
            if ($role == 'operator') {
                return redirect()->intended('/staff/dashboard');
            }
 
            return redirect('/');
        }
 
        return back()->withErrors([
            'loginError' => 'Email atau password salah!'
        ])->withInput();
    }
 
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
 
        return redirect('/');
    }
}