<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ExerciseLog
 *
 * @property int $id
 * @property int $user_id
 * @property string $exercise_type
 * @property int $duration_minutes
 * @property float $calories_burned
 * @property string $logged_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseLog whereCaloriesBurned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseLog whereDurationMinutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseLog whereExerciseType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseLog whereLoggedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseLog whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseLog today()
 * @method static \Database\Factories\ExerciseLogFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class ExerciseLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'exercise_type',
        'duration_minutes',
        'calories_burned',
        'logged_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'duration_minutes' => 'integer',
        'calories_burned' => 'decimal:2',
        'logged_date' => 'date',
    ];

    /**
     * Get the user that owns the exercise log.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include today's logs.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeToday($query)
    {
        return $query->whereDate('logged_date', today());
    }

    /**
     * Calculate calories burned based on exercise type and user weight.
     *
     * @param string $exerciseType
     * @param int $durationMinutes
     * @param float $weightKg
     * @return float
     */
    public static function calculateCaloriesBurned(string $exerciseType, int $durationMinutes, float $weightKg): float
    {
        // MET values for different exercises
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

        $met = $metValues[$exerciseType] ?? 4.0; // Default MET value
        
        // Formula: Calories = MET × weight (kg) × time (hours)
        $caloriesBurned = $met * $weightKg * ($durationMinutes / 60);
        
        return round($caloriesBurned, 2);
    }
}