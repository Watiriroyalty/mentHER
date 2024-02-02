<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'requester_id', 'recipient_id', 'message', 'status', 'proposed_datetime',
    ];
}
