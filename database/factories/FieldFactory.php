<?php

namespace Database\Factories;

use App\Models\Field;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FieldFactory extends Factory
{
    protected $model = Field::class;

    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'name' => $this->faker->company,
            'description' => $this->faker->sentence,
        ];
    }
}
