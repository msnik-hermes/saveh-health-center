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
        Schema::create('thyroid_screening', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->string('patient_national_code', 10);
            $table->integer('age');
            $table->enum('gender', ['mard', 'zan']);
            $table->enum('screening_type', ['jamiate', 'hadafmand']);
            $table->string('target_group', 100)->nullable();
            $table->string('goiter_grade', 20)->nullable();
            $table->decimal('urine_iodine', 8, 2)->nullable();
            $table->decimal('tsh_level', 6, 2)->nullable();
            $table->decimal('free_t4', 4, 2)->nullable();
            $table->text('thyroid_antibodies')->nullable();
            $table->string('diagnosis', 200)->nullable();
            $table->text('treatment_recommendation')->nullable();
            $table->date('screening_date');
            $table->date('follow_up_date')->nullable();
            $table->decimal('salt_iodine_test', 6, 2)->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('screening_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thyroid_screening');
    }
};
