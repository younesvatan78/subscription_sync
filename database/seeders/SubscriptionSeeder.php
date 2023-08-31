<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subscription;

class SubscriptionSeeder extends Seeder
{
    public function run()
    {
        // Add mock data for subscriptions table
        Subscription::create([
            'app_id' => 1, // Assuming app_id 1 represents App 1
            'status' => 'expired',
        ]);

        Subscription::create([
            'app_id' => 2, // Assuming app_id 2 represents App 2
            'status' => 'expired',
        ]);

        Subscription::create([
            'app_id' => 1, // Assuming app_id 1 represents App 1
            'status' => 'pending',
        ]);

        // Add more mock data as needed...
    }
}