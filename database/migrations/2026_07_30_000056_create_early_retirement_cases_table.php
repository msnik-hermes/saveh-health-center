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
        Schema::create('early_retirement_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->string('worker_name', 100);
            $table->string('national_code', 10);
            $table->date('birth_date');
            $table->integer('current_age')->nullable();
            $table->string('company_name', 200)->nullable();
            $table->string('job_title', 100)->nullable();
            $table->decimal('total_service_years', 4, 1);
            $table->decimal('hazardous_service_years', 4, 1);
            $table->string('education_level', 50)->nullable();
            $table->string('family_status', 50)->nullable();
            $table->integer('dependent_count')->nullable();
            $table->json('work_history')->nullable();
            $table->json('occupational_conditions')->nullable();
            $table->text('medical_assessment')->nullable();
            $table->decimal('impairment_rating', 4, 1)->nullable();
            $table->string('eligibility')->default('vajed_sharaet');
            $table->string('recommendation')->default('tavsieh')->nullable();
            $table->date('expected_retirement_date')->nullable();
            $table->string('social_security_status', 100)->nullable();
            $table->string('case_status')->default('darkhast');
            $table->date('application_date');
            $table->date('resolution_date')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('national_code');
            $table->index('case_status');
            $table->index('application_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('early_retirement_cases');
    }
};
