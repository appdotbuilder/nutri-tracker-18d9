<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProfile>
 */
class UserProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'height' => $this->faker->randomFloat(2, 150, 200), // 150-200 cm
            'weight' => $this->faker->randomFloat(2, 50, 120), // 50-120 kg
            'neck_circumference' => $this->faker->randomFloat(2, 30, 45), // 30-45 cm
            'waist_circumference' => $this->faker->randomFloat(2, 70, 120), // 70-120 cm
            'gender' => $this->faker->randomElement(['male', 'female']),
            'body_fat_percentage' => $this->faker->randomFloat(2, 10, 30), // 10-30%
        ];
    }
}