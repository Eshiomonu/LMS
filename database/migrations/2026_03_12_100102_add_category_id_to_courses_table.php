<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {

            // category_id — the column the error says is missing
            if (! Schema::hasColumn('courses', 'category_id')) {
                $table->foreignId('category_id')
                      ->nullable()
                      ->constrained()
                      ->onDelete('set null');
            }

            // Also ensure the other publishing columns exist
            // (safe to run even if already migrated)
            if (! Schema::hasColumn('courses', 'status')) {
                $table->enum('status', ['draft', 'pending', 'published', 'archived'])
                      ->default('draft')->after('language');
            }
            if (! Schema::hasColumn('courses', 'is_published')) {
                $table->boolean('is_published')->default(false)->after('status');
            }
            if (! Schema::hasColumn('courses', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('is_published');
            }
            if (! Schema::hasColumn('courses', 'published_at')) {
                $table->timestamp('published_at')->nullable()->after('is_featured');
            }
            if (! Schema::hasColumn('courses', 'deleted_at')) {
                $table->softDeletes()->after('updated_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};