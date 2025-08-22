<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class FitnessController extends Controller
{
    /**
     * Display the main fitness tracking dashboard.
     */
    public function index()
    {
        $user = auth()->user();
        
        if (!$user) {
            return Inertia::render('welcome');
        }

        $profile = $user->profile;
        $todaysFoodLogs = $user->foodLogs()->whereDate('logged_date', today())->latest()->get();
        $todaysExerciseLogs = $user->exerciseLogs()->whereDate('logged_date', today())->latest()->get();

        // Calculate daily totals
        $dailyNutrition = [
            'calories' => $todaysFoodLogs->sum('calories'),
            'protein' => $todaysFoodLogs->sum('protein'),
            'fat' => $todaysFoodLogs->sum('fat'),
            'carbohydrates' => $todaysFoodLogs->sum('carbohydrates'),
        ];

        $totalCaloriesBurned = $todaysExerciseLogs->sum('calories_burned');

        return Inertia::render('dashboard', [
            'profile' => $profile,
            'todaysFoodLogs' => $todaysFoodLogs,
            'todaysExerciseLogs' => $todaysExerciseLogs,
            'dailyNutrition' => $dailyNutrition,
            'totalCaloriesBurned' => $totalCaloriesBurned,
        ]);
    }


}