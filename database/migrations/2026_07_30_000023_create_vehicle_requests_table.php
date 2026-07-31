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
        Schema::create('vehicle_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->foreignId('requested_by')->constrained('employees')->cascadeOnDelete();
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles')->nullOnDelete();
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->nullOnDelete();
            $table->text('trip_purpose');
            $table->string('origin', 200);
            $table->string('destination', 200);
            $table->dateTime('departure_datetime');
            $table->dateTime('expected_return')->nullable();
            $table->integer('passenger_count')->nullable();
            $table->text('passenger_list')->nullable();
            $table->string('status')->default('ersal_shodeh');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('status');
            $table->index('vehicle_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_requests');
    }
};
