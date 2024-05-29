<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctors';

    protected $fillable = [

        'type',
        'email',
        'first_name',
        'last_name',
        'age',
        'mobile',
        'gender',
        'profile_pic',
        'address',
        'location',
        'state',
        'mbbs_registration_certificate',
        'mbbs_certificate_number',
        'year_of_passing_out_mbbs',
        'additional_registration_certificate',
        'additional_registration_certificate_number',
        'degree_certificate',
        'year_of_passing_out_degree',
        'registration_council',
        'pg_certificate',
        'pg_certificate_number',
        'year_of_passing_out_pg',
        'institution',
        'experience_if_any',
        'department_name',
        'attachment',
        'status',
        'is_verified',
        'experience_file',
        'consultation_fee',
        'commission_percentage',
        'commission_amount',

    ];

    public $timestamps = false;
}
