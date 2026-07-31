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
        Schema::create('it_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->foreignId('requested_by')->constrained('employees')->cascadeOnDelete();
            $table->string('service_type')->default('tamir_kampooter');
            $table->foreignId('equipment_id')->nullable()->constrained('center_equipment')->nullOnDelete();
            $table->text('problem_description');
            $table->text('error_messages')->nullable();
            $table->string('priority')->default('adii');
            $table->json('screenshots')->nullable();
            $table->string('available_time', 100)->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('employees')->nullOnDelete();
            $table->string('status')->default('ersal_shodeh');
            $table->text('resolution_notes')->nullable();
            $table->date('completion_date')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('status');
            $table->index('service_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('it_requests');
    }
};
