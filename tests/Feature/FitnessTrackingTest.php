<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\FoodLog;
use App\Models\ExerciseLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FitnessTrackingTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_access_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('dashboard'));
    }

    public function test_guest_user_redirected_to_welcome(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_user_can_create_profile(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/fitness/profile', [
            'height' => 175.0,
            'weight' => 70.0,
            'neck_circumference' => 38.0,
            'waist_circumference' => 80.0,
            'gender' => 'male',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('user_profiles', [
            'user_id' => $user->id,
            'height' => 175.0,
            'weight' => 70.0,
        ]);
    }

    public function test_body_fat_percentage_is_calculated_automatically(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/fitness/profile', [
            'height' => 175.0,
            'weight' => 70.0,
            'neck_circumference' => 38.0,
            'waist_circumference' => 80.0,
            'gender' => 'male',
        ]);

        $profile = UserProfile::where('user_id', $user->id)->first();
        $this->assertNotNull($profile->body_fat_percentage);
        $this->assertIsNumeric($profile->body_fat_percentage);
    }

    public function test_user_can_log_food(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/fitness/food', [
            'name' => 'Grilled Chicken Breast',
            'calories' => 250.0,
            'protein' => 30.0,
            'fat' => 5.0,
            'carbohydrates' => 0.0,
            'logged_date' => '2024-01-01',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('food_logs', [
            'user_id' => $user->id,
            'name' => 'Grilled Chicken Breast',
            'calories' => 250.0,
        ]);
    }

    public function test_user_can_log_exercise(): void
    {
        $user = User::factory()->create();
        UserProfile::factory()->create([
            'user_id' => $user->id,
            'weight' => 70.0,
        ]);

        $response = $this->actingAs($user)->post('/fitness/exercise', [
            'exercise_type' => 'running',
            'duration_minutes' => 30,
            'logged_date' => '2024-01-01',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('exercise_logs', [
            'user_id' => $user->id,
            'exercise_type' => 'running',
            'duration_minutes' => 30,
        ]);

        $exerciseLog = ExerciseLog::where('user_id', $user->id)->first();
        $this->assertNotNull($exerciseLog->calories_burned);
        $this->assertGreaterThan(0, $exerciseLog->calories_burned);
    }

    public function test_dashboard_shows_daily_nutrition_totals(): void
    {
        $user = User::factory()->create();
        
        FoodLog::factory()->create([
            'user_id' => $user->id,
            'calories' => 300.0,
            'protein' => 25.0,
            'fat' => 10.0,
            'carbohydrates' => 20.0,
            'logged_date' => today(),
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->has('dailyNutrition')
                ->where('dailyNutrition.calories', 300)
                ->where('dailyNutrition.protein', 25)
        );
    }

    public function test_dashboard_shows_exercise_totals(): void
    {
        $user = User::factory()->create();
        
        ExerciseLog::factory()->create([
            'user_id' => $user->id,
            'calories_burned' => 280.0,
            'logged_date' => today(),
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->where('totalCaloriesBurned', 280)
        );
    }

    public function test_food_log_validation_requires_all_fields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/fitness/food', [
            'name' => '',
            'calories' => '',
            'protein' => '',
            'fat' => '',
            'carbohydrates' => '',
            'logged_date' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'calories', 'protein', 'fat', 'carbohydrates', 'logged_date']);
    }

    public function test_exercise_log_validation_requires_valid_exercise_type(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/fitness/exercise', [
            'exercise_type' => 'invalid_exercise',
            'duration_minutes' => 30,
            'logged_date' => '2024-01-01',
        ]);

        $response->assertSessionHasErrors(['exercise_type']);
    }
}