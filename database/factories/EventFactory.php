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
            'show_from' => fake()->dateTimeBetween('-1 month', '+10 days'),
            'registration_from' => fake()->optional()->dateTimeBetween('-15 days', '+3 days'),
            'registration_open' => $this->faker->boolean(70),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
