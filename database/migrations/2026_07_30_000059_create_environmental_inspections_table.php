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
        Schema::create('environmental_inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('establishment_id')->constrained('environmental_establishments')->cascadeOnDelete();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->foreignId('inspector_id')->constrained('employees')->cascadeOnDelete();
            $table->enum('inspection_type', ['adii', 'barnamehee', 'shekaayat', 'peygiri', 'ghabl_az_bazgashtayee']);
            $table->date('inspection_date');
            $table->integer('personal_hygiene_score')->nullable();
            $table->integer('facility_conditions_score')->nullable();
            $table->integer('food_safety_score')->nullable();
            $table->integer('cleaning_sanitation_score')->nullable();
            $table->integer('pest_control_score')->nullable();
            $table->integer('water_quality_score')->nullable();
            $table->integer('chemical_safety_score')->nullable();
            $table->integer('waste_management_score')->nullable();
            $table->decimal('overall_score', 5, 2);
            $table->enum('compliance_level', ['monaseb', 'nime_monaseb', 'namonaseb']);
            $table->integer('critical_violations')->nullable();
            $table->integer('major_violations')->nullable();
            $table->integer('minor_violations')->nullable();
            $table->json('violations_detail')->nullable();
            $table->text('positive_findings')->nullable();
            $table->json('images')->nullable();
            $table->text('recommendations')->nullable();
            $table->json('corrective_actions')->nullable();
            $table->boolean('follow_up_needed')->default(false);
            $table->date('follow_up_date')->nullable();
            $table->enum('status', ['takmil_shodeh', 'peygiri']);
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('establishment_id');
            $table->index('center_id');
            $table->index('inspection_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('environmental_inspections');
    }
};
