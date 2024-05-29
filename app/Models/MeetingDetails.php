<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingDetails extends Model
{
    use HasFactory;

    protected $table = 'meeting_details';

    protected $fillable = [

        'meeting_id',
        'invitation_id',
        'token',
        'created_at',
        'status',

    ];

    public $timestamps = false;

    public function invitations(){

    	return $this->belongsTo(Invitation::class,'invitation_id','id');
    }

}
