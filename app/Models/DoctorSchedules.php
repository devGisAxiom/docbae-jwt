<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSchedules extends Model
{
    use HasFactory;
    protected $table = 'doctor_schedules';

    protected $fillable = [
        'doctor_id',
        'available_time',
        'day_of_week',
        'time_from',
        'time_to',
        'duration',
        'status',
        'created_at',

    ];

    public function doctor(){

    	return $this->belongsTo(Doctor::class,'doctor_id','id');
    }

    public $timestamps = false;
}
