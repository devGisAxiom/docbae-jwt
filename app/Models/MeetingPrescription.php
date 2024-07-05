<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingPrescription extends Model
{
    use HasFactory;

    protected $table = 'meeting_prescriptions';

    protected $fillable = [

       'meeting_info_id',
        'medicine_name',
        'drug_form',
        'strength',
        'duration'

    ];

    public $timestamps = false;
}
