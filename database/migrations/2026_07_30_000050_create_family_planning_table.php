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
        Schema::create('family_planning', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->string('woman_national_code', 10);
            $table->string('woman_name', 100)->nullable();
            $table->integer('age');
            $table->string('education_level', 50)->nullable();
            $table->integer('living_children');
            $table->integer('pregnancies_count')->nullable();
            $table->integer('desired_family_size')->nullable();
            $table->string('current_method')->default('tabiii');
            $table->date('method_start_date');
            $table->json('method_change_history')->nullable();
            $table->text('side_effects')->nullable();
            $table->integer('method_satisfaction')->nullable();
            $table->integer('counseling_sessions')->nullable();
            $table->date('last_visit_date')->nullable();
            $table->date('next_visit_date')->nullable();
            $table->string('pregnancy_status')->default('bardar')->nullable();
            $table->string('referred_to', 100)->nullable();
            $table->string('status')->default('faal');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('woman_national_code');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_planning');
    }
};
