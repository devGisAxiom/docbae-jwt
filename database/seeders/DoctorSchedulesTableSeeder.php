<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DoctorSchedulesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $numberOfRecords = 30;

        $daysOfWeek = ['1', '2', '3', '4', '5', '6', '7'];

        for ($i = 0; $i < $numberOfRecords; $i++) {
            $availableTime = $faker->randomElement(['0', '1', '2']);

            switch ($availableTime) {
                case '0':

                    $timeFrom = $faker->time('H:i:s', '09:00:00');
                    break;
                case '1':

                    $timeFrom = $faker->time('H:i:s', '14:00:00');
                    break;
                case '2':

                    $timeFrom = $faker->randomElement([
                        $faker->time('H:i:s', '16:00:00'),
                        $faker->time('H:i:s', '18:00:00')
                    ]);
                    break;
                default:
                    $timeFrom = $faker->time('H:i:s');
                    break;
            }


            $timeTo = date('H:i:s', strtotime($timeFrom) + $faker->numberBetween(15 * 60, 60 * 60));

            DB::table('doctor_schedules')->insert([
                'doctor_id' => $faker->numberBetween(1, 20),
                'available_time' => $availableTime,
                'day_of_week' => $faker->randomElement($daysOfWeek),
                'time_from' => $timeFrom,
                'time_to' => $timeTo,
                'duration' => $faker->randomElement(['10', '15', '20']),
                'status' => 1,
                'created_at' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
