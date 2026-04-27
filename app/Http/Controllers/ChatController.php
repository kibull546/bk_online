<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        return view('curhat');
    }

    // SEND
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $user = Auth::user();

        if ($user->role == 'murid') {

            $guru = User::where('role', 'guru')->first();

            Chat::create([
                'user_id' => $user->id,
                'guru_id' => $guru->id ?? null,
                'message' => $request->message,
                'sender' => 'siswa'
            ]);

        } else {

            Chat::create([
                'user_id' => $request->student_id,
                'guru_id' => $user->id,
                'message' => $request->message,
                'sender' => 'guru'
            ]);
        }

        return response()->json(['status' => 'ok']);
    }

    // FETCH (FIX TIME WA STYLE)
    public function fetch(Request $request)
    {
        $user = Auth::user();

        if ($user->role == 'murid') {

            $chats = Chat::where('user_id', $user->id)
                ->where('deleted_by_siswa', false)
                ->orderBy('created_at', 'asc')
                ->get();

        } else {

            $chats = Chat::where('user_id', $request->student_id)
                ->where('guru_id', $user->id)
                ->where('deleted_by_guru', false)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        // 🔥 TAMBAH JAM KIRIM FIX
        foreach ($chats as $c) {
            $c->time = $c->created_at->format('H:i');
        }

        return response()->json($chats);
    }

    // DELETE 1 PESAN (GLOBAL HILANG)
    public function delete($id)
    {
        $chat = Chat::find($id);

        if (!$chat) return response()->json(['status' => 'error']);

        $chat->delete(); // 🔥 GLOBAL DELETE

        return response()->json(['status' => 'ok']);
    }

    // CLEAR VIEW ONLY
    public function clearAll(Request $request)
    {
        $user = Auth::user();

        if ($user->role == 'murid') {
            Chat::where('user_id', $user->id)
                ->update(['deleted_by_siswa' => true]);
        } else {
            Chat::where('guru_id', $user->id)
                ->update(['deleted_by_guru' => true]);
        }

        return response()->json(['status' => 'ok']);
    }
}