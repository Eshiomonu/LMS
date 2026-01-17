<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title',
        'excerpt',
        'full_description',
        'price',
        'duration',
        'type',
        'online_type',
        'location',
        'meeting_link',
        'hero_image',
        'curriculum_file',
        'image',
        'short_desc',
        'students',
    ];

    // Many-to-Many relationship with users (enrolled students)
    public function users()
    {
        return $this->belongsToMany(User::class, 'course_user')
                    ->withTimestamps();
    }
}
