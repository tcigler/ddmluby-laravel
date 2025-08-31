<?php

namespace Database\Factories;

use App\Models\EventAttendee;
use App\Models\UserInfo;
use App\Models\EventBooking;
use App\Models\EventTimeSlot;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EventBookingFactory extends Factory {
    protected $model = EventBooking::class;

    public function definition(): array {
        $now = Carbon::now();
        $updateCreate = fake()->dateTimeThisYear();

        return [
            'note' => $this->faker->optional()->word(),
            'ip_addr' => $this->faker->ipv4(),
            'expire_at' => fake()->optional()->passthrough($now->add(CarbonInterval::make(mt_rand(1, 20) . 'days'))),
            'event_time_slot_id' => EventTimeSlot::factory(),
            'user_info_id' => UserInfo::factory(),
            'created_at' => $updateCreate,
            'updated_at' => $updateCreate,
        ];
    }

    public function addAttendees(?int $count = null): self {
        $count = $count ?? rand(1, 5);
        return $this->afterCreating(
            fn(EventBooking $booking) => EventAttendee::factory()->count($count)->for($booking)->create()
        );
    }
}
