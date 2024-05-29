<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperSpeciality extends Model
{
    use HasFactory;

    protected $table = 'super_specialities';

    protected $fillable = [

        'super_speciality',
        'status',

    ];

    public $timestamps = false;
}
