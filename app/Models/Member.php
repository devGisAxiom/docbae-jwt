<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';

    protected $fillable = [

        'patient_id',
        'user_type',
        'mobile',
        'grade_id',
        'image',
        'name',
        'age',
        'gender',
        'relationship_id',
        'blood_group_id',
        'status',
        'unique_id',
        'created_at',
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

}
