<?php

namespace Database\Factories;

use App\Models\EventAttendee;
use App\Models\EventBooking;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventAttendeeFactory extends Factory {
    protected $model = EventAttendee::class;

    public function definition(): array {
        return [
            'note' => $this->faker->word(),
            'code' => $this->faker->word(),

            'event_booking_id' => EventBooking::factory(),
        ];
    }
}
