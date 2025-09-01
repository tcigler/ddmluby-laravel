<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventBooking;
use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Event::factory()->count(20)->create();
        EventBooking::factory()->count(30)->addAttendees()->create();
    }
}
