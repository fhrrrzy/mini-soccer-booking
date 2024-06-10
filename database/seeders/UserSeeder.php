<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create 10 users
        User::factory()->count(10)->create();

        // Create 5 owners
        User::factory()->owner()->count(5)->create();
    }
}
