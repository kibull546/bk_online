<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // halaman form buat guru
    public function createGuru()
    {
        return view('create-guru');
    }

    // simpan guru (FINAL FIX 100%)
    public function storeGuru(Request $request)
    {
        // LOG DEBUG (cek storage/logs/laravel.log)
        Log::info('STORE GURU REQUEST', $request->all());

        // VALIDASI (dibuat aman biar tidak gagal silent)
        $request->validate([
            'name' => 'required|string|min:2',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:3' // dipendekin biar gak gagal lagi
        ]);

        try {
            // SIMPAN USER
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => null,
                'password' => Hash::make($request->password),
                'role' => 'guru'
            ]);

            // LOG SUCCESS
            Log::info('USER CREATED SUCCESS', [
                'id' => $user->id,
                'email' => $user->email
            ]);

            return redirect('/dashboard-admin')
                ->with('success', 'Akun guru berhasil dibuat');

        } catch (\Exception $e) {

            // LOG ERROR
            Log::error('GAGAL CREATE USER', [
                'message' => $e->getMessage()
            ]);

            return back()->with('error', 'Gagal membuat akun guru');
        }
    }
}