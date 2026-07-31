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
        Schema::create('supply_inventory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->string('item_name', 200);
            $table->string('category')->default('edari');
            $table->integer('current_quantity');
            $table->integer('minimum_quantity');
            $table->string('unit', 50);
            $table->unsignedBigInteger('unit_cost')->nullable();
            $table->date('last_restock_date')->nullable();
            $table->string('supplier', 200)->nullable();
            $table->string('storage_location', 200)->nullable();
            $table->string('status')->default('kafi');
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
        Schema::dropIfExists('supply_inventory');
    }
};
