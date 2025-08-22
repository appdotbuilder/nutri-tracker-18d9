<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExerciseLog>
 */
class ExerciseLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $exerciseTypes = [
            'running',
            'walking',
            'cycling',
            'swimming',
            'yoga',
            'weightlifting',
            'dancing',
            'hiking',
            'basketball',
            'soccer',
            'tennis',
            'jump_rope',
            'rowing',
            'pilates',
            'martial_arts',
        ];

        $exerciseType = $this->faker->randomElement($exerciseTypes);
        $duration = $this->faker->numberBetween(15, 120); // 15-120 minutes

        // Simulate calorie calculation based on average weight of 70kg
        $metValues = [
            'running' => 8.0,
            'walking' => 3.5,
            'cycling' => 6.0,
            'swimming' => 7.0,
            'yoga' => 2.5,
            'weightlifting' => 4.0,
            'dancing' => 4.8,
            'hiking' => 6.0,
            'basketball' => 8.0,
            'soccer' => 7.0,
            'tennis' => 7.0,
            'jump_rope' => 12.0,
            'rowing' => 8.5,
            'pilates' => 3.0,
            'martial_arts' => 10.0,
        ];

        $met = $metValues[$exerciseType] ?? 4.0;
        $caloriesBurned = $met * 70 * ($duration / 60); // Using 70kg as default weight

        return [
            'user_id' => User::factory(),
            'exercise_type' => $exerciseType,
            'duration_minutes' => $duration,
            'calories_burned' => round($caloriesBurned, 2),
            'logged_date' => $this->faker->dateTimeBetween('-30 days', 'now')->format('Y-m-d'),
        ];
    }
}