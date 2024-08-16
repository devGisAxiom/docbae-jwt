<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PatientsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $numberOfRecords = 200;
        for ($i = 0; $i < $numberOfRecords; $i++) {

            $userType = $faker->randomElement([1, 2]);


            $phoneNumber = $this->generatePhoneNumber();

            $data = [
                'user_type' => $userType,
                'name' => $faker->name,
                'mobile' => $phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'address' => $faker->address,
                'profile_pic' => $faker->imageUrl(),
                'created_at' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
                'status' => 1,
            ];

            if ($userType == 1) {

                $data = array_merge($data, [
                    'dob' => $faker->date('Y-m-d', '2000-01-01'),
                    'gender' => $faker->randomElement(['0', '1']),
                    'blood_group_id' => $faker->randomElement([1, 2, 3, 4]),
                    'height' => $faker->numberBetween(150, 200),
                    'weight' => $faker->numberBetween(50, 100),
                    'lmp' => $faker->date('Y-m-d', 'now'),
                ]);
            } else {

                $data = array_merge($data, [
                    'no_of_participants' => $faker->numberBetween(1, 10),
                    'authorization_letter' => $faker->word,
                    'institution_type' => 1,
                    'institution_sub_type' =>1,
                ]);
            }

            DB::table('patients')->insert($data);
        }
    }

    /**
     * Generate a phone number with a specific format (e.g., 10 digits).
     *
     * @return string
     */
    private function generatePhoneNumber()
    {
        // Example: Generate a phone number with 10 digits (e.g., 123-456-7890)
        return sprintf('%03d-%03d-%04d', rand(100, 999), rand(100, 999), rand(1000, 9999));
    }
}
