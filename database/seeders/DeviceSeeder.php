<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Device;
use App\Models\Subscription;
use Illuminate\Database\Seeder;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $applications = Application::all();

        Device::factory(100)->create()->each(function ($device) use ($applications) {
            $apps = $applications->random(3);
            foreach ($apps as $app) {
                Subscription::factory()->create([
                    'device_id' => $device->id,
                    'application_id' => $app->id,
                ]);
            }

            $remainingApps = $applications->diff($apps)->random(2);
            foreach ($remainingApps as $app) {
                Subscription::factory()->expired()->create([
                    'device_id' => $device->id,
                    'application_id' => $app->id,
                ]);
            }
        });
    }
}
