<?php

namespace Database\Seeders;

use App\Models\Callback;
use Illuminate\Database\Seeder;

class CallbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Callback::factory(10)->create();
    }
}
