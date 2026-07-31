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
        Schema::create('chronic_disease_tracking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->string('patient_national_code', 10);
            $table->string('patient_name', 100)->nullable();
            $table->string('disease_type')->default('diabet');
            $table->date('diagnosis_date');
            $table->string('diagnosis_confirmed_by', 100)->nullable();
            $table->json('current_medications')->nullable();
            $table->date('last_visit_date')->nullable();
            $table->date('next_visit_date')->nullable();
            $table->json('lab_results')->nullable();
            $table->json('vital_signs')->nullable();
            $table->decimal('hba1c', 4, 1)->nullable();
            $table->string('blood_pressure', 10)->nullable();
            $table->decimal('bmi', 4, 1)->nullable();
            $table->json('complication_screening')->nullable();
            $table->string('control_status')->default('kontrol_shodeh')->nullable();
            $table->string('referred_to', 100)->nullable();
            $table->text('treatment_plan')->nullable();
            $table->string('adherence_level')->default('rezayat_bakhsh')->nullable();
            $table->string('status')->default('faal');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('patient_national_code');
            $table->index('disease_type');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chronic_disease_tracking');
    }
};
