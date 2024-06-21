<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembersMapping extends Model
{
    use HasFactory;

    protected $table = 'members_mapping';

    protected $fillable = [

        'patient_id',
        'member_id',
        'user_type',
        'status',
    ];

    public $timestamps = false;
}
