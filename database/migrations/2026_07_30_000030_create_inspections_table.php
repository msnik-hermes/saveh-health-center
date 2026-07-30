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
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->foreignId('inspector_id')->constrained('employees')->cascadeOnDelete();
            $table->enum('inspection_type', ['behdashti', 'aymani', 'fanni', 'maali', 'keifi']);
            $table->date('date');
            $table->text('findings');
            $table->enum('compliance_status', ['motlob', 'niaz_be_eslah', 'bahrani']);
            $table->json('corrective_actions')->nullable();
            $table->json('images')->nullable();
            $table->date('next_inspection_date')->nullable();
            $table->enum('status', ['takmil_shodeh', 'dar_barresi']);
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('inspection_type');
            $table->index('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
