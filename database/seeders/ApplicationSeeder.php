<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\ApplicationCredentials;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Application::factory(10)
            ->has(ApplicationCredentials::factory(), 'credentials')
            ->create();
    }
}
