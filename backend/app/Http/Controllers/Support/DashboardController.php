<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Ticket;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $supportId = auth()->id();
        $liveChats = Conversation::where('type', 'direct')
        ->where('status', 'open')
         ->where(function ($q) use ($supportId) {
                $q->whereNull('support_id')->orWhere('support_id', $supportId);
            })
            ->with('customer:id,name,email')
            ->orderByDesc('updated_at')
            ->paginate(15, ['*'], 'live');
        $tickets = Ticket::whereIn('status', ['open','in_progress'])
            ->with(['customer:id,name,email', 'assignee:id,name,email', 'conversation'])
            ->orderByDesc('updated_at')
            ->paginate(15, ['*'], 'tickets');    
    
        return view('support.dashboard', compact('liveChats', 'tickets'));
            }
}
