<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingAdditionalInfo extends Model
{
    use HasFactory;

    protected $table = 'meeting_additional_info';

    protected $fillable = [

        'meeting_id',
        'session_id',
        'file_url',
        'created_at',

    ];

    public $timestamps = false;
}
