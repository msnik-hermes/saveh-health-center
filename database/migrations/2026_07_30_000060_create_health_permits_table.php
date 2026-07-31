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
        Schema::create('health_permits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('establishment_id')->constrained('environmental_establishments')->cascadeOnDelete();
            $table->string('permit_type')->default('goahii_behdasht');
            $table->string('permit_number', 50);
            $table->date('issue_date');
            $table->date('expiry_date');
            $table->text('conditions')->nullable();
            $table->string('issuing_authority', 200);
            $table->foreignId('inspector_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->unsignedBigInteger('fee_paid')->nullable();
            $table->string('payment_reference', 50)->nullable();
            $table->string('status')->default('faal');
            $table->text('suspension_reason')->nullable();
            $table->integer('renewal_count')->default(0);
            $table->foreignId('previous_permit_id')->nullable()->constrained('health_permits')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('establishment_id');
            $table->index('status');
            $table->index('expiry_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_permits');
    }
};
