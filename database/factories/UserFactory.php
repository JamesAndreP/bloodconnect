<?php

namespace Database\Factories;

use App\Enums\UserRoleEnum;
use App\Enums\UserStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition()
{
    return [
        'name' => $this->faker->name(),
        'email' => $this->faker->unique()->safeEmail(),
        'email_verified_at' => now(),

        'password' => bcrypt('password'),
        'remember_token' => \Illuminate\Support\Str::random(10),

        'role' => 'donor',
        'gender' => 'male',
        'birth_date' => '2000-01-01',
        'status' => 'Active',

        // ✅ FIXED VALUES
        'location' => 'Philippines|Cebu|Mandaue City',
        'phone' => '09123456789', // 🔥 THIS FIXES EVERYTHING
    ];
}

    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}