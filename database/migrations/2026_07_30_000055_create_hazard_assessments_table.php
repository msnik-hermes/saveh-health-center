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
        Schema::create('hazard_assessments', function (Blueprint $table) {
            $table->id();
            $table->string('company_name', 200);
            $table->foreignId('company_id')->nullable()->constrained('companies')->nullOnDelete();
            $table->date('assessment_date');
            $table->string('assessor_name', 100);
            $table->string('assessor_qualifications', 200)->nullable();
            $table->string('job_title_assessed', 100);
            $table->integer('workers_in_job')->nullable();
            $table->decimal('daily_work_hours', 4, 1)->nullable();
            $table->integer('weekly_work_days')->nullable();
            $table->json('hazard_categories');
            $table->json('physical_hazards')->nullable();
            $table->json('chemical_hazards')->nullable();
            $table->json('biological_hazards')->nullable();
            $table->json('ergonomic_hazards')->nullable();
            $table->json('psychosocial_hazards')->nullable();
            $table->string('risk_category')->default('daste_1');
            $table->string('overall_risk')->default('payeen');
            $table->json('control_measures')->nullable();
            $table->text('recommendations')->nullable();
            $table->date('review_date')->nullable();
            $table->string('assessment_report', 255)->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('company_name');
            $table->index('assessment_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hazard_assessments');
    }
};
