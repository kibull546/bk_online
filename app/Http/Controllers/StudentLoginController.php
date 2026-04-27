<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class StudentLoginController extends Controller
{
    // ======================
    // FORM LOGIN
    // ======================
    public function showLogin()
    {
        return view('student-login');
    }

    // ======================
    // PROSES LOGIN
    // ======================
    public function login(Request $request)
    {
        $request->validate([
            'student_code' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('student_code', $request->student_code)
            ->where('role', 'murid')
            ->first();

        if (!$user) {
            return back()->with('error', 'Kode siswa tidak ditemukan');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password salah');
        }

        // 🔥 LOGIN LARAVEL
        Auth::login($user);

        // 🔥 REGENERATE SESSION (AMAN)
        $request->session()->regenerate();

        // 🔥 LANGSUNG KE CHAT (bukan curhat lagi)
        return redirect('/chat')->with('success', 'Login berhasil!');
    }

    // ======================
    // LUPA PASSWORD
    // ======================
    public function showForgotPassword()
    {
        return view('forgot-password');
    }

   public function resetPassword(Request $request)
{
    $request->validate([
        'student_code' => 'required',
        'password' => 'required|min:3'
    ]);

    $user = \App\Models\User::where('student_code', $request->student_code)->first();

    if (!$user) {
        return back()->with('error', 'Kode siswa tidak ditemukan');
    }

    $user->password = bcrypt($request->password);
    $user->save();

    return back()->with('success', 'Password berhasil diubah');
}

    // ======================
    // LOGOUT
    // ======================
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/student-login')->with('success', 'Logout berhasil');
    }
}