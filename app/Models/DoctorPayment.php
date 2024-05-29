<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorPayment extends Model
{
    use HasFactory;

    protected $table = 'doctor_payments';

    protected $fillable = [

        'doctor_id',
        'total_amount',
        'date',

    ];

    public $timestamps = false;

    public function doctor(){

    	return $this->belongsTo(Doctor::class,'doctor_id','id');
    }

}
