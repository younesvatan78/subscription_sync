<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Platform;

class PlatformSeeder extends Seeder
{
    public function run()
    {
        // Add mock data for platforms table
        Platform::create([
            'name' => 'ios',
        ]);

        Platform::create([
            'name' => 'android',
        ]);

        // Add more mock data as needed...
    }
}
