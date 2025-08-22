<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FoodLog>
 */
class FoodLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $foodItems = [
            'Grilled Chicken Breast',
            'Brown Rice',
            'Broccoli',
            'Salmon Fillet',
            'Greek Yogurt',
            'Oatmeal',
            'Banana',
            'Almonds',
            'Sweet Potato',
            'Quinoa',
            'Avocado',
            'Eggs',
            'Spinach Salad',
            'Protein Shake',
            'Green Tea',
        ];

        return [
            'user_id' => User::factory(),
            'name' => $this->faker->randomElement($foodItems),
            'calories' => $this->faker->randomFloat(2, 50, 800),
            'protein' => $this->faker->randomFloat(2, 0, 50),
            'fat' => $this->faker->randomFloat(2, 0, 40),
            'carbohydrates' => $this->faker->randomFloat(2, 0, 100),
            'logged_date' => $this->faker->dateTimeBetween('-30 days', 'now')->format('Y-m-d'),
        ];
    }
}