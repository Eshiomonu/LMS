<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    // ── Table ─────────────────────────────────────────────────

    protected $table = 'admins';

    // ── Fillable ──────────────────────────────────────────────

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // ── Hidden ────────────────────────────────────────────────

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ── Casts ─────────────────────────────────────────────────

    protected $casts = [
        'password' => 'hashed',
    ];

    // ── Accessors ─────────────────────────────────────────────

    /**
     * Generates an initials-based avatar for the admin.
     */
    public function getAvatarUrlAttribute(): string
    {
        return 'https://ui-avatars.com/api/?'
            . http_build_query([
                'name'       => $this->name,
                'background' => '0f172a',
                'color'      => 'ffffff',
                'bold'       => 'true',
                'size'       => '128',
            ]);
    }
}