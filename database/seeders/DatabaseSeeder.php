<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Admin account ──────────────────────────────────
        Admin::updateOrCreate(
            ['email' => 'admin@asprohubs.com'],
            [
                'name'     => 'AsproHubs Admin',
                'email'    => 'admin@asprohubs.com',
                'password' => Hash::make('password'),
            ]
        );

        // ── 2. Demo student account ───────────────────────────
        User::updateOrCreate(
            ['email' => 'student@asprohubs.com'],
            [
                'name'      => 'Demo Student',
                'email'     => 'student@asprohubs.com',
                'password'  => Hash::make('password'),
                'phone'     => '08000000000',
                'role'      => 'student',
                'status'    => 'approved',
                'is_active' => true,
            ]
        );

        // ── 3. Categories then Courses ────────────────────────
        $this->call([
            CategorySeeder::class,
            CourseSeeder::class,
        ]);
    }
}