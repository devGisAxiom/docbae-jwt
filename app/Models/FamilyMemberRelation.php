<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMemberRelation extends Model
{
    use HasFactory;

    protected $table = 'family_member_relations';

    protected $fillable = [

        'relation',

    ];

    public $timestamps = false;
}
