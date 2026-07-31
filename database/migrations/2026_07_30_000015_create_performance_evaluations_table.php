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
        Schema::create('performance_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->string('evaluation_period', 20);
            $table->string('evaluation_type')->default('salaneh');
            $table->foreignId('evaluator_id')->constrained('employees')->cascadeOnDelete();
            $table->decimal('self_score', 4, 2)->nullable();
            $table->decimal('supervisor_score', 4, 2)->nullable();
            $table->decimal('peer_score', 4, 2)->nullable();
            $table->decimal('overall_score', 4, 2);
            $table->decimal('job_knowledge', 4, 2)->nullable();
            $table->decimal('quality_of_work', 4, 2)->nullable();
            $table->decimal('quantity_of_work', 4, 2)->nullable();
            $table->decimal('punctuality', 4, 2)->nullable();
            $table->decimal('teamwork', 4, 2)->nullable();
            $table->decimal('initiative', 4, 2)->nullable();
            $table->text('strengths')->nullable();
            $table->text('improvement_areas')->nullable();
            $table->text('development_goals')->nullable();
            $table->text('training_recommendations')->nullable();
            $table->boolean('promotion_recommendation')->nullable();
            $table->text('comments')->nullable();
            $table->string('status')->default('pishnevis');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('employee_id');
            $table->index('evaluation_period');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_evaluations');
    }
};
