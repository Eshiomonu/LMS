<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            // BASIC INFO
            $table->string('title');
            $table->string('short_description');
            $table->text('long_description');

            // LIST FIELDS (JSON)
            $table->json('who_this_course_is_for');
            $table->json('curriculum');
            $table->json('what_you_get');
            $table->json('why_train_with_us');

            // COURSE DETAILS
            $table->unsignedInteger('duration_hours');
            $table->unsignedInteger('duration_weeks');

            $table->enum('mode', ['live_online', 'virtual', 'onsite']);

            $table->string('schedule');
            $table->string('time');

            // PRICING
            $table->decimal('course_fee', 10, 2);

            // FLAGS
            $table->boolean('recording')->default(false);
            $table->boolean('is_featured')->default(false);

            // MEDIA
            $table->string('card_image');
            $table->string('hero_image');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};

