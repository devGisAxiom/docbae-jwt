<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutionType extends Model
{
    use HasFactory;

    protected $table = 'institution_types';

    protected $fillable = [
        'name',
    ];

    public $timestamps = false;
}
