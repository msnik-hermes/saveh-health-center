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
        Schema::create('pregnant_women', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->string('national_code', 10);
            $table->string('full_name', 100);
            $table->integer('age');
            $table->string('husband_name', 100)->nullable();
            $table->string('phone', 15)->nullable();
            $table->text('address')->nullable();
            $table->string('village', 100)->nullable();
            $table->integer('gravida');
            $table->integer('parity');
            $table->integer('abortion_count')->nullable();
            $table->integer('living_children')->nullable();
            $table->date('lmp_date')->nullable();
            $table->date('edd_date')->nullable();
            $table->date('registration_date');
            $table->date('first_anc_date')->nullable();
            $table->string('blood_type', 5)->nullable();
            $table->string('rh_factor', 5)->nullable();
            $table->text('medical_history')->nullable();
            $table->json('risk_factors')->nullable();
            $table->text('current_medications')->nullable();
            $table->enum('tetanus_vaccination', ['anjam_shodeh', 'anjam_nashodeh'])->nullable();
            $table->boolean('iron_supplementation')->nullable();
            $table->boolean('folic_acid')->nullable();
            $table->integer('anc_visits_count')->nullable();
            $table->enum('status', ['faal', 'zayman_anjam_shodeh', 'enteghalyafteh', 'sagh']);
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
        Schema::dropIfExists('pregnant_women');
    }
};
