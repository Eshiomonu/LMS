<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // ── Core ──────────────────────────────────
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            // ── Role & Status ─────────────────────────
            // Only two roles: admin (legacy) and student
            // Admins now live in the admins table instead
            $table->enum('role', ['student'])->default('student');
            $table->enum('status', ['pending', 'approved', 'rejected', 'suspended'])
                  ->default('approved');

            // ── Contact ───────────────────────────────
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();

            // ── Profile ───────────────────────────────
            $table->text('bio')->nullable();

            // ── Account flags ─────────────────────────
            $table->boolean('is_active')->default(true);

            // ── Approval tracking ─────────────────────
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            // FK added after table creation to avoid self-reference issue
            $table->text('rejection_reason')->nullable();

            $table->timestamps();

            // ── Indexes ───────────────────────────────
            $table->index('status');
            $table->index('is_active');
        });

        // Add self-referencing FK separately
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('approved_by')
                  ->references('id')->on('users')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};