<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curhat;
use Illuminate\Support\Facades\Auth;

class CurhatController extends Controller
{
    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        $role = Auth::user()->role;
        
        // Hitung statistik curhat
        $total = Curhat::count();
        $dibalas = Curhat::where('status', 'dibalas')->count();
        $menunggu = Curhat::where('status', 'menunggu')->count();
        $data = Curhat::orderBy('created_at', 'asc')->get();
        
        if ($role === 'guru') {
            // Jika ada view dashboard-guru.blade.php, gunakan itu. Jika tidak, fallback ke dashboard.blade.php
            if (view()->exists('dashboard-guru')) {
                return view('dashboard-guru', compact('total', 'dibalas', 'menunggu', 'data'));
            } else {
                return view('dashboard', compact('total', 'dibalas', 'menunggu', 'data'));
            }
        } elseif ($role === 'admin') {
            return view('dashboard-admin', compact('total', 'dibalas', 'menunggu', 'data'));
        } else {
            return view('dashboard', compact('total', 'dibalas', 'menunggu', 'data'));
        }
    }

    public function index()
    {
        if (!Auth::check() || Auth::user()->role != 'murid') {
            return redirect('/student-login');
        }

        // ambil semua chat
        $data = Curhat::orderBy('created_at', 'asc')->get();

        return view('curhat', compact('data'));
    }

    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->role != 'murid') {
            return redirect('/student-login');
        }

        $request->validate([
            'pesan' => 'required'
        ]);

        Curhat::create([
            'nama' => Auth::user()->name,
            'pesan' => $request->pesan,
            'kategori' => 'chat',
            'status' => 'menunggu',
        ]);

        return redirect('/curhat');
    }

    public function balas(Request $request, $id)
    {
        if (!Auth::check() || (Auth::user()->role != 'guru' && Auth::user()->role != 'admin')) {
            return redirect('/login');
        }

        $request->validate([
            'balasan' => 'required'
        ]);

        $curhat = Curhat::find($id);
        $curhat->balasan = $request->balasan;
        $curhat->status = "dibalas";
        $curhat->save();

        return redirect('/dashboard');
    }

    public function cekKode($kode_unik = null)
    {
        if (!Auth::check() || (Auth::user()->role != 'guru' && Auth::user()->role != 'admin')) {
            return redirect('/login');
        }

        // Handle POST request (form submission)
        if (request()->isMethod('post')) {
            request()->validate([
                'kode_unik' => 'required'
            ]);
            $kode_unik = request('kode_unik');
        }

        if (!$kode_unik) {
            return redirect('/dashboard')->with('error', 'Kode unik tidak valid');
        }

        $curhat = Curhat::where('kode_unik', $kode_unik)->first();

        if (!$curhat) {
            return redirect('/dashboard')->with('error', 'Kode unik tidak ditemukan');
        }

        return view('cek-curhat', compact('curhat'));
    }
}