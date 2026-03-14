<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    // ── Fillable ──────────────────────────────────────────────

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'subtitle',
        'description',
        'what_you_will_learn',
        'who_course_is_for',
        'requirements',
        'what_you_get',
        'why_train_with_us',
        'thumbnail',
        'preview_video',
        'price',
        'discount_price',
        'currency',
        'level',
        'duration_hours',
        'duration_weeks',
        'schedule',
        'mode',
        'language',
        'status',
        'is_published',
        'is_featured',
        'tags',
        'meta_title',
        'meta_description',
        'published_at',
    ];

    // ── Casts ─────────────────────────────────────────────────

    protected $casts = [
        'what_you_will_learn' => 'array',
        'who_course_is_for'   => 'array',
        'requirements'        => 'array',
        'what_you_get'        => 'array',
        'tags'                => 'array',
        'is_published'        => 'boolean',
        'is_featured'         => 'boolean',
        'price'               => 'decimal:2',
        'discount_price'      => 'decimal:2',
        'published_at'        => 'datetime',
    ];

    // ── Boot — auto-generate slug ─────────────────────────────

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Course $course) {
            if (empty($course->slug)) {
                $course->slug = Str::slug($course->title);
            }
        });

        static::updating(function (Course $course) {
            // Auto-set published_at when first published
            if ($course->isDirty('status') && $course->status === 'published') {
                $course->is_published  = true;
                $course->published_at  = $course->published_at ?? now();
            }

            // Auto-unpublish when archived/draft
            if ($course->isDirty('status') && in_array($course->status, ['draft', 'archived'])) {
                $course->is_published = false;
            }
        });
    }

    // ── Accessors ─────────────────────────────────────────────

    /**
     * Full URL to the course thumbnail or a placeholder.
     */
    public function getThumbnailUrlAttribute(): string
    {
        return $this->thumbnail
            ? asset('storage/' . $this->thumbnail)
            : asset('images/course-placeholder.png');
    }

    /**
     * The price students actually pay (discount takes priority).
     */
    public function getEffectivePriceAttribute(): float
    {
        return (float) ($this->discount_price ?? $this->price);
    }

    /**
     * True when the course costs nothing.
     */
    public function getIsFreeCourseAttribute(): bool
    {
        return (float) $this->price === 0.0;
    }

    /**
     * Formatted price string e.g. "NGN 25,000.00" or "Free".
     */
    public function getFormattedPriceAttribute(): string
    {
        if ($this->is_free_course) {
            return 'Free';
        }

        return $this->currency . ' ' . number_format($this->effective_price, 2);
    }

    // ── Relationships ─────────────────────────────────────────

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments')
                    ->withPivot([
                        'status',
                        'enrolled_at',
                        'approved_at',
                        'payment_status',
                        'amount_paid',
                    ])
                    ->withTimestamps();
    }

    // ── Scopes ────────────────────────────────────────────────

    /** Only courses visible to the public. */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->where('status', 'published');
    }

    /** Featured courses for homepage display. */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /** Filter by difficulty level. */
    public function scopeByLevel($query, string $level)
    {
        return $query->where('level', $level);
    }
}