<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request,Conversation $conversation)
    {
        $this->authorizezConversation($request,$conversation);    

        $messages = Message::where('conversation_id',$conversation->id)
            ->with('sender:id,name,email')
            ->orderBy('created_at')
            ->paginate(50);

        return response()->json([
            'messages' => $messages
        ]);
    }
    public function store(Request $request,Conversation $conversation)
    {
        $this->authorizezConversation($request,$conversation);    
        
        if ($conversation->status !== 'open') {
            return response()->json(['message' => 'Conversation is closed'], 409);
        }

        $request->validate([
            'content' => 'required|string|max:2000',
        ]);
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $request->user()->id,
            'content' => $request->input('content'),
        ]);

        // Update conversation's updated_at timestamp
        $conversation->touch();

        return response()->json([
            'message' => $message->load('sender:id,name,email')
        ],201);
    }
    private function authorizezConversation(Request $request,Conversation $conversation){
        $user = $request->user();
        if($user->role ==='customer' && $conversation->customer_id !== $user->id){
            abort(403, 'You do not have access to this conversation.');
        }
        if($user->role ==='support'){
            if($conversation->type ==='direct'){
                if($conversation->status ==='open'){
                    if($conversation->support_id !== null && $conversation->support_id !== $user->id){
                        abort(403, 'You do not have access to this conversation.');
                    }
                }
            }
        }
    }
}
