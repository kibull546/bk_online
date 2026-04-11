<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CurhatController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LoginAdminController;
use App\Models\Curhat;

/* ======================
   HALAMAN BERANDA
====================== */
Route::get('/', function () {
    return view('welcome');
});

/* ======================
   CURHAT SISWA
====================== */
Route::get('/curhat', [CurhatController::class, 'index']);
Route::post('/curhat', [CurhatController::class, 'store']);

/* ======================
   CEK STATUS DENGAN KODE UNIK
====================== */
Route::get('/status-anonim', function () {
    return view('status-anonim-form');
});

Route::post('/status-anonim/cek', function (\Illuminate\Http\Request $request) {
    $data = Curhat::where('kode_unik', $request->kode)->get();

    if ($data->isEmpty()) {
        return redirect('/status-anonim')->with('error', 'Kode curhat tidak valid');
    }

    return view('status-anonim', compact('data'));
});

Route::get('/status-anonim/{kode}', [CurhatController::class, 'statusAnonim']);

/* ======================
   LOGIN GURU
====================== */
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);

/* ======================
   LOGIN ADMIN
====================== */
Route::get('/login-admin', [LoginAdminController::class, 'index']);
Route::post('/login-admin', [LoginAdminController::class, 'login']);
Route::get('/logout-admin', [LoginAdminController::class, 'logout']);

/* ======================
   DASHBOARD GURU
====================== */
Route::get('/dashboard', [CurhatController::class, 'dashboard']);
Route::post('/balas/{id}', [CurhatController::class, 'balas']);

/* ======================
   DASHBOARD ADMIN
====================== */
Route::get('/dashboard-admin', function () {

    if (!Auth::check() || Auth::user()->role != 'admin') {
        return redirect('/login-admin');
    }

    $data = Curhat::latest()->get();
    return view('dashboard-admin', compact('data'));
});

/* ======================
   HAPUS CURHAT
====================== */
Route::post('/hapus/{id}', [CurhatController::class, 'hapus'])->name('hapus');

/* ======================
   HALAMAN TAMBAHAN
====================== */
Route::get('/konsultasi', function () {
    return view('konsultasi');
});

Route::get('/monitoring', function () {
    return view('monitoring');
});

/* ======================
   CEK KODE DARI DASHBOARD
====================== */
Route::post('/cek-kode', [CurhatController::class, 'cekKode'])->name('cek-kode');
