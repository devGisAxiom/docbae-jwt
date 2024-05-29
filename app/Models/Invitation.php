<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $table = 'invitations';

    protected $fillable = [

        'user_type',
        'patient_id',
        'member_id',
        'doctor_id',
        'meeting_date',
        'meeting_time',
        'status',
        'created_at',
        'transaction_id',
        'consultation_fee',
        'commission_percentage',
        'commission_amount',
        'doctors_fee',
        'fund_released',
        'released_date',

    ];

    public $timestamps = false;

    public function patient(){

    	return $this->belongsTo(Patient::class,'patient_id','id');
    }

    public function members(){

    	return $this->belongsTo(Member::class,'member_id','id');
    }
    public function doctor(){

    	return $this->belongsTo(Doctor::class,'doctor_id','id');
    }

}
