<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    private function canAccess(Conversation $conversation): bool
    {
       $supportId = auth()->id();
       if($conversation->status !== 'open') return true;
       if($conversation->support_id === null) return true;
         return $conversation->support_id === $supportId;
    }
    public function show(Conversation $conversation)
    {
        if (!$this->canAccess($conversation)) {
            abort(403, 'Unauthorized action.');
        }

        $conversation->load(['customer:id,name,email', 'support:id,name,email', 'ticket', 'ticket.attachments']);

         $messages = Message::where('conversation_id', $conversation->id)
            ->with('sender:id,name,role')
            ->orderBy('created_at')
            ->get();

        return view('support.conversations.show', compact('conversation', 'messages'));
    }
    public function take(Conversation $conversation)
    {
        if ($conversation->type !== 'direct' && $conversation->type !== 'ticket') abort(400);

        if ($conversation->support_id && $conversation->support_id !== auth()->id()) {
            return back()->withErrors('Conversation already taken');
        }

        $conversation->support_id = auth()->id();
        $conversation->save();

        // If linked to ticket, assign it too
        if ($conversation->ticket) {
            $ticket = $conversation->ticket;
            if ($ticket->assigned_to === null) {
                $ticket->assigned_to = auth()->id();
                $ticket->save();
            }
        }

        return back()->with('success', 'Taken');
    }

    public function send(Request $request, Conversation $conversation)
    {
        if (!$this->canAccess($conversation)) abort(403);
        if ($conversation->status !== 'open') return back()->withErrors('Conversation closed');

        // Require taking it first (recommended)
        if ($conversation->support_id === null) {
            return back()->withErrors('Take the conversation first');
        }

        $data = $request->validate([
            'content' => ['required','string','max:5000'],
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => auth()->id(),
            'content' => $data['content'],
        ]);

        $conversation->touch();

        return back();
    }

    public function close(Conversation $conversation)
    {
        if (!$this->canAccess($conversation)) abort(403);

        $conversation->status = 'closed';
        $conversation->save();

        return back()->with('success', 'Closed');
    }
}
