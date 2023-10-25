<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctors';

    protected $fillable = [

        'first_name',
        'last_name',
        'email',
        'mobile',
        'token',
        'device_type',
        'language',
        'status',
        'image',
        'status_dt_from',
        'status_dt_to',
        'is_deleted',
        'state',
        'location',

    ];

    public $timestamps = false;
}
