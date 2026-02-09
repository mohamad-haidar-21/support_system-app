<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketAttachment extends Model
{
    protected $fillable = [
        'ticket_id',
        'attachment_type',
        'file_path',
        'file_name',
        'original_name',
        'mime_type',
        'size_bytes',
        'duration_seconds'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
