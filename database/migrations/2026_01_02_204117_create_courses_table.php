<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
           $table->id();
    $table->string('title');
    $table->string('slug')->unique();
    $table->text('description');
    
    $table->enum('type', ['virtual', 'onsite']);
    $table->decimal('price', 10, 2);

    $table->string('thumbnail')->nullable();
    $table->boolean('is_published')->default(false);
$table->foreignId('category_id')
      ->constrained('course_categories')
      ->cascadeOnDelete();

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
