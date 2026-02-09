<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class TicketController extends Controller
{
   public function show(Ticket $ticket)
    {
        $ticket->load(['customer:id,name,email', 'assignee:id,name,email', 'attachments', 'conversation']);
        if (!$ticket->conversation) {
            $conversation = $ticket->conversation()->create([
                'type' => 'ticket',
                'customer_id' => $ticket->customer_id,
                'support_id' => $ticket->assigned_to,
                'status' => $ticket->status === 'closed' ? 'closed' : 'open',
            ]);
            $ticket->setRelation('conversation', $conversation);
        }
        return view('support.tickets.show', compact('ticket'));
    }

    public function status(Request $request, Ticket $ticket)
    {
        // require same support agent if already assigned
        if ($ticket->assigned_to && $ticket->assigned_to !== auth()->id()) {
            abort(403);
        }

        $data = $request->validate([
            'status' => ['required', Rule::in(['open','in_progress','resolved','closed'])],
        ]);

        $ticket->status = $data['status'];
        if ($ticket->assigned_to === null) $ticket->assigned_to = auth()->id();
        $ticket->save();

        // close conversation if closed
        if ($ticket->status === 'closed' && $ticket->conversation) {
            $ticket->conversation->status = 'closed';
            $ticket->conversation->save();
        }

        return back()->with('success', 'Status updated');
    } 
}
