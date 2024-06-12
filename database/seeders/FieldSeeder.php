<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Field;
use Illuminate\Support\Str;

class FieldSeeder extends Seeder
{
    public function run()
    {
        $fields = [
            ['name' => 'Field 1', 'description' => Str::random(50)],
            ['name' => 'Field 2', 'description' => Str::random(50)],
            ['name' => 'Field 3', 'description' => Str::random(50)],
            ['name' => 'Field 4', 'description' => Str::random(50)],
        ];

        foreach ($fields as $field) {
            Field::create($field);
        }
    }
}
