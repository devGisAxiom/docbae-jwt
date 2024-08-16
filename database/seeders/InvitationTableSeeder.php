<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class InvitationTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $numberOfRecords = 500;

        $invitations = [];
        for ($i = 0; $i < $numberOfRecords; $i++) {
            $followUp = $faker->randomElement([0, 1]);
            $followUpDate = $followUp ? $faker->date('Y-m-d', '2024-12-31') : null;

            $invitations[] = [
                'user_type' => $faker->randomElement([1, 2]),
                'patient_id' => $faker->numberBetween(1, 50),
                'member_id' => $faker->numberBetween(1, 300),
                'doctor_id' => $faker->numberBetween(1, 20),
                'meeting_date' => $faker->date('Y-m-d', '2024-12-31'),
                'meeting_time' => $faker->time('H:i:s'),
                'status' => $faker->randomElement([0, 1, 2,3,4]),
                'available_time' => $faker->randomElement([0, 1, 2]),
                'created_at' => $faker->dateTimeThisDecade,
                'transaction_id' => $faker->uuid,
                'consultation_fee' => $faker->numberBetween(100, 1000),
                'commission_percentage' => $faker->randomFloat(2, 0, 100),
                'commission_amount' => $faker->numberBetween(10, 500),
                'doctors_fee' => $faker->numberBetween(100, 1000),
                'fund_released' => $faker->randomElement([0, 1]),
                'released_date' => $faker->optional()->date('Y-m-d', '2024-12-31'),
                'emergency_call' => $faker->randomElement([0, 1]),
                'follow_up' => $followUp,
                'follow_up_date' => $followUpDate,
            ];
        }

        DB::table('invitations')->insert($invitations);
    }
}
