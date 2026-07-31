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
        Schema::create('center_phone_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->string('phone_number', 20);
            $table->string('line_type')->default('sabit');
            $table->string('provider', 100)->nullable();
            $table->string('bill_id', 50)->nullable();
            $table->string('account_number', 50)->nullable();
            $table->unsignedBigInteger('monthly_cost')->nullable();
            $table->string('department', 100)->nullable();
            $table->string('status')->default('faal');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('phone_number');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('center_phone_lines');
    }
};
