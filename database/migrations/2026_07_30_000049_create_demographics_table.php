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
        Schema::create('demographics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->integer('year');
            $table->integer('quarter')->nullable();
            $table->integer('month')->nullable();
            $table->integer('total_population');
            $table->integer('male_population')->nullable();
            $table->integer('female_population')->nullable();
            $table->integer('urban_population')->nullable();
            $table->integer('rural_population')->nullable();
            $table->json('age_group_data')->nullable();
            $table->integer('household_count')->nullable();
            $table->decimal('avg_household_size', 3, 1)->nullable();
            $table->integer('births')->nullable();
            $table->integer('deaths')->nullable();
            $table->integer('immigration')->nullable();
            $table->integer('emigration')->nullable();
            $table->json('marital_status_data')->nullable();
            $table->json('education_data')->nullable();
            $table->string('source', 100)->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['center_id', 'year']);
            $table->index('year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demographics');
    }
};
