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
        Schema::create('training_materials', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('type')->default('poster');
            $table->string('category', 100);
            $table->string('target_audience', 200)->nullable();
            $table->string('language', 50)->nullable();
            $table->date('production_date');
            $table->string('designer', 100)->nullable();
            $table->string('reviewer', 100)->nullable();
            $table->string('approval_status')->default('pishnevis');
            $table->integer('print_quantity')->nullable();
            $table->string('digital_format', 50)->nullable();
            $table->string('file_location', 255)->nullable();
            $table->integer('version')->default(1);
            $table->unsignedBigInteger('cost')->nullable();
            $table->integer('current_stock')->nullable();
            $table->integer('minimum_stock')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('category');
            $table->index('approval_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_materials');
    }
};
