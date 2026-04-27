<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ChatController extends Controller
{
    // 🔥 WAJIB: proteksi semua function
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ======================
    // HALAMAN CHAT
    // ======================
    public function index()
    {
        return view('curhat');
    }

    // ======================
    // KIRIM PESAN
    // ======================
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $user = Auth::user();

        // ======================
        // SISWA
        // ======================
        if ($user->role == 'murid') {

            // ambil guru pertama (biar konsisten)
            $guru = User::where('role', 'guru')->first();

            if (!$guru) {
                return response()->json(['error' => 'guru tidak tersedia']);
            }

            Chat::create([
                'user_id' => $user->id,
                'guru_id' => $guru->id,
                'message' => $request->message,
                'sender' => 'siswa'
            ]);

        }

        // ======================
        // GURU
        // ======================
        else {

            if (!$request->student_id) {
                return response()->json(['error' => 'Pilih siswa dulu']);
            }

            Chat::create([
                'user_id' => $request->student_id,
                'guru_id' => $user->id,
                'message' => $request->message,
                'sender' => 'guru'
            ]);
        }

        return response()->json(['status' => 'ok']);
    }

    // ======================
    // AMBIL CHAT
    // ======================
    public function fetch(Request $request)
    {
        $user = Auth::user();

        // ======================
        // SISWA
        // ======================
        if ($user->role == 'murid') {

            $chats = Chat::where('user_id', $user->id)
                ->orderBy('created_at', 'asc')
                ->get();

        }

        // ======================
        // GURU
        // ======================
        else {

            if (!$request->student_id) {
                return response()->json([]);
            }

            $chats = Chat::where('user_id', $request->student_id)
                ->where('guru_id', $user->id)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return response()->json($chats);
    }

    // ======================
    // HAPUS PESAN
    // ======================
    public function delete($id)
    {
        $chat = Chat::find($id);

        if (!$chat) {
            return response()->json(['error' => 'Pesan tidak ditemukan'], 404);
        }

        $user = Auth::user();

        // SISWA: bisa hapus pesan siswa mereka sendiri
        if ($user->role == 'murid' && $chat->user_id == $user->id && $chat->sender == 'siswa') {
            $chat->delete();
            return response()->json(['status' => 'ok']);
        }

        // GURU: bisa hapus pesan guru mereka sendiri
        if ($user->role == 'guru' && $chat->guru_id == $user->id && $chat->sender == 'guru') {
            $chat->delete();
            return response()->json(['status' => 'ok']);
        }

        return response()->json(['error' => 'Tidak bisa hapus pesan orang lain'], 403);
    }
}