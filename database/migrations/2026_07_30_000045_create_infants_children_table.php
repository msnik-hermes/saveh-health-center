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
        Schema::create('infants_children', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pregnant_woman_id')->nullable()->constrained('pregnant_women')->nullOnDelete();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->string('child_national_code', 10)->nullable();
            $table->string('child_name', 100)->nullable();
            $table->date('birth_date');
            $table->string('gender')->default('mard');
            $table->decimal('birth_weight', 5, 1)->nullable();
            $table->decimal('birth_length', 4, 1)->nullable();
            $table->integer('gestational_age')->nullable();
            $table->string('apgar_score', 5)->nullable();
            $table->text('birth_complications')->nullable();
            $table->boolean('breastfeeding_initiated')->nullable();
            $table->string('breastfeeding_type')->default('enhessari')->nullable();
            $table->json('growth_monitoring')->nullable();
            $table->json('vaccination_status')->nullable();
            $table->json('development_milestones')->nullable();
            $table->date('last_checkup_date')->nullable();
            $table->text('health_problems')->nullable();
            $table->text('referrals')->nullable();
            $table->string('status')->default('faal');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('child_national_code');
            $table->index('birth_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infants_children');
    }
};
