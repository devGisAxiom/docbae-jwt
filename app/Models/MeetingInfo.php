<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingInfo extends Model
{
    use HasFactory;

    protected $table = 'meeting_info';

    protected $fillable = [

        'meeting_id',
        'invitation_id',
        'chief_complaints',
        'diagnosis',
        'points_from_history',
        'lab_findings',
        'investigations',
        'instructions',
        'notes',
        'status',
        'created_at',

    ];

    public $timestamps = false;



}
