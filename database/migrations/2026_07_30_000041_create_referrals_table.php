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
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->string('patient_national_code', 10);
            $table->date('referral_date');
            $table->string('referring_clinician', 100);
            $table->string('referring_unit', 100);
            $table->text('reason');
            $table->string('urgency')->default('adii');
            $table->string('referred_to_facility', 200);
            $table->string('referred_to_specialty', 100)->nullable();
            $table->string('referred_to_clinician', 100)->nullable();
            $table->json('documentation_sent')->nullable();
            $table->date('appointment_date')->nullable();
            $table->boolean('patient_attended')->nullable();
            $table->text('non_attendance_reason')->nullable();
            $table->text('outcome')->nullable();
            $table->boolean('report_received')->nullable();
            $table->date('report_date')->nullable();
            $table->string('status')->default('ersal_shodeh');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('patient_national_code');
            $table->index('referral_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
