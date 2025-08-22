<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFoodLogRequest;
use App\Models\FoodLog;

class FoodLogController extends Controller
{
    /**
     * Store a new food log entry.
     */
    public function store(StoreFoodLogRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = auth()->id();

        FoodLog::create($validatedData);

        return redirect()->back()->with('success', 'Food log added successfully.');
    }
}