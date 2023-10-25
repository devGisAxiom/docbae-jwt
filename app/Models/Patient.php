<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';

    protected $fillable = [

        'first_name',
        'last_name',
        'mobile',
        'token',
        'device_type',
        'is_deleted',

    ];

    public $timestamps = false;
}
