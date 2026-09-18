<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // မက်ဆေ့ဂျ်များ အားလုံးကို ထုတ်ယူရန် (API)
    public function fetchMessages()
    {
        $userId = Auth::id();
        $chats = Chat::where('user_id', $userId)->orderBy('created_at', 'asc')->get();
        return response()->json(['status' => 'success', 'chats' => $chats]);
    }

    // မက်ဆေ့ဂျ် အသစ် ပို့ရန် (API)
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $chat = Chat::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'sender_type' => 'user',
        ]);

        return response()->json(['status' => 'success', 'chat' => $chat]);
    }
}