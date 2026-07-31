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
        Schema::create('suicide_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->string('case_id', 20);
            $table->string('full_name', 100);
            $table->string('national_code', 10);
            $table->integer('age');
            $table->string('gender')->default('mard');
            $table->string('marital_status')->default('motahel')->nullable();
            $table->string('education_level', 50)->nullable();
            $table->string('occupation', 100)->nullable();
            $table->string('employment_status')->default('shaghel')->nullable();
            $table->integer('children_count')->nullable();
            $table->integer('family_size')->nullable();
            $table->string('income_level', 50)->nullable();
            $table->string('district', 100);
            $table->string('city_village', 100);
            $table->string('neighborhood', 100)->nullable();
            $table->string('urban_rural')->default('shahri');
            $table->date('event_date');
            $table->time('event_time')->nullable();
            $table->string('event_location', 200)->nullable();
            $table->string('method')->default('halaq_aviz');
            $table->boolean('premeditated')->nullable();
            $table->boolean('prior_communication')->nullable();
            $table->boolean('witnesses_present')->nullable();
            $table->integer('prior_attempts')->nullable();
            $table->text('prior_attempt_dates')->nullable();
            $table->json('mental_health_diagnosis')->nullable();
            $table->boolean('psychiatric_treatment')->nullable();
            $table->boolean('substance_use')->nullable();
            $table->json('recent_life_events')->nullable();
            $table->string('suicidal_intent')->default('payeen')->nullable();
            $table->boolean('suicidal_plan')->nullable();
            $table->decimal('hopelessness_score', 4, 1)->nullable();
            $table->decimal('depression_score', 4, 1)->nullable();
            $table->decimal('anxiety_score', 4, 1)->nullable();
            $table->boolean('survived');
            $table->string('injury_severity')->default('khafif')->nullable();
            $table->boolean('hospital_admission')->nullable();
            $table->string('hospital_name', 200)->nullable();
            $table->integer('length_of_stay')->nullable();
            $table->string('outcome')->default('behbood');
            $table->date('date_of_death')->nullable();
            $table->text('cause_of_death')->nullable();
            $table->text('follow_up_plan')->nullable();
            $table->integer('emergency_response_time')->nullable();
            $table->boolean('social_services_involved')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('national_code');
            $table->index('event_date');
            $table->index('outcome');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suicide_statistics');
    }
};
