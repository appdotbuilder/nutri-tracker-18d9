<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\UserProfile
 *
 * @property int $id
 * @property int $user_id
 * @property float|null $height
 * @property float|null $weight
 * @property float|null $neck_circumference
 * @property float|null $waist_circumference
 * @property string|null $gender
 * @property float|null $body_fat_percentage
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereBodyFatPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereNeckCircumference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereWaistCircumference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereWeight($value)
 * @method static \Database\Factories\UserProfileFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class UserProfile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'height',
        'weight',
        'neck_circumference',
        'waist_circumference',
        'gender',
        'body_fat_percentage',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'height' => 'decimal:2',
        'weight' => 'decimal:2',
        'neck_circumference' => 'decimal:2',
        'waist_circumference' => 'decimal:2',
        'body_fat_percentage' => 'decimal:2',
    ];

    /**
     * Get the user that owns the profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate body fat percentage based on US Navy method.
     *
     * @return float|null
     */
    public function calculateBodyFatPercentage(): ?float
    {
        if (!$this->height || !$this->neck_circumference || !$this->waist_circumference || !$this->gender) {
            return null;
        }

        $height = (float) $this->height;
        $neck = (float) $this->neck_circumference;
        $waist = (float) $this->waist_circumference;

        // Prevent invalid log calculations
        if ($waist <= $neck || $height <= 0) {
            return null;
        }

        if ($this->gender === 'male') {
            $bodyFat = 495 / (1.0324 - 0.19077 * log10($waist - $neck) + 0.15456 * log10($height)) - 450;
        } else {
            // For women, we need hip measurement, but we'll use waist as approximation
            $bodyFat = 495 / (1.29579 - 0.35004 * log10($waist - $neck) + 0.22100 * log10($height)) - 450;
        }

        // Ensure reasonable body fat percentage range
        $bodyFat = max(5, min(50, $bodyFat));

        return round($bodyFat, 2);
    }
}