<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingConsultation extends Model
{
    use HasFactory;

    protected $table = 'meeting_consultations';

    protected $fillable = [

        'meeting_id',
        'symptom',
        'intencity',
        'description',
        'is_deleted',

    ];

    public $timestamps = false;
}
