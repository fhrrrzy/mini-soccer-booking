<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Field;

class FieldSeeder extends Seeder
{
    public function run()
    {
        // Create 10 fields
        Field::factory()->count(10)->create();
    }
}
