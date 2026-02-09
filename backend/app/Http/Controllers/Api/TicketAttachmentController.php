<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TicketAttachmentController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        $user = $request->user();

        // Only ticket owner can upload attachments (MVP)
        if ($user->role !== 'customer' || $ticket->customer_id !== $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $request->validate([
            'type' => ['required', Rule::in(['image','video','audio'])],
            'file' => ['required','file'],
        ]);

        // Size limits (adjust later)
        $maxBytes = match ($request->type) {
            'image' => 5 * 1024 * 1024,
            'audio' => 10 * 1024 * 1024,
            'video' => 100 * 1024 * 1024,
        };

        if ($request->file('file')->getSize() > $maxBytes) {
            return response()->json(['message' => 'File too large'], 422);
        }

        // Optional: basic mime checks
        $allowedMimes = match ($request->type) {
            'image' => ['image/jpeg','image/png','image/webp'],
            'audio' => ['audio/mpeg','audio/mp3','audio/aac','audio/mp4','audio/x-m4a','audio/m4a','audio/wav'],
            'video' => ['video/mp4','video/quicktime','video/x-m4v'],
        };

        $mime = $request->file('file')->getMimeType();
        if ($mime && !in_array($mime, $allowedMimes, true)) {
            return response()->json(['message' => 'Invalid file type'], 422);
        }

        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension() ?: 'bin';
        $name = Str::uuid() . '.' . $ext;

        // store in storage/app/public/tickets/{ticket_id}
        $path = $file->storeAs("public/tickets/{$ticket->id}", $name);

        $attachment = TicketAttachment::create([
            'ticket_id' => $ticket->id,
            'type' => $request->type,
            'file_path' => Str::replaceFirst('public/', 'storage/', $path), // for public access
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $mime,
            'size_bytes' => $file->getSize(),
        ]);

        return response()->json(['attachment' => $attachment], 201);
    }
}
