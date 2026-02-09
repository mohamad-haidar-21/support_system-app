<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function createDirect(Request $request){
        $user= $request->user();
        if($user->role !== 'customer'){
            return response()->json([
                'message' => 'You do not have permission to create a direct conversation.'
            ], 403);
        }
        $existing = Conversation::where('type','direct')
        ->where('customer_id','=',$user->id)
        ->where('status','=','open')
        ->first();
        if($existing){
            return response()->json([
                'conversation' => $existing], 200);
        }
        $conversation = Conversation::create([
            'type' => 'direct',
            'customer_id' => $user->id,
            'support_id' => null,
            'ticket_id' => null,
            'status' => 'open',
        ]);
        return response()->json([
            'conversation' => $conversation
        ], 201);
    }
    public function index(Request $request){
        $user = $request->user();
        $query = Conversation::query()
            ->with(['customer:id,name,email', 'support:id,name,email'])
            ->orderByDesc('updated_at');

        if ($user->role === 'customer') {
            $query->where('customer_id', $user->id);
        } elseif ($user->role === 'support') {
            // show open direct chats (unassigned + assigned to me)
            $query->where('type', 'direct')
                ->where('status', 'open')
                ->where(function ($q) use ($user) {
                    $q->whereNull('support_id')
                      ->orWhere('support_id', $user->id);
                });
        } else { // admin
            $query->where('type', 'direct');
        }

        return response()->json([
            'conversations' => $query->paginate(20)
        ]);
    }
    public function take(Request $request, Conversation $conversation)
    {
        $user = $request->user();

        if ($user->role !== 'support') {
            return response()->json(['message' => 'Only support can take chats'], 403);
        }

        if ($conversation->type !== 'direct') {
            return response()->json(['message' => 'Only direct chats can be taken here'], 400);
        }

        if ($conversation->status !== 'open') {
            return response()->json(['message' => 'Conversation is closed'], 409);
        }

        // If already taken by another support agent
        if ($conversation->support_id && $conversation->support_id !== $user->id) {
            return response()->json(['message' => 'Conversation already taken'], 409);
        }

        $conversation->support_id = $user->id;
        $conversation->save();

        return response()->json(['conversation' => $conversation]);
    }
    public function show(Request $request, Conversation $conversation)
    {
        $user = $request->user();

        if ($user->role === 'customer' && $conversation->customer_id !== $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        if ($user->role === 'support') {
            // support can only open direct chats (unassigned or assigned to them)
            if ($conversation->type === 'direct' && $conversation->status === 'open') {
                if ($conversation->support_id && $conversation->support_id !== $user->id) {
                    return response()->json(['message' => 'Forbidden'], 403);
                }
            }
        }

        return response()->json([
            'conversation' => $conversation->load(['customer:id,name,email', 'support:id,name,email'])
        ]);
    }

    // Close conversation (support or customer)
    public function close(Request $request, Conversation $conversation)
    {
        $user = $request->user();

        $isCustomerOwner = $user->role === 'customer' && $conversation->customer_id === $user->id;
        $isSupportOwner = $user->role === 'support' && ($conversation->support_id === null || $conversation->support_id === $user->id);

        if (!$isCustomerOwner && !$isSupportOwner && $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $conversation->status = 'closed';
        $conversation->save();

        return response()->json(['conversation' => $conversation]);
    }


    
}

