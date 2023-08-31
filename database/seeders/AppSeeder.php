<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\App;

class AppSeeder extends Seeder
{
    public function run()
    {
        // Add mock data for apps table
        App::create([
            'name' => 'App 1',
            'platform_id' => 1, // Assuming platform_id 1 represents iOS
            'current_status' => 'active',
        ]);

        App::create([
            'name' => 'App 2',
            'platform_id' => 2, // Assuming platform_id 2 represents Android
            'current_status' => 'expired',
        ]);

        // Add more mock data as needed...
    }
}