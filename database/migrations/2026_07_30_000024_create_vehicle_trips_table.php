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
        Schema::create('vehicle_trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete();
            $table->foreignId('driver_id')->constrained('drivers')->cascadeOnDelete();
            $table->foreignId('vehicle_request_id')->nullable()->constrained('vehicle_requests')->nullOnDelete();
            $table->date('trip_date');
            $table->time('departure_time');
            $table->time('return_time')->nullable();
            $table->string('origin', 200);
            $table->string('destination', 200);
            $table->text('route')->nullable();
            $table->integer('start_mileage');
            $table->integer('end_mileage')->nullable();
            $table->integer('total_distance')->nullable();
            $table->decimal('fuel_filled', 6, 1)->nullable();
            $table->decimal('fuel_cost', 12, 2)->nullable();
            $table->text('passenger_list')->nullable();
            $table->text('trip_purpose');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('vehicle_id');
            $table->index('driver_id');
            $table->index('trip_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_trips');
    }
};
