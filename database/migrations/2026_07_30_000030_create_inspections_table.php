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
            $table->string('inspection_type')->default('behdashti');
            $table->date('date');
            $table->text('findings');
            $table->string('compliance_status')->default('motlob');
            $table->json('corrective_actions')->nullable();
            $table->json('images')->nullable();
            $table->date('next_inspection_date')->nullable();
            $table->string('status')->default('takmil_shodeh');
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
