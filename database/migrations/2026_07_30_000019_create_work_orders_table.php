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
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->foreignId('facility_request_id')->nullable()->constrained('facility_requests')->nullOnDelete();
            $table->string('order_number', 20)->unique();
            $table->enum('category', ['barq', 'loole_keshi', 'hvac', 'omoomi']);
            $table->string('location_building', 100)->nullable();
            $table->integer('location_floor')->nullable();
            $table->string('location_room', 50)->nullable();
            $table->enum('priority', ['ezterari', 'bala', 'adii', 'payeen']);
            $table->text('description');
            $table->foreignId('assigned_technician')->nullable()->constrained('employees')->nullOnDelete();
            $table->enum('status', ['mallaq', 'dar_anjam', 'anjam_shodeh', 'laghv_shodeh']);
            $table->dateTime('start_time')->nullable();
            $table->dateTime('completion_time')->nullable();
            $table->json('materials_used')->nullable();
            $table->decimal('cost', 12, 2)->nullable();
            $table->json('before_photos')->nullable();
            $table->json('after_photos')->nullable();
            $table->boolean('supervisor_approval')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('status');
            $table->index('facility_request_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
