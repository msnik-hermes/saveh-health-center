<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approval_workflows', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->string('target_type', 50); // facility_request, it_request, vehicle_request, etc.
            $table->json('steps'); // [{step: 1, approver_role: 'manager', approver_unit: 'general_affairs'}]
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('target_type');
            $table->index('is_active');
        });

        Schema::create('approval_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workflow_id')->constrained('approval_workflows')->cascadeOnDelete();
            $table->string('target_type', 50);
            $table->unsignedBigInteger('target_id');
            $table->foreignId('requester_id')->constrained('employees')->cascadeOnDelete();
            $table->integer('current_step')->default(1);
            $table->string('status')->default('pending'); // pending, approved, rejected, cancelled
            $table->json('approvals')->nullable(); // [{step: 1, approver_id: 1, status: 'approved', date: '...'}]
            $table->text('notes')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['target_type', 'target_id']);
            $table->index('requester_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approval_requests');
        Schema::dropIfExists('approval_workflows');
    }
};
