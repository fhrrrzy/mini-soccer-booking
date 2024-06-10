<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\User;
use App\Models\Field;
use Faker\Factory as Faker;

class BookingSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $userIds = User::all()->pluck('id')->toArray();
        $fieldIds = Field::all()->pluck('id')->toArray();

        foreach (range(1, 20) as $index) {
            Booking::factory()->create([
                'user_id' => $faker->randomElement($userIds),
                'field_id' => $faker->randomElement($fieldIds),
            ]);
        }
    }
}