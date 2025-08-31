<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\EventTimeSlot;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EventTimeSlotFactory extends Factory {
    protected $model = EventTimeSlot::class;

    public function definition(): array {
        return [
            'time' => fake()->dateTimeThisYear('+1 month'),
            'capacity' => $this->faker->randomNumber(2),
            'blocked' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'event_id' => Event::all()->random()->id,
        ];
    }
}
