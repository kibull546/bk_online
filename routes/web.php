<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CurhatController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LoginAdminController;
use App\Http\Controllers\StudentLoginController;
use App\Http\Controllers\StudentImportController;
use App\Http\Controllers\ChatController;
use App\Models\Curhat;

/* ======================
   HALAMAN BERANDA
====================== */
Route::get('/', function () {
    return view('welcome');
});

/* ======================
   LOGIN SISWA
====================== */
Route::get('/student-login', [StudentLoginController::class, 'showLogin']);
Route::post('/student-login', [StudentLoginController::class, 'login']);
Route::get('/forgot-password', [StudentLoginController::class, 'showForgotPassword']);
Route::post('/reset-password', [StudentLoginController::class, 'resetPassword']);
Route::get('/student-logout', [StudentLoginController::class, 'logout']);

/* ======================
   CURHAT SISWA
====================== */
Route::get('/curhat', [CurhatController::class, 'index']);
Route::post('/curhat', [CurhatController::class, 'store']);



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
Route::post('/cek-kode', [CurhatController::class, 'cekKode'])->name('cek-kode');
Route::get('/cek-curhat/{kode_unik}', [CurhatController::class, 'cekKode']);
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
   ADMIN - IMPORT SISWA
====================== */
Route::get('/admin/import-students', [StudentImportController::class, 'showForm']);
Route::post('/admin/import-students', [StudentImportController::class, 'import']);
Route::get('/admin/download-template', [StudentImportController::class, 'downloadTemplate']);

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

Route::middleware(['auth'])->group(function () {

    Route::get('/chat', [ChatController::class, 'index']);
    Route::post('/chat/send', [ChatController::class, 'send']);
    Route::get('/chat/fetch', [ChatController::class, 'fetch']);

});

/* ======================
   GURU LIVE CHAT
====================== */
Route::get('/guru/chat', [ChatController::class, 'guruIndex'])->middleware('auth');
Route::get('/guru/chat/{userId}', [ChatController::class, 'guruChat'])->middleware('auth');

Route::get('/chat/{user_id}', [ChatController::class, 'index']);

//riwayat chat
Route::get('/riwayat-chat', function () {
    return view('riwayat-chat');
});

