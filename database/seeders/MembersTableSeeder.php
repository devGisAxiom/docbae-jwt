<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class MembersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $numberOfRecords = 500;

        $members = [];
        for ($i = 0; $i < $numberOfRecords; $i++) {
            $userType = $faker->randomElement([1, 2]);
            $parentId = $userType == 1 ? 0 : $faker->numberBetween(1, 200);

            $members[] = [
                'patient_id' => $faker->numberBetween(1, 200),
                'parent_id' => $parentId,
                'user_type' => $userType,
                'mobile' => 1234,
                'grade_id' => $faker->numberBetween(1, 10),
                'image' => $faker->imageUrl(),
                'name' => $faker->name,
                'dob' => $faker->date('Y-m-d', '2005-01-01'),
                'gender' => $faker->randomElement([0, 1]),
                'relationship_id' => $faker->numberBetween(1, 10),
                'blood_group_id' => $faker->numberBetween(1, 8),
                'status' => 1,
                'unique_id' =>1234,
                'created_at' => $faker->dateTimeThisDecade,
                'address' => $faker->address,
                'height' => $faker->numberBetween(150, 200),
                'weight' => $faker->numberBetween(40, 100),
                'lmp' => $faker->date('Y-m-d', '2024-01-01'),
            ];
        }

        // Insert data into the members table
        DB::table('members')->insert($members);
    }
}
