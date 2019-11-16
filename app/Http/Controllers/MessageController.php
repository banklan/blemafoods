<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function sendMessage(Request $request)
    {
        $user = Auth::id();

        $this->validate($request, [
            'message' => 'required'
        ]);

        $message = new Message;
        $message->sender_id = $user;
        $message->receiver_id = 1;
        $message->message = $request->message;
        $message->status = 0;
        $message->save();

        return response()->json($message, 200);
    }

    public function getMessages()
    {
        $user = Auth::id();

        $messages = Message::where('sender_id', $user)->orWhere('receiver_id', $user)->get();

        return response()->json($messages, 200);
    }

    public function getUnreadMessages()
    {
        $user = Auth::id();

        $unreads = Message::where(['receiver_id' => $user, 'status' => 0])->count();

        return response()->json($unreads, 200);
    }

    public function resetUnreadMsgs()
    {
        $user = Auth::id();

        $unreads = Message::where(['receiver_id' => $user, 'status' => 0])->get();

        foreach ($unreads as $unread) {
            $unread->update([
                $unread->status = 1
            ]);
        }

        return response()->json($unreads, 200);
    }
}
