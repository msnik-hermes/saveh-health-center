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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->integer('fiscal_year');
            $table->string('budget_code', 50);
            $table->enum('category', ['karmandan', 'jari', 'barnamehee', 'sarmayee', 'darooee']);
            $table->string('sub_category', 100)->nullable();
            $table->string('unit_allocation', 100)->nullable();
            $table->decimal('allocated_amount', 18, 2);
            $table->decimal('spent_amount', 18, 2)->default(0);
            $table->decimal('committed_amount', 18, 2)->nullable();
            $table->decimal('remaining_amount', 18, 2);
            $table->decimal('utilization_pct', 5, 2)->nullable();
            $table->enum('status', ['dar_budje', 'bish_az_budje', 'kamtar_az_budje']);
            $table->text('justification')->nullable();
            $table->string('approval_authority', 200)->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['center_id', 'fiscal_year']);
            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
