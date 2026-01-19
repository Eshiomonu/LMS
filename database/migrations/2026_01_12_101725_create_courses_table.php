<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('short_description');
            $table->text('long_description');
            $table->json('who_this_course_is_for')->nullable();
            $table->json('curriculum')->nullable();
            $table->json('what_you_get')->nullable();
            $table->json('why_train_with_us')->nullable();
            $table->unsignedSmallInteger('duration_hours')->nullable();
            $table->unsignedSmallInteger('duration_weeks')->nullable();

            $table->enum('mode', ['live_online', 'virtual', 'onsite']);
            $table->string('schedule')->nullable();
            $table->string('time')->nullable();
            $table->decimal('course_fee', 10, 2);
            $table->string('currency', 3)->default('NGN');
            $table->unsignedInteger('enrollment_count')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0.00);
            $table->unsignedInteger('reviews_count')->default(0);
            $table->boolean('recording_available')->default(false);
            $table->boolean('is_featured')->default(false);

            $table->enum('status', ['draft', 'published', 'archived'])
                  ->default('draft');
            $table->string('card_image');
            $table->string('hero_image')->nullable();
            $table->index(['is_featured', 'status']);
            $table->index('average_rating');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
