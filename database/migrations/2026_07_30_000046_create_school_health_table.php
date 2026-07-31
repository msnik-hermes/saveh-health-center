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
        Schema::create('school_health', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->string('school_name', 200);
            $table->string('school_code', 20)->nullable();
            $table->string('school_type')->default('ebtedaei');
            $table->string('school_location', 200)->nullable();
            $table->integer('student_population')->nullable();
            $table->integer('male_count')->nullable();
            $table->integer('female_count')->nullable();
            $table->string('screening_type')->default('binaayee');
            $table->date('screening_date');
            $table->integer('students_screened');
            $table->integer('vision_problems')->nullable();
            $table->integer('hearing_problems')->nullable();
            $table->integer('dental_problems')->nullable();
            $table->integer('bmi_underweight')->nullable();
            $table->integer('bmi_normal')->nullable();
            $table->integer('bmi_overweight')->nullable();
            $table->integer('bmi_obese')->nullable();
            $table->integer('growth_problems')->nullable();
            $table->integer('anemia_cases')->nullable();
            $table->integer('referrals_made')->nullable();
            $table->text('referral_outcomes')->nullable();
            $table->integer('education_sessions')->nullable();
            $table->text('topics_covered')->nullable();
            $table->integer('students_reached')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('screening_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_health');
    }
};
