<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * Mass-assignable attributes
     * Prevents unintended data injection
     */
    protected $fillable = [
        'title',
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
        'recording',
        'is_featured',

        'card_image',
        'hero_image',
    ];

    /**
     * Attribute casting
     * Ensures correct data types from DB
     */
    protected $casts = [
        'who_this_course_is_for' => 'array',
        'curriculum' => 'array',
        'what_you_get' => 'array',
        'why_train_with_us' => 'array',

        'recording' => 'boolean',
        'is_featured' => 'boolean',
        'course_fee' => 'decimal:2',
    ];
}
