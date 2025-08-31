<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EventFactory extends Factory {
    protected $model = Event::class;

    public function definition(): array {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->text(),
            'location' => $this->faker->word(),
            'program' => $this->faker->optional()->text(),
            'start' => fake()->dateTimeBetween('-1 month', '+6 months'),
            'end' => fake()->dateTimeBetween('+6 month', '+7 months'),
            'show_from' => fake()->dateTimeBetween('-1 month', '+5 days'),
            'reservation_open' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
