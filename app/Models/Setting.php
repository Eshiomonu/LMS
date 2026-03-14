<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    // ── Fillable ──────────────────────────────────────────────

    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
    ];

    // ── Static helpers ────────────────────────────────────────

    /**
     * Get a setting value by key.
     *
     * Usage:  Setting::get('site_name', 'AsproHubs')
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::rememberForever('setting_' . $key, function () use ($key, $default) {
            $row = static::where('key', $key)->first();
            return $row ? $row->value : $default;
        });
    }

    /**
     * Create or update a setting and bust its cache.
     *
     * Usage:  Setting::set('site_name', 'My LMS', 'general')
     */
    public static function set(
        string $key,
        mixed  $value,
        string $group = 'general',
        string $type  = 'text'
    ): void {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group, 'type' => $type]
        );

        Cache::forget('setting_' . $key);
    }

    /**
     * Return all settings keyed by group, then by key.
     *
     * Usage:  $s = Setting::allByGroup();
     *         $s['general']['site_name']
     */
    public static function allByGroup(): array
    {
        return static::all()
            ->groupBy('group')
            ->map(fn ($group) => $group->pluck('value', 'key'))
            ->toArray();
    }
}