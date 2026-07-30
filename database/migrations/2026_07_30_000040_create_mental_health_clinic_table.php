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
        Schema::create('mental_health_clinic', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->string('patient_national_code', 10);
            $table->string('patient_name', 100)->nullable();
            $table->date('first_visit_date');
            $table->date('visit_date');
            $table->foreignId('clinician_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->enum('service_type', ['arzyabi', 'darman_raftari', 'daroo_darman', 'peygiri', 'orzhans']);
            $table->text('presenting_complaint');
            $table->string('diagnosis_code', 20)->nullable();
            $table->enum('severity', ['khafif', 'motevaset', 'shadid'])->nullable();
            $table->text('treatment_plan')->nullable();
            $table->json('medications')->nullable();
            $table->text('side_effects')->nullable();
            $table->text('session_notes')->nullable();
            $table->decimal('phq9_score', 4, 1)->nullable();
            $table->decimal('gad7_score', 4, 1)->nullable();
            $table->json('outcome_measures')->nullable();
            $table->text('referrals_made')->nullable();
            $table->date('next_appointment')->nullable();
            $table->boolean('consent_on_file')->nullable();
            $table->enum('status', ['faal', 'khatame_yafteh', 'enteghalyafteh']);
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('patient_national_code');
            $table->index('visit_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mental_health_clinic');
    }
};
