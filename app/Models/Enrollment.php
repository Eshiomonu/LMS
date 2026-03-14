<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    // ── Fillable ──────────────────────────────────────────────

    protected $fillable = [
        'user_id',
        'course_id',
        'status',
        'enrollment_form',
        'payment_status',
        'amount_paid',
        'currency',
        'transaction_ref',
        'enrolled_at',
        'approved_at',
        'approved_by',
        'rejection_reason',
        'admin_notes',
    ];

    // ── Casts ─────────────────────────────────────────────────

    protected $casts = [
        'enrollment_form' => 'array',   // JSON blob from the popup form
        'enrolled_at'     => 'datetime',
        'approved_at'     => 'datetime',
        'amount_paid'     => 'decimal:2',
    ];

    // ── Relationships ─────────────────────────────────────────

    /** The student who enrolled. */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** The course being enrolled in. */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /** The admin who approved/rejected. */
    public function approvedByAdmin()
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    // ── Scopes ────────────────────────────────────────────────

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // ── Helpers ───────────────────────────────────────────────

    /**
     * Tailwind colour name for the current status badge.
     * Usage: bg-{{ $enrollment->statusColor }}-100
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'approved'  => 'emerald',
            'pending'   => 'amber',
            'rejected'  => 'red',
            'cancelled' => 'slate',
            'completed' => 'blue',
            default     => 'slate',
        };
    }

    /**
     * Human-readable status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return ucfirst($this->status);
    }

    /**
     * True when the enrollment is still waiting for admin action.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * True when the student has been given access.
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }
}