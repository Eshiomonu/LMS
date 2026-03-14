<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            // ── Relations ─────────────────────────────
            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');

            // ── Basic info ────────────────────────────
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->text('description');

            // ── Structured content (JSON arrays) ──────
            $table->json('what_you_will_learn')->nullable();
            $table->json('who_course_is_for')->nullable();
            $table->json('requirements')->nullable();
            $table->json('what_you_get')->nullable();
            $table->text('why_train_with_us')->nullable();

            // ── Media ─────────────────────────────────
            $table->string('thumbnail')->nullable();
            $table->string('preview_video')->nullable();

            // ── Pricing ───────────────────────────────
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->string('currency', 3)->default('USD');

            // ── Course details ────────────────────────
            $table->enum('level', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->integer('duration_hours')->nullable();
            $table->integer('duration_weeks')->nullable();
            $table->string('schedule')->nullable();   // e.g. "Mon - Fri, 9am - 5pm"
            $table->string('mode')->nullable();       // e.g. "Live Online", "In-Person"
            $table->string('language')->default('English');

            // ── Status & visibility ───────────────────
            $table->enum('status', ['draft', 'pending', 'published', 'archived'])->default('draft');
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);

            // ── SEO ───────────────────────────────────
            $table->json('tags')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            // ── Timestamps ────────────────────────────
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // ── Indexes ───────────────────────────────
            $table->index('slug');
            $table->index('status');
            $table->index('is_published');
            $table->index('is_featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};