<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = [

        'consultation_fee',
        'commission_percentage',
        'payment_type',
        'followup_days',

    ];

    public $timestamps = false;
}
