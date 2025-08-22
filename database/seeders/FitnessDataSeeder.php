<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\FoodLog;
use App\Models\ExerciseLog;
use Illuminate\Database\Seeder;

class FitnessDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test user with complete fitness data
        $user = User::factory()->create([
            'name' => 'John Fitness',
            'email' => 'john@fitness.test',
        ]);

        // Create user profile
        $profile = UserProfile::factory()->create([
            'user_id' => $user->id,
            'height' => 175.0,
            'weight' => 75.0,
            'neck_circumference' => 38.5,
            'waist_circumference' => 82.0,
            'gender' => 'male',
        ]);

        // Calculate and update body fat percentage
        if ($bodyFat = $profile->calculateBodyFatPercentage()) {
            $profile->update(['body_fat_percentage' => $bodyFat]);
        }

        // Create food logs for today
        $todaysFoods = [
            [
                'name' => 'Oatmeal with Berries',
                'calories' => 320,
                'protein' => 12,
                'fat' => 6,
                'carbohydrates' => 58,
            ],
            [
                'name' => 'Grilled Chicken Salad',
                'calories' => 280,
                'protein' => 35,
                'fat' => 8,
                'carbohydrates' => 15,
            ],
            [
                'name' => 'Greek Yogurt',
                'calories' => 150,
                'protein' => 20,
                'fat' => 0,
                'carbohydrates' => 18,
            ],
            [
                'name' => 'Salmon with Quinoa',
                'calories' => 420,
                'protein' => 32,
                'fat' => 18,
                'carbohydrates' => 35,
            ],
        ];

        foreach ($todaysFoods as $food) {
            FoodLog::create(array_merge($food, [
                'user_id' => $user->id,
                'logged_date' => today(),
            ]));
        }

        // Create exercise logs for today
        $todaysExercises = [
            [
                'exercise_type' => 'running',
                'duration_minutes' => 30,
            ],
            [
                'exercise_type' => 'weightlifting',
                'duration_minutes' => 45,
            ],
        ];

        foreach ($todaysExercises as $exercise) {
            $caloriesBurned = ExerciseLog::calculateCaloriesBurned(
                $exercise['exercise_type'],
                $exercise['duration_minutes'],
                (float) $profile->weight
            );

            ExerciseLog::create(array_merge($exercise, [
                'user_id' => $user->id,
                'calories_burned' => $caloriesBurned,
                'logged_date' => today(),
            ]));
        }

        // Create historical data for the past week
        for ($i = 1; $i <= 7; $i++) {
            $date = today()->subDays($i);

            // Random food logs
            FoodLog::factory()->count(random_int(2, 5))->create([
                'user_id' => $user->id,
                'logged_date' => $date,
            ]);

            // Random exercise logs
            if (random_int(0, 1)) { // 50% chance of exercise each day
                ExerciseLog::factory()->count(random_int(1, 2))->create([
                    'user_id' => $user->id,
                    'logged_date' => $date,
                ]);
            }
        }
    }
}