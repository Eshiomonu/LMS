<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    /* =====================
     * MASS ASSIGNMENT
     * ===================== */
    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'long_description',
        'who_this_course_is_for',
        'curriculum',
        'what_you_get',
        'why_train_with_us',
        'duration_hours',
        'duration_weeks',
        'mode',
        'schedule',
        'time',
        'course_fee',
        'currency',
        'enrollment_count',
        'average_rating',
        'reviews_count',
        'recording_available',
        'is_featured',
        'status',
        'card_image',
        'hero_image',
    ];

    /* =====================
     * CASTS
     * ===================== */
    protected $casts = [
        'who_this_course_is_for' => 'array',
        'curriculum'            => 'array',
        'what_you_get'           => 'array',
        'why_train_with_us'      => 'array',
        'recording_available'    => 'boolean',
        'is_featured'            => 'boolean',
        'course_fee'             => 'decimal:2',
        'average_rating'         => 'decimal:2',
    ];

    /* =====================
     * SCOPES
     * ===================== */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /* =====================
     * ACCESSORS
     * ===================== */
    public function getFormattedPriceAttribute(): string
    {
        return $this->currency === 'NGN'
            ? '₦' . number_format($this->course_fee, 2)
            : number_format($this->course_fee, 2) . ' ' . $this->currency;
    }

    public function getRatingStarsAttribute(): int
    {
        return (int) round($this->average_rating);
    }
}
