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
        Schema::create('center_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->string('room_number', 20);
            $table->string('name', 100);
            $table->enum('usage_type', ['daftar', 'darmangah', 'azmayeshgah', 'darakhoneh', 'entezar', 'anbar', 'servis', 'ashpazkhane', 'jalseh', 'saln_varzesh']);
            $table->integer('floor');
            $table->decimal('area_sqm', 8, 2)->nullable();
            $table->integer('capacity')->nullable();
            $table->enum('status', ['faal', 'dar_tamir', 'ghair_faal'])->default('faal');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index(['center_id', 'floor']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('center_rooms');
    }
};
