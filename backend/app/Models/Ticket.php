<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'customer_id',
        'assigned_to',
        'title',
        'description',
        'status',
        'priority'
    ];
    public function customer(){
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function assignee(){
        return $this->belongsTo(User::class, 'assigned_to');
    }
    public function assigned(){
        return $this->assignee();
    }
    public function attachments(){
        return $this->hasMany(TicketAttachment::class);
    }
    public function conversation(){
        return $this->hasOne(Conversation::class);
    }
    public function conversations(){
        return $this->hasMany(Conversation::class);
    }

}
