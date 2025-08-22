<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExerciseLogRequest;
use App\Models\ExerciseLog;

class ExerciseLogController extends Controller
{
    /**
     * Store a new exercise log entry.
     */
    public function store(StoreExerciseLogRequest $request)
    {
        $user = auth()->user();
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user->id;

        // Get user weight for calorie calculation
        $weight = optional($user->profile)->weight ?? 70; // Default to 70kg if no weight set

        // Calculate calories burned
        $caloriesBurned = ExerciseLog::calculateCaloriesBurned(
            $validatedData['exercise_type'],
            $validatedData['duration_minutes'],
            (float) $weight
        );

        $validatedData['calories_burned'] = $caloriesBurned;

        ExerciseLog::create($validatedData);

        return redirect()->back()->with('success', 'Exercise log added successfully.');
    }
}