<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;
    protected $table = 'languages';

    protected $fillable = [
        'language',
        'notes',
        'is_deleted',

    ];

    public $timestamps = false;
}
