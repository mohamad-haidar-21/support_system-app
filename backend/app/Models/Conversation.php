<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        'type',
        'customer_id',
        'support_id',
        'ticket_id',
        'status'
        ];
    public function customer(){
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function support(){
        return $this->belongsTo(User::class, 'support_id');
    }
    public function ticket(){
        return $this->belongsTo(Ticket::class);

    }
    public function messages(){
        return $this->hasMany(Message::class);
    }
}

