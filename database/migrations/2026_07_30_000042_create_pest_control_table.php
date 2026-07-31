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
        Schema::create('pest_control', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->date('survey_date');
            $table->string('location', 200);
            $table->decimal('gps_lat', 10, 8)->nullable();
            $table->decimal('gps_lng', 11, 8)->nullable();
            $table->string('area_type')->default('shahri');
            $table->string('pest_type')->default('mush');
            $table->string('trap_type', 100)->nullable();
            $table->integer('traps_deployed');
            $table->integer('traps_checked')->nullable();
            $table->integer('total_catches')->nullable();
            $table->string('species_identified', 200)->nullable();
            $table->text('disease_testing')->nullable();
            $table->text('environmental_conditions')->nullable();
            $table->text('previous_control')->nullable();
            $table->text('recommended_actions')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('survey_date');
            $table->index('pest_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pest_control');
    }
};
