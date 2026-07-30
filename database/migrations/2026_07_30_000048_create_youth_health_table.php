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
        Schema::create('youth_health', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->string('national_code', 10);
            $table->string('full_name', 100);
            $table->integer('age');
            $table->enum('gender', ['mard', 'zan']);
            $table->enum('age_group', ['10_14', '15_19', '20_24']);
            $table->string('education_level', 50)->nullable();
            $table->string('program_attended', 200)->nullable();
            $table->date('session_date')->nullable();
            $table->text('topics_covered')->nullable();
            $table->json('health_screening_results')->nullable();
            $table->enum('mental_health_screening', ['tabii', 'niaz_be_barresi'])->nullable();
            $table->enum('substance_abuse_screening', ['tabii', 'niaz_be_barresi'])->nullable();
            $table->decimal('bmi', 4, 1)->nullable();
            $table->json('risk_behaviors')->nullable();
            $table->text('referrals_made')->nullable();
            $table->string('follow_up_status', 100)->nullable();
            $table->enum('status', ['faal', 'payan']);
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
        Schema::dropIfExists('youth_health');
    }
};
