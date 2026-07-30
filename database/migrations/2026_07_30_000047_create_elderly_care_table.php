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
            $table->enum('gender', ['mard', 'zan']);
            $table->text('address')->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('village', 100)->nullable();
            $table->json('chronic_diseases')->nullable();
            $table->json('medications')->nullable();
            $table->enum('cognitive_screening', ['tabii', 'khalal_shenakhti', 'zaval_aagh'])->nullable();
            $table->enum('depression_screening', ['tabii', 'afsordegi'])->nullable();
            $table->enum('mobility_status', ['mostaghel', 'komak_lazem', 'bastari'])->nullable();
            $table->enum('fall_risk', ['payeen', 'motevaset', 'bala'])->nullable();
            $table->enum('nutrition_status', ['monaseb', 'taghzie_nادرست', 'sootagzieh'])->nullable();
            $table->json('vaccination_status')->nullable();
            $table->date('last_checkup_date')->nullable();
            $table->text('caregiver_info')->nullable();
            $table->enum('social_support', ['khanevadeh', 'nahadi', 'bedoon_hemayat'])->nullable();
            $table->json('services_provided')->nullable();
            $table->text('referrals')->nullable();
            $table->enum('status', ['faal', 'enteghalyafteh', 'faut']);
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('national_code');
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
