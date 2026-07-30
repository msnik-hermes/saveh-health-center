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
        Schema::create('training_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained('training_materials')->cascadeOnDelete();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->date('distribution_date');
            $table->enum('distribution_method', ['mostaqeem', 'behvarz', 'madrese', 'karkhaneh', 'rouzad', 'digital']);
            $table->string('distributor', 100)->nullable();
            $table->string('target_group', 100)->nullable();
            $table->integer('quantity');
            $table->text('purpose')->nullable();
            $table->string('campaign', 200)->nullable();
            $table->boolean('recipient_ack')->nullable();
            $table->text('feedback')->nullable();
            $table->json('photos')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('material_id');
            $table->index('center_id');
            $table->index('distribution_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_distributions');
    }
};
