<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    /**
     * WHY:
     * Prevent students from seeing admin course management
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * WHY:
     * Students should only view published courses (handled in controller)
     * Admins can view all
     */
    public function view(User $user, Course $course): bool
    {
        return $user->isAdmin();
    }

    /**
     * WHY:
     * Only admins create courses (business rule)
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * WHY:
     * Prevent horizontal privilege escalation
     */
    public function update(User $user, Course $course): bool
    {
        return $user->isAdmin();
    }

    /**
     * WHY:
     * Deleting a course is destructive and irreversible
     */
    public function delete(User $user, Course $course): bool
    {
        return $user->isAdmin();
    }
}
