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
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->foreignId('bank_account_id')->constrained('center_bank_accounts')->cascadeOnDelete();
            $table->string('type')->default('pardakht_ghebz');
            $table->string('category', 100);
            $table->unsignedBigInteger('amount');
            $table->text('description');
            $table->string('reference_number', 100)->nullable();
            $table->string('bill_id', 50)->nullable();
            $table->foreignId('utility_id')->nullable()->constrained('center_utilities')->nullOnDelete();
            $table->foreignId('form_submission_id')->nullable()->constrained('form_submissions')->nullOnDelete();
            $table->foreignId('budget_id')->nullable()->constrained('budgets')->nullOnDelete();
            $table->string('invoice_number', 100)->nullable();
            $table->string('payee_name', 200)->nullable();
            $table->string('payment_method')->default('entegal_banki')->nullable();
            $table->date('transaction_date');
            $table->string('status')->default('anjam_shodeh');
            $table->foreignId('approved_by')->nullable()->constrained('employees')->nullOnDelete();
            $table->date('approval_date')->nullable();
            $table->json('attachments')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('bank_account_id');
            $table->index('type');
            $table->index('status');
            $table->index('transaction_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_transactions');
    }
};
