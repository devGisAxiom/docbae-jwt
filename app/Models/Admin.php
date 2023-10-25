<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admin_details';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'role',
        'user_name',
        'password',
    ];

    public $timestamps = false;
}
