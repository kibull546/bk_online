<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // ❌ JANGAN PAKAI __construct middleware (sudah di routes)
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    // ======================
    // HALAMAN CHAT
    // ======================
    public function index()
    {
        return view('curhat');
    }

    // ======================
    // SEND CHAT
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

            $guru = User::where('role', 'guru')->first();

            Chat::create([
                'user_id' => $user->id,
                'guru_id' => $guru->id ?? null,
                'message' => $request->message,
                'sender' => 'siswa'
            ]);
        }

        // ======================
        // GURU
        // ======================
        else {

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
    // FETCH CHAT
    // ======================
    public function fetch(Request $request)
    {
        $user = Auth::user();

        if ($user->role == 'murid') {

            $chats = Chat::where('user_id', $user->id)
                ->orderBy('created_at', 'asc')
                ->get();

        } else {

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
    // DELETE CHAT (AMAN + FIX FINAL)
    // ======================
    public function delete($id)
    {
        $chat = Chat::find($id);

        if (!$chat) {
            return response()->json(['status' => 'error'], 404);
        }

        $user = Auth::user();

        // SISWA hanya bisa hapus pesan sendiri
        if ($user->role == 'murid') {

            if ($chat->user_id == $user->id && $chat->sender == 'siswa') {
                $chat->delete();
                return response()->json(['status' => 'ok']);
            }
        }

        // GURU hanya bisa hapus pesan sendiri
        if ($user->role == 'guru') {

            if ($chat->guru_id == $user->id && $chat->sender == 'guru') {
                $chat->delete();
                return response()->json(['status' => 'ok']);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Tidak diizinkan'
        ], 403);
    }
}