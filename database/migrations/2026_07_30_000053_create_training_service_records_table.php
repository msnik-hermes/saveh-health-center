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
        Schema::create('training_service_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->foreignId('material_id')->nullable()->constrained('training_materials')->nullOnDelete();
            $table->date('session_date');
            $table->string('session_type')->default('kargah');
            $table->string('topic', 200);
            $table->string('trainer', 100)->nullable();
            $table->decimal('duration_hours', 4, 1)->nullable();
            $table->integer('participants_count');
            $table->integer('unique_reached')->nullable();
            $table->json('attendance_list')->nullable();
            $table->decimal('evaluation_score', 4, 2)->nullable();
            $table->string('location', 200)->nullable();
            $table->json('photos')->nullable();
            $table->unsignedBigInteger('cost')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('session_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_service_records');
    }
};
