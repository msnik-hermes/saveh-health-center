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
        Schema::create('occupational_examinations', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id', 20);
            $table->string('worker_name', 100);
            $table->string('national_code', 10);
            $table->string('company_name', 200);
            $table->string('job_title', 100);
            $table->json('hazard_exposures')->nullable();
            $table->enum('examination_type', ['ghabl_az_estejareh', 'doreei', 'khoroj']);
            $table->date('examination_date');
            $table->string('physician_name', 100);
            $table->text('vision_result')->nullable();
            $table->text('hearing_result')->nullable();
            $table->text('spirometry_result')->nullable();
            $table->text('blood_test_result')->nullable();
            $table->text('urine_test_result')->nullable();
            $table->string('blood_pressure', 10)->nullable();
            $table->decimal('bmi', 4, 1)->nullable();
            $table->text('physical_findings')->nullable();
            $table->text('abnormalities')->nullable();
            $table->enum('fit_status', ['motaanaseb', 'mashroot', 'namonaseb']);
            $table->text('restrictions')->nullable();
            $table->text('referrals')->nullable();
            $table->date('next_examination_date')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('national_code');
            $table->index('company_name');
            $table->index('examination_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('occupational_examinations');
    }
};
