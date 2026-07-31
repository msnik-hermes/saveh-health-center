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
        Schema::create('facility_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->foreignId('requested_by')->constrained('employees')->cascadeOnDelete();
            $table->string('facility_type')->default('loole_keshi');
            $table->string('location', 200);
            $table->text('description');
            $table->string('priority')->default('adii');
            $table->dateTime('preferred_time')->nullable();
            $table->boolean('budget_approval')->nullable();
            $table->json('images')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('employees')->nullOnDelete();
            $table->string('status')->default('ersal_shodeh');
            $table->date('completion_date')->nullable();
            $table->unsignedBigInteger('cost')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('status');
            $table->index('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facility_requests');
    }
};
