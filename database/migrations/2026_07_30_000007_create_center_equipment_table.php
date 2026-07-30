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
        Schema::create('center_equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->enum('category', ['pezeshki', 'edari', 'fanni', 'mobleman', 'it']);
            $table->string('name', 200);
            $table->string('model', 100)->nullable();
            $table->string('manufacturer', 200)->nullable();
            $table->string('serial_number', 100)->nullable();
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_price', 18, 2)->nullable();
            $table->decimal('depreciation_value', 18, 2)->nullable();
            $table->date('warranty_end')->nullable();
            $table->string('location', 200)->nullable();
            $table->foreignId('room_id')->nullable()->constrained('center_rooms')->nullOnDelete();
            $table->enum('status', ['faal', 'dar_tamir', 'bazneshasteh'])->default('faal');
            $table->integer('condition_rating')->nullable();
            $table->date('last_maintenance')->nullable();
            $table->date('next_maintenance')->nullable();
            $table->integer('maintenance_interval')->nullable();
            $table->foreignId('custodian_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->enum('insurance_status', ['bimeshodeh', 'bimnashodeh'])->nullable();
            $table->json('documents')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('category');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('center_equipment');
    }
};
