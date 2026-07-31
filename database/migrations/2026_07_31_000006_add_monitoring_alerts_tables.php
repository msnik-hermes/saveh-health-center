<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // تقویت جدول مانیتورینگ شبکه
        Schema::table('network_monitoring_logs', function (Blueprint $table) {
            $table->foreignId('center_id')->nullable()->after('connection_id')->constrained('centers')->nullOnDelete();
            $table->string('public_ip', 45)->nullable()->after('check_time');
            $table->string('previous_ip', 45)->nullable()->after('public_ip');
            $table->boolean('ip_changed')->default(false)->after('previous_ip');
            $table->boolean('alert_sent')->default(false)->after('ip_changed');
            $table->string('alert_level', 20)->nullable()->after('alert_sent');
        });

        // جدول هشدارهای خودکار
        Schema::create('system_alerts', function (Blueprint $table) {
            $table->id();
            $table->string('alert_type', 50); // network_down, network_slow, ip_changed, contract_expiry, insurance_expiry, license_expiry, fuel_high, km_high
            $table->string('severity', 20); // critical, warning, info
            $table->string('target_type', 50); // center, vehicle, employee, connection
            $table->unsignedBigInteger('target_id');
            $table->string('title', 200);
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->foreignId('resolved_by')->nullable()->constrained('employees')->nullOnDelete();
            $table->timestamp('resolved_at')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->timestamps();

            $table->index('alert_type');
            $table->index('severity');
            $table->index(['target_type', 'target_id']);
            $table->index('is_read');
        });

        // جدول لاگ پرداخت قبوض
        Schema::create('utility_payment_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utility_id')->constrained('center_utilities')->cascadeOnDelete();
            $table->foreignId('bank_account_id')->nullable()->constrained('center_bank_accounts')->nullOnDelete();
            $table->unsignedBigInteger('amount');
            $table->string('tracking_number', 50)->nullable();
            $table->string('payment_method', 50)->default('online'); // online, manual, auto
            $table->boolean('auto_paid')->default(false);
            $table->string('status', 20)->default('pending'); // pending, confirmed, failed
            $table->text('response_data')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('utility_id');
            $table->index('status');
            $table->index('auto_paid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('utility_payment_logs');
        Schema::dropIfExists('system_alerts');

        Schema::table('network_monitoring_logs', function (Blueprint $table) {
            $table->dropColumn([
                'center_id', 'public_ip', 'previous_ip', 'ip_changed',
                'alert_sent', 'alert_level',
            ]);
        });
    }
};
