<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingTimelime extends Model
{
    use HasFactory;

    protected $table = 'meeting_timelime';

    protected $fillable = [

        'meeting_id',
        'created_at',
        'duration',
        'notes',
        'is_deleted',

    ];

    public $timestamps = false;
}
