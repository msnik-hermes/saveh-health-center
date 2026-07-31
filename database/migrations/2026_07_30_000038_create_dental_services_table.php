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
        Schema::create('dental_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->string('patient_national_code', 10);
            $table->string('patient_name', 100)->nullable();
            $table->integer('patient_age')->nullable();
            $table->string('patient_gender')->default('mard')->nullable();
            $table->date('visit_date');
            $table->foreignId('dentist_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->string('service_type')->default('meyane');
            $table->string('teeth_involved', 100)->nullable();
            $table->string('diagnosis_code', 20)->nullable();
            $table->text('treatment_provided');
            $table->json('materials_used')->nullable();
            $table->unsignedBigInteger('fee')->nullable();
            $table->boolean('follow_up_needed')->default(false);
            $table->date('follow_up_date')->nullable();
            $table->integer('patient_satisfaction')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('visit_date');
            $table->index('patient_national_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dental_services');
    }
};
