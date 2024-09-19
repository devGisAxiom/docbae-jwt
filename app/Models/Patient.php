<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Patient extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = 'patients';

    protected $guard = ["api"];

    protected $fillable  = ['user_type', 'name', 'mobile','dob', 'gender', 'blood_group_id', 'address', 'email','profile_pic', 'no_of_participants', 'authorization_letter','institution_type','institution_sub_type','created_at','status','height','weight','lmp' ];

    public $timestamps = false;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
