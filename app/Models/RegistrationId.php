<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationId extends Model
{
    use HasFactory;

    protected $table = 'registration_ids';

    protected $fillable = [

        'patient_id',
        'member_id',
        'user_type',
        'unique_id',

    ];

    public $timestamps = false;
}
