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
        Schema::create('immunization_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->string('patient_national_code', 10);
            $table->string('patient_name', 100)->nullable();
            $table->date('patient_birth_date');
            $table->string('patient_gender')->default('mard');
            $table->string('vaccine_type')->default('BCG');
            $table->integer('dose_number');
            $table->string('vaccine_name', 200);
            $table->string('batch_number', 50)->nullable();
            $table->date('administration_date');
            $table->string('administered_by', 100)->nullable();
            $table->string('injection_site', 50)->nullable();
            $table->date('next_dose_date')->nullable();
            $table->text('side_effects')->nullable();
            $table->string('guardian_name', 100)->nullable();
            $table->string('guardian_phone', 15)->nullable();
            $table->string('status')->default('anjam_shodeh');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('patient_national_code');
            $table->index('guardian_phone');
            $table->index('vaccine_type');
            $table->index('administration_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('immunization_records');
    }
};
