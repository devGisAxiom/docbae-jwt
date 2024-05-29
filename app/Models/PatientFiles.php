<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientFiles extends Model
{
    use HasFactory;

    protected $table = 'patient_files';

    protected $fillable = [

        'patient_id',
        'file_name',
        'file_description',
        'meeting_id',
        'status',

    ];

    public $timestamps = false;

}
