<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // ── Fillable ──────────────────────────────────────────────

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'phone',
        'avatar',
        'bio',
        'is_active',
        'approved_at',
        'approved_by',
        'rejection_reason',
    ];

    // ── Hidden ────────────────────────────────────────────────

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ── Casts ─────────────────────────────────────────────────

    protected $casts = [
        'email_verified_at' => 'datetime',
        'approved_at'       => 'datetime',
        'password'          => 'hashed',
        'is_active'         => 'boolean',
    ];

    // ── Accessors ─────────────────────────────────────────────

    /**
     * Returns a real avatar URL or a generated initials avatar.
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }

        return 'https://ui-avatars.com/api/?'
            . http_build_query([
                'name'       => $this->name,
                'background' => '4f46e5',
                'color'      => 'ffffff',
                'bold'       => 'true',
                'size'       => '128',
            ]);
    }

    // ── Status helpers ────────────────────────────────────────

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    // ── Relationships ─────────────────────────────────────────

    /**
     * All enrollment records for this student.
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Courses this student is enrolled in (via pivot).
     */
    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollments')
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

    /** Only student-role users. */
    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }

    /** Approved and active accounts. */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where('status', 'approved');
    }

    /** Accounts waiting for review. */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /** Suspended accounts. */
    public function scopeSuspended($query)
    {
        return $query->where('status', 'suspended');
    }
}