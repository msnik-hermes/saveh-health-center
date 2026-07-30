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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('plate_number', 20)->unique();
            $table->string('make', 50);
            $table->string('model', 50);
            $table->integer('year');
            $table->string('color', 30)->nullable();
            $table->enum('vehicle_type', ['savari', 'van', 'ambulance', 'motor']);
            $table->string('engine_number', 50)->nullable();
            $table->string('chassis_number', 50)->nullable();
            $table->date('registration_expiry')->nullable();
            $table->string('insurance_number', 50)->nullable();
            $table->date('insurance_expiry')->nullable();
            $table->enum('fuel_type', ['benzin', 'doganeh', 'gaz', 'dizel'])->nullable();
            $table->decimal('tank_capacity', 6, 1)->nullable();
            $table->integer('total_mileage')->nullable();
            $table->foreignId('center_id')->nullable()->constrained('centers')->nullOnDelete();
            $table->string('photo', 255)->nullable();
            $table->enum('status', ['faal', 'dar_tamir', 'bazneshasteh'])->default('faal');
            $table->string('gps_device', 100)->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
