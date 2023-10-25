<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingDetails extends Model
{
    use HasFactory;

    protected $table = 'meeting_details';

    protected $fillable = [

        'doctor_id',
        'patient_id',
        'meeting_id',
        'invitation_id',
        'token',
        'created_at',
        'status',

    ];

    public $timestamps = false;

}
