<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingNotes extends Model
{
    use HasFactory;

    protected $table = 'meeting_notes';

    protected $fillable = [

        'meeting_info_id',
        'notes',

    ];

    public $timestamps = false;

    public function meeting_info(){

    	return $this->belongsTo(MeetingInfo::class,'meeting_info_id','id');
    }
}
