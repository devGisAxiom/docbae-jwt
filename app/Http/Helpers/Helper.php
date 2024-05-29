<?php

use App\Models\Member;
use App\Models\RegistrationId;
use Illuminate\Support\Carbon;

class Helper {

    public static function GenerateUniqueId()
    {
        // $unique_id =  mt_rand(100000, 999999);

        // while (RegistrationId::where('unique_id', $unique_id)->exists()) {

        //     $unique_id = Helper::GenerateUniqueId();

        // }

       $timestamp =  Carbon::now()->timestamp;
       $member_id = Member::orderBy('id','desc')->pluck('id')->first();
       $new_id    =  $member_id+1;
       $unique_id = $timestamp . $new_id;

        return $unique_id;

    }

}

?>
