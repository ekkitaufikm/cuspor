<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // Mengarahkan setelah login
    protected $redirectTo = '/dashboard';

    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Mengatur nama pengguna sebagai field yang digunakan untuk login
    public function username()
    {
        return 'username';
    }

    // Memberikan pesan flash setelah logout
    protected function loggedOut(\Illuminate\Http\Request $request)
    {
        session()->flash('success', 'You are logged out!');
        return redirect('/dashboard');
    }
}
