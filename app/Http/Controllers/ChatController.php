<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function getUsers()
{
    $userId = Auth::id(); 

    $users = DB::table('users')
        ->where('id', '!=', $userId) 
        ->select('id', 'username')
        ->get();

    foreach ($users as $user) {
        $user->unread_count = DB::table('messages')
            ->where('sender_id', $user->id)
            ->where('receiver_id', $userId)
            ->where('status', 'unread')
            ->count();
    }

    return response()->json($users);
}


    public function getMessages(Request $request)
    {
        $userId = Auth::id(); 
        $recipientId = $request->input('recipient_id'); 
    
        $messages = DB::table('messages')
            ->where(function ($query) use ($userId, $recipientId) {
                $query->where('sender_id', $userId)->where('receiver_id', $recipientId);
            })
            ->orWhere(function ($query) use ($userId, $recipientId) {
                $query->where('sender_id', $recipientId)->where('receiver_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get();
    
        return response()->json($messages);
    }
    public function sendMessage(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|integer',
            'message' => 'required|string|max:500',
        ]);
    
        $message = DB::table('messages')->insert([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->recipient_id,
            'message' => $request->message,
            'status' => 'unread',
            'created_at' => now(),
        ]);
    
        if ($message) {
            return response()->json(['success' => true, 'message' => 'Message sent successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to send message'], 500);
        }
    }
    
    public function markMessagesRead(Request $request)
    {
        $userId = Auth::id();
        $senderId = $request->input('sender_id');
    
        DB::table('messages')
            ->where('sender_id', $senderId)
            ->where('receiver_id', $userId)
            ->where('status', 'unread')
            ->update(['status' => 'read']);
    
        return response()->json(['success' => true]);
    }
    
}
