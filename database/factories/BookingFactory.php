<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Field;
use App\Models\Booking;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition()
    {
        return [
            'field_id' => Field::factory(), // Creates a new field if not provided
            'user_id' => User::factory(),   // Creates a new user if not provided
            'date' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'start_time' => $this->faker->time($format = 'H:i', $max = 'now'),
            'end_time' => $this->faker->time($format = 'H:i', $max = 'now +2 hours'),
        ];
    }
}
