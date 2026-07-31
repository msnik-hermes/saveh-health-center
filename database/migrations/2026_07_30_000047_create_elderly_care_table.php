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
        Schema::create('elderly_care', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->string('national_code', 10);
            $table->string('full_name', 100);
            $table->integer('age');
            $table->string('gender')->default('mard');
            $table->text('address')->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('village', 100)->nullable();
            $table->json('chronic_diseases')->nullable();
            $table->json('medications')->nullable();
            $table->string('cognitive_screening')->default('tabii')->nullable();
            $table->string('depression_screening')->default('tabii')->nullable();
            $table->string('mobility_status')->default('mostaghel')->nullable();
            $table->string('fall_risk')->default('payeen')->nullable();
            $table->string('nutrition_status')->default('monaseb')->nullable();
            $table->json('vaccination_status')->nullable();
            $table->date('last_checkup_date')->nullable();
            $table->text('caregiver_info')->nullable();
            $table->string('social_support')->default('khanevadeh')->nullable();
            $table->json('services_provided')->nullable();
            $table->text('referrals')->nullable();
            $table->string('status')->default('faal');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('national_code');
            $table->index('phone');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elderly_care');
    }
};
