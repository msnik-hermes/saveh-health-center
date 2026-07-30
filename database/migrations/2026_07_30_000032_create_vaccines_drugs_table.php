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
        Schema::create('vaccines_drugs', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('generic_name', 200)->nullable();
            $table->string('code', 50);
            $table->enum('type', ['vakans', 'daro']);
            $table->string('category', 100)->nullable();
            $table->string('manufacturer', 200)->nullable();
            $table->string('batch_number', 50);
            $table->date('expiry_date');
            $table->string('form', 50)->nullable();
            $table->string('strength', 50)->nullable();
            $table->decimal('unit_cost', 12, 2)->nullable();
            $table->integer('current_stock');
            $table->integer('minimum_stock');
            $table->integer('maximum_stock')->nullable();
            $table->string('storage_temperature', 50)->nullable();
            $table->string('storage_location', 200)->nullable();
            $table->boolean('is_controlled')->default(false);
            $table->enum('status', ['faal', 'manghee', 'ghair_faal']);
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('code');
            $table->index('type');
            $table->index('expiry_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccines_drugs');
    }
};
