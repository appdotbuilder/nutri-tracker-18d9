<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserProfileRequest;
use App\Models\UserProfile;

class UserProfileController extends Controller
{
    /**
     * Store or update user profile.
     */
    public function store(StoreUserProfileRequest $request)
    {
        $user = auth()->user();
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user->id;

        $profile = UserProfile::updateOrCreate(
            ['user_id' => $user->id],
            $validatedData
        );

        // Calculate and update body fat percentage
        if ($bodyFat = $profile->calculateBodyFatPercentage()) {
            $profile->update(['body_fat_percentage' => $bodyFat]);
        }

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}