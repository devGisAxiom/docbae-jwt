<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReassignedInvitation extends Model
{
    use HasFactory;

    protected $table = 'reassigned_invitations';

    protected $fillable = [

        'doctor_id',
        'invitation_id',
        'reassigned_to',
        'date_time',

    ];

    public $timestamps = false;
}
