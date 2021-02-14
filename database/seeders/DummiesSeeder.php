<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DummiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\v1\People::factory()->count(10)->create();
        \App\Models\v1\User::factory()->count(5)->create();
        \App\Models\v1\Security::factory()->count(5)->create();
        \App\Models\v1\Corporate::factory()->count(5)->create();
        \App\Models\v1\Customer::factory()->count(5)->create();
        \App\Models\v1\Site::factory()->count(5)->create();
        \App\Models\v1\Schedule::factory()->count(5)->create();
    }
}
