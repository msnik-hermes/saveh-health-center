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
        Schema::create('maternal_health', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pregnant_woman_id')->constrained('pregnant_women')->cascadeOnDelete();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->date('visit_date');
            $table->string('visit_type')->default('ANC');
            $table->integer('gestational_week')->nullable();
            $table->decimal('weight', 5, 1)->nullable();
            $table->string('blood_pressure', 10)->nullable();
            $table->string('urine_protein', 20)->nullable();
            $table->string('urine_sugar', 20)->nullable();
            $table->boolean('fetal_heartbeat')->nullable();
            $table->decimal('fundal_height', 4, 1)->nullable();
            $table->decimal('hemoglobin', 4, 1)->nullable();
            $table->boolean('ultrasound_performed')->nullable();
            $table->text('complications')->nullable();
            $table->json('screening_results')->nullable();
            $table->integer('tetanus_dose')->nullable();
            $table->date('next_visit_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('delivery_type')->default('tabiii')->nullable();
            $table->string('delivery_location', 100)->nullable();
            $table->integer('postnatal_visits')->nullable();
            $table->text('pnc_complications')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('pregnant_woman_id');
            $table->index('center_id');
            $table->index('visit_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maternal_health');
    }
};
