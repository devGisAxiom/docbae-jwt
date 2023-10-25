<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;
    protected $table = 'invitations';

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'meeting_time',
        'status',
        'created_at',

    ];

    public $timestamps = false;
}
