<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthCardDetails extends Model
{
    use HasFactory;

    protected $table = 'health_card_details';

    protected $fillable = [

        'student_id',
        'institute_id',
        'fathers_name',
        'fathers_occupation',
        'mothers_name',
        'mothers_occupation',
        'email',
        'pincode',
        'additional_mobile',
        'family_physician_details',
        'physician_phone',
        'past_history',
        'remarks',
        'past_medical_history',
        'any_implant_accessories',
        'rt_and_lt',
        'hepatitis_given_on',
        'typhoid_given_on',
        'tetanus_given_on',
        'dt_polio_booster_given',
        'present_complaint',
        'current_medication',
        'created_at'

    ];

    public $timestamps = false;
}
