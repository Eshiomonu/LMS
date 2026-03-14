<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (! Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }

            if (! Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('phone');
            }

            if (! Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable()->after('avatar');
            }

            if (! Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['student'])->default('student')->after('bio');
            }

            if (! Schema::hasColumn('users', 'status')) {
                $table->enum('status', ['pending', 'approved', 'rejected', 'suspended'])
                      ->default('approved')
                      ->after('role');
            }

            if (! Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('status');
            }

            if (! Schema::hasColumn('users', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('is_active');
            }

            if (! Schema::hasColumn('users', 'approved_by')) {
                $table->unsignedBigInteger('approved_by')->nullable()->after('approved_at');
            }

            if (! Schema::hasColumn('users', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('approved_by');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone', 'avatar', 'bio', 'role', 'status',
                'is_active', 'approved_at', 'approved_by', 'rejection_reason',
            ]);
        });
    }
};