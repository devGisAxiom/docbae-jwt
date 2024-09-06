<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';

    protected $fillable = [

        'patient_id',
        'parent_id',
        'user_type',
        'mobile',
        'grade_id',
        'image',
        'name',
        'dob',
        'gender',
        'relationship_id',
        'blood_group_id',
        'status',
        'unique_id',
        'created_at',
        'address',
        'height',
        'weight',
        'lmp',
    ];

    public $timestamps = false;

    public function blood_group(){

    	return $this->belongsTo(BloodGroup::class,'blood_group_id','id');
    }

    public function member(){

    	return $this->belongsTo(FamilyMemberRelation::class,'relationship_id','id');
    }

    public function grade(){

    	return $this->belongsTo(Grade::class,'grade_id','id');
    }

    public function patient(){

    	return $this->belongsTo(Patient::class,'patient_id','id');
    }

    protected $appends = ['age'];

    public function getAgeAttribute()
    {
        return Carbon::parse($this->dob)->age;
    }
}
