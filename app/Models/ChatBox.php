<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatBox extends Model
{
    use HasFactory;

    protected $table = 'chat_box';

    protected $fillable = [

        'invitation_id',
        'user_type',
        'user_id',
        'type',
        'messages',
        'file_name',
        'created_at',
    ];

}
