<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DoctorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $numberOfRecords = 20;

        for ($i = 0; $i < $numberOfRecords; $i++) {

        DB::table('doctors')->insert([
            'type' => $faker->randomElement(['0', '1']),
            'email' => $faker->unique()->safeEmail,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'dob' => $faker->date('Y-m-d', '2000-01-01'),
            'mobile' => $faker->phoneNumber,
            'gender' => $faker->randomElement(['0', '1']),
            'profile_pic' => $faker->imageUrl(),
            'address' => $faker->address,
            'location' => $faker->city,
            'state' => $faker->state,
            'mbbs_registration_certificate' => $faker->word,
            'mbbs_certificate_number' => $faker->word,
            'year_of_passing_out_mbbs' => $faker->year,
            'additional_registration_certificate' => $faker->word,
            'additional_registration_certificate_number' => $faker->word,
            'degree_certificate' => $faker->word,
            'year_of_passing_out_degree' => $faker->year,
            'registration_council' => $faker->word,
            'pg_certificate' => $faker->word,
            'pg_certificate_number' => $faker->word,
            'year_of_passing_out_pg' => $faker->year,
            'institution' => $faker->word,
            'department_name' => $faker->randomElement(['General medicine', 'Peadiatrics','Gyneacology and obstetrics','Dermatology','General surgery','Psychiatry','Pulmonology','Orthopaedics']),
            'attachment' => $faker->word,
            'status' => 1,
            'is_verified' => 1,
            'experience_file' => $faker->word,
            'consultation_fee' => $faker->randomFloat(2, 50, 500),
            'commission_percentage' => $faker->randomFloat(2, 0, 100),
            'commission_amount' => $faker->randomFloat(2, 0, 500),
            'emergency' => $faker->randomElement(['0', '1']),
            'followup_days' => $faker->numberBetween(1, 30),
        ]);
    }
    }
}
