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
            $table->enum('line_type', ['sabit', 'voip', 'mobile', 'fax']);
            $table->string('provider', 100)->nullable();
            $table->string('bill_id', 50)->nullable();
            $table->string('account_number', 50)->nullable();
            $table->decimal('monthly_cost', 12, 2)->nullable();
            $table->string('department', 100)->nullable();
            $table->enum('status', ['faal', 'qat', 'taaliq'])->default('faal');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
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
