<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();

            // ── Relations ─────────────────────────────
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->foreignId('course_id')
                  ->constrained()
                  ->onDelete('cascade');

            // ── Enrollment status ─────────────────────
            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'cancelled',
                'completed',
            ])->default('pending');

            // ── Enrollment form (JSON from popup) ─────
            // Stores: motivation, experience, goals,
            //         phone, company, job_title, etc.
            $table->json('enrollment_form')->nullable();

            // ── Payment ───────────────────────────────
            $table->enum('payment_status', [
                'pending',
                'paid',
                'failed',
                'refunded',
            ])->default('pending');
            $table->decimal('amount_paid', 10, 2)->nullable();
            $table->string('currency', 3)->default('USD');
            $table->string('transaction_ref')->nullable();

            // ── Approval tracking ─────────────────────
            $table->timestamp('enrolled_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->foreign('approved_by')
                  ->references('id')->on('admins')
                  ->onDelete('set null');
            $table->text('rejection_reason')->nullable();
            $table->text('admin_notes')->nullable();

            $table->timestamps();

            // ── Constraints ───────────────────────────
            // A student can only enrol in a course once
            $table->unique(['user_id', 'course_id']);

            // ── Indexes ───────────────────────────────
            $table->index('status');
            $table->index('payment_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};