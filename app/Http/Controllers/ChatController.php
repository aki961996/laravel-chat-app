<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {

        try {
            $msg = Message::create([
                'sender_id' => auth()->id(),
                'receiver_id' => $request->receiver_id,
                'message' => $request->message,
            ]);
            if ($msg) {
                //broadcast(new MessageSent)
                MessageSent::dispatch($msg);
                return response()->json([
                    'status' => true,
                    'message' => 'Message sent successfully'
                ], 201);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Something Went Wrong: ' . $e->getMessage(),
            ], 201);
        }
    }
}
