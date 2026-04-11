<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginAdminController extends Controller
{
    // tampilkan form login
    public function index()
    {
        return view('login-admin');
    }

    // proses login admin pakai Auth Laravel
    public function login(Request $request)
    {
        $login = Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        if ($login) {

            // cek apakah role admin
            if (Auth::user()->role == 'admin') {
                return redirect('/dashboard-admin');
            }

            // kalau bukan admin logout lagi
            Auth::logout();
            return back()->with('error', 'Bukan akun admin');
        }

        return back()->with('error', 'Email atau password salah');
    }

    // logout admin
    public function logout()
    {
        Auth::logout();
        return redirect('/login-admin');
    }
}
