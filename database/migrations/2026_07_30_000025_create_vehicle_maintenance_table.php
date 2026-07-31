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
        Schema::create('vehicle_maintenance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete();
            $table->date('service_date');
            $table->string('service_type')->default('dorei');
            $table->integer('mileage_at_service');
            $table->text('description');
            $table->json('parts_replaced')->nullable();
            $table->string('service_provider', 200)->nullable();
            $table->unsignedBigInteger('cost');
            $table->integer('next_service_mileage')->nullable();
            $table->date('next_service_date')->nullable();
            $table->string('invoice', 255)->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('vehicle_id');
            $table->index('service_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_maintenance');
    }
};
