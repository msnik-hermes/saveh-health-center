<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organizational_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('organizational_units')->nullOnDelete();
            $table->string('code', 20)->unique();
            $table->string('name', 100);
            $table->string('name_en', 100)->nullable();
            $table->foreignId('head_employee_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->string('phone', 20)->nullable();
            $table->unsignedBigInteger('budget_allocation')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('faal');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('parent_id');
            $table->index('code');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organizational_units');
    }
};
