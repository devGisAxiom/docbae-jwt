<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $table = 'consultations';

    protected $fillable = [
        'meeting_id',
        'patient_id',
        'doctor_id',
        'symptoms',
        'intensity',
        'description',
    ];

    public $timestamps = false;
}
