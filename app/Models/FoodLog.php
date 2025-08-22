<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\FoodLog
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property float $calories
 * @property float $protein
 * @property float $fat
 * @property float $carbohydrates
 * @property string $logged_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|FoodLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FoodLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FoodLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|FoodLog whereCalories($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodLog whereCarbohydrates($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodLog whereFat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodLog whereLoggedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodLog whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodLog whereProtein($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodLog whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodLog today()
 * @method static \Database\Factories\FoodLogFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class FoodLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'calories',
        'protein',
        'fat',
        'carbohydrates',
        'logged_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'calories' => 'decimal:2',
        'protein' => 'decimal:2',
        'fat' => 'decimal:2',
        'carbohydrates' => 'decimal:2',
        'logged_date' => 'date',
    ];

    /**
     * Get the user that owns the food log.
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
}