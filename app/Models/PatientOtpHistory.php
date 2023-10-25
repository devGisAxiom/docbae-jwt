<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientOtpHistory extends Model
{
    use HasFactory;

    protected $table = 'patient_otp_history';

    protected $fillable = [

        'user_id',
        'otp',
        'is_used',

    ];

    public $timestamps = false;

}
