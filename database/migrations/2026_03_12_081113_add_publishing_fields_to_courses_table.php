<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {

            // Only add columns that don't already exist
            if (! Schema::hasColumn('courses', 'status')) {
                $table->enum('status', ['draft', 'pending', 'published', 'archived'])
                      ->default('draft')
                      ->after('language');
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
            $table->dropColumn(['status', 'is_published', 'is_featured', 'published_at']);
            $table->dropSoftDeletes();
        });
    }
};