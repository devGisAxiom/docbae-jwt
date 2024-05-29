<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutionSubType extends Model
{
    use HasFactory;

    protected $table = 'institution_sub_types';

    protected $fillable = [

        'institution_type_id',
        'name',
    ];

    public $timestamps = false;
}
