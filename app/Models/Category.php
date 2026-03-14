<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    // ── Fillable ──────────────────────────────────────────────

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    // ── Casts ─────────────────────────────────────────────────

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ── Boot — auto-generate slug ─────────────────────────────

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Category $category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // ── Relationships ─────────────────────────────────────────

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    // ── Scopes ────────────────────────────────────────────────

    /** Only active categories. */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}