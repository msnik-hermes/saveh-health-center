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
        Schema::create('center_utilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->string('utility_type')->default('ab');
            $table->string('company', 200);
            $table->string('meter_number', 50)->nullable();
            $table->string('bill_id', 50)->nullable();
            $table->string('account_number', 50)->nullable();
            $table->string('meter_type', 50)->nullable();
            $table->string('capacity', 50)->nullable();
            $table->decimal('last_reading', 12, 2)->nullable();
            $table->decimal('avg_consumption', 12, 2)->nullable();
            $table->decimal('peak_consumption', 12, 2)->nullable();
            $table->decimal('offpeak_consumption', 12, 2)->nullable();
            $table->unsignedBigInteger('monthly_cost')->nullable();
            $table->string('payment_status')->default('pardakht_shodeh');
            $table->date('last_reading_date')->nullable();
            $table->date('last_payment_date')->nullable();
            $table->string('last_payment_tracking', 50)->nullable();
            $table->string('contract_number', 100)->nullable();
            $table->date('contract_start')->nullable();
            $table->date('contract_end')->nullable();
            $table->string('internet_type', 20)->nullable();
            $table->string('internet_speed', 20)->nullable();
            $table->string('internet_ip', 45)->nullable();
            $table->string('internet_modem', 100)->nullable();
            $table->string('internet_firewall', 100)->nullable();
            $table->boolean('internet_vpn')->nullable();
            $table->boolean('has_emergency_power')->default(false);
            $table->foreignId('bank_account_id')->nullable()->constrained('center_bank_accounts')->nullOnDelete();
            $table->string('status')->default('faal');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('utility_type');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('center_utilities');
    }
};
