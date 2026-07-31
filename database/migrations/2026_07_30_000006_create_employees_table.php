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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('personnel_code', 20)->unique();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('father_name', 50)->nullable();
            $table->string('national_code', 10);
            $table->string('id_card_number', 20)->nullable();
            $table->string('id_card_serial', 20)->nullable();
            $table->date('birth_date');
            $table->string('birth_place', 100)->nullable();
            $table->string('gender')->default('mard');
            $table->string('marital_status')->default('motahel');
            $table->integer('children_count')->nullable();
            $table->string('blood_type', 5)->nullable();
            $table->string('nationality', 50)->nullable();
            $table->string('ethnicity', 50)->nullable();
            $table->string('religion', 50)->nullable();
            $table->decimal('height_cm', 5, 1)->nullable();
            $table->decimal('weight_kg', 5, 1)->nullable();
            $table->string('military_service_status')->default('anjam_shodeh')->nullable();
            $table->boolean('has_disability')->default(false);
            $table->string('disability_type', 100)->nullable();
            $table->string('photo', 255)->nullable();
            $table->string('signature', 255)->nullable();
            $table->string('job_title', 200);
            $table->string('position', 100);
            $table->string('employment_type')->default('rasmi');
            $table->date('employment_date');
            $table->date('end_date')->nullable();
            $table->date('probation_end_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->string('department', 100);
            $table->string('service_type')->default('darmani');
            $table->foreignId('supervisor_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->string('status')->default('faal');
            $table->date('retirement_date')->nullable();
            $table->decimal('years_of_service', 5, 1)->nullable();
            $table->boolean('is_laborer')->default(false);
            $table->string('education_degree', 50);
            $table->string('education_field', 100)->nullable();
            $table->string('university', 200)->nullable();
            $table->integer('graduation_year')->nullable();
            $table->decimal('gpa', 4, 2)->nullable();
            $table->string('medical_license_number', 50)->nullable();
            $table->date('license_expiry')->nullable();
            $table->json('certifications')->nullable();
            $table->json('skills')->nullable();
            $table->text('home_address')->nullable();
            $table->string('home_postal_code', 10)->nullable();
            $table->string('home_phone', 20)->nullable();
            $table->string('mobile', 15);
            $table->string('work_email', 100)->nullable();
            $table->string('personal_email', 100)->nullable();
            $table->string('emergency_contact', 100)->nullable();
            $table->string('emergency_phone', 15)->nullable();
            $table->string('emergency_relation', 50)->nullable();
            $table->unsignedBigInteger('base_salary')->nullable();
            $table->unsignedBigInteger('housing_allowance')->nullable();
            $table->unsignedBigInteger('food_allowance')->nullable();
            $table->unsignedBigInteger('child_allowance')->nullable();
            $table->unsignedBigInteger('family_allowance')->nullable();
            $table->unsignedBigInteger('overtime_rate')->nullable();
            $table->string('insurance_type', 50)->nullable();
            $table->string('insurance_number', 50)->nullable();
            $table->string('pension_fund', 100)->nullable();
            $table->decimal('military_service_years', 4, 1)->nullable();
            $table->decimal('education_credit', 4, 1)->nullable();
            $table->time('work_start_time')->nullable();
            $table->time('work_end_time')->nullable();
            $table->string('weekly_schedule', 100)->nullable();
            $table->string('shift_type')->default('sahar')->nullable();
            $table->boolean('can_telework')->default(false);
            $table->string('bank_account_number', 50)->nullable();
            $table->string('bank_name', 100)->nullable();
            $table->decimal('performance_score', 4, 2)->nullable();
            $table->date('last_evaluation_date')->nullable();
            $table->json('training_records')->nullable();
            $table->json('disciplinary_records')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('national_code');
            $table->index('status');
            $table->index('employment_type');
            $table->index('department');
            $table->index('personnel_code');
            $table->index('home_phone');
            $table->index('work_email');
            $table->index('personal_email');
            $table->index('emergency_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
