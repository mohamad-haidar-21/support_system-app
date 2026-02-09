<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Conversation;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();
        if($user->role !== 'customer'){
            return response()->json(['error' => 'only customers can create tickets'], 403);
        }
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ]);
        $ticket = Ticket::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'priority' => $data['priority'],
            'customer_id' => $user->id,
            'assigned_to' => null,
            'status' => 'open',
        ]);
        $conversation = Conversation::create([
            'type' => 'ticket',
            'customer_id' => $user->id,
            'support_id' => null,
            'ticket_id' => $ticket->id,
            'status' => 'open',
        ]);
        return response()->json(['ticket' => $ticket, 'conversation' => $conversation], 201);
    }
    public function myTickets(Request $request)
    {
        $user = $request->user();
        if($user->role !== 'customer'){
            return response()->json(['error' => 'only customers can view their tickets'], 403);
        }
        $tickets = Ticket::where('customer_id', $user->id)->with(['attachments', 'conversation'])
            ->orderByDesc('updated_at')
            ->paginate(20);
        return response()->json(['tickets' => $tickets], 200);
    }
    public function index(Request $request){

    $user = $request->user(); 
    if(!in_array($user->role, ['support', 'admin'], true)){
        return response()->json(['error' => 'Forbidden'], 403);
    }
    $query = Ticket::query()->with(['customer:id,name,email', 'assigned:id,name,email', 'attachments', 'conversation'])->orderByDesc('updated_at');
    if($request->filled('status')){
        $query->where('status', $request->input('status'));
    }
    if($request->filled('priority')){
        $query->where('priority', $request->input('priority'));
    }
    if ($request->filled('unassigned') && $request->unassigned == 1) {
        $query->whereNull('assigned_to');
    }
    return response()->json(['tickets' => $query->paginate(20)], 200);
    }
    // Ticket details (customer owner OR support/admin)
    public function show(Request $request, Ticket $ticket)
    {
        $user = $request->user();

        if ($user->role === 'customer' && $ticket->customer_id !== $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        if ($user->role === 'support') {
            // support can view, but if assigned_to exists and not me, you can decide:
            // For MVP, allow support to view all.
        }

        return response()->json([
            'ticket' => $ticket->load(['attachments', 'conversation', 'customer:id,name,email', 'assignee:id,name,email'])
        ]);
    }

    // Support: take/assign ticket to self (also take the ticket conversation)
    public function take(Request $request, Ticket $ticket)
    {
        $user = $request->user();
        if ($user->role !== 'support') {
            return response()->json(['message' => 'Only support can take tickets'], 403);
        }

        if ($ticket->assigned_to && $ticket->assigned_to !== $user->id) {
            return response()->json(['message' => 'Ticket already assigned'], 409);
        }

        $ticket->assigned_to = $user->id;
        $ticket->save();

        // Also set support_id on conversation if exists
        $conversation = $ticket->conversation;
        if ($conversation && $conversation->support_id === null) {
            $conversation->support_id = $user->id;
            $conversation->save();
        }

        return response()->json(['ticket' => $ticket->load(['conversation'])]);
    }

    // Support: update ticket status
    public function updateStatus(Request $request, Ticket $ticket)
    {
        $user = $request->user();
        if ($user->role !== 'support') {
            return response()->json(['message' => 'Only support can update status'], 403);
        }

        $data = $request->validate([
            'status' => ['required', Rule::in(['open','in_progress','resolved','closed'])],
        ]);

        // Optional rule: support must have taken it first
        if ($ticket->assigned_to && $ticket->assigned_to !== $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $ticket->status = $data['status'];
        $ticket->save();

        // If ticket closed, you may close conversation too
        if ($ticket->status === 'closed' && $ticket->conversation) {
            $ticket->conversation->status = 'closed';
            $ticket->conversation->save();
        }

        return response()->json(['ticket' => $ticket]);
    }

}
