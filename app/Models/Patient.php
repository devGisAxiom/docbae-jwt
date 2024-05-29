<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';

    protected $fillable  = ['user_type', 'name', 'mobile','age', 'gender', 'blood_group_id', 'location', 'email','profile_pic', 'no_of_participants', 'authorization_letter','institution_type','institution_sub_type','created_at','status','active' ];

    public $timestamps = false;
}
