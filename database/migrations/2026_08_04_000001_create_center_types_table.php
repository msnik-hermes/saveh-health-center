<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('center_types')) {
            Schema::create('center_types', function (Blueprint $table) {
                $table->id();
                $table->string('name', 100);
                $table->string('code', 50)->nullable()->unique();
                $table->text('description')->nullable();
                $table->unsignedInteger('capacity')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('center_center_type')) {
            Schema::create('center_center_type', function (Blueprint $table) {
                $table->id();
                $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
                $table->foreignId('center_type_id')->constrained('center_types')->cascadeOnDelete();
                $table->timestamps();
                $table->unique(['center_id', 'center_type_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('center_center_type');
        Schema::dropIfExists('center_types');
    }
};
