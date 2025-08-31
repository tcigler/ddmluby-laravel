<?php

namespace Database\Factories;

use App\Models\UserInfo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class UserInfoFactory extends Factory {
    protected $model = UserInfo::class;

    public function definition(): array {
        $verification = $this->faker->boolean();
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'verification_code' => $this->faker->optional($verification ? 0 : 1)->word(),
            'verified_at' => $this->faker->optional($verification ? 1 : 0)->dateTimeThisYear(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
