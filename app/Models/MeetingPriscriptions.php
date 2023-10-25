<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingPriscriptions extends Model
{
    use HasFactory;

    protected $table = 'meeting_priscriptions';

    protected $fillable = [

        'meeting_id',
        'priscriptions',
        'is_deleted',

    ];

    public $timestamps = false;
}
