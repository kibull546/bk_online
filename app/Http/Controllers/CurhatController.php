<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curhat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CurhatController extends Controller
{
    public function index()
    {
        $data = Curhat::latest()->get();
        return view('curhat', compact('data'));
    }

    public function store(Request $request)
    {
        $kode = strtoupper(Str::random(6)); // kode 6 karakter

        $curhat = new Curhat();
        $curhat->nama = $request->nama;
        $curhat->pesan = $request->pesan;
        $curhat->kategori = $request->kategori;
        $curhat->status = 'menunggu';
        $curhat->kode_unik = $kode;
        $curhat->save();

        return redirect('/curhat')->with('success', "Curhat terkirim! Simpan kode ini: $kode");
    }

    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $data = Curhat::latest()->get();
        $total = Curhat::count();
        $dibalas = Curhat::where('status', 'dibalas')->count();
        $menunggu = Curhat::where('status', 'menunggu')->count();

        return view('dashboard', compact('data', 'total', 'dibalas', 'menunggu'));
    }

    public function cekKode(Request $request)
    {
        $curhat = Curhat::where('kode_unik', $request->kode_unik)->first();

        if (!$curhat) {
            return redirect('/dashboard')->with('error', 'Kode unik tidak valid');
        }

        return view('cek-curhat', compact('curhat'));
    }

    public function balas(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $curhat = Curhat::find($id);

        $curhat->balasan = $request->balasan;
        $curhat->status = "dibalas";
        $curhat->save();

        return redirect('/dashboard');
    }

    public function hapus($id)
    {
        $curhat = Curhat::find($id);
        if ($curhat) {
            $curhat->delete();
        }
        return redirect()->back()->with('success', 'Curhat berhasil dihapus!');
    }


    public function statusAnonim($kode)
    {
        $data = Curhat::where('kode_unik', $kode)->get();

        if ($data->isEmpty()) {
            return redirect('/')->with('error', 'Kode curhat tidak valid');
        }

        return view('status-anonim', compact('data'));
    }



}

