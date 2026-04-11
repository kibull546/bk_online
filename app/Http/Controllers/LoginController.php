<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // validasi input dulu
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // proses login
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {

            $request->session()->regenerate();

            // redirect berdasarkan role
            if(Auth::user()->role == 'admin'){
                return redirect('/dashboard-admin');
            }else{
                return redirect('/dashboard');
            }
        }

        return back()->with('error','Email atau password salah');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}