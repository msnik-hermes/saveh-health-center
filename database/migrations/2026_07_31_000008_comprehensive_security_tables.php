<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // لاگ ورود/خروج کاربران
        Schema::create('user_login_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->string('device_type', 50)->nullable(); // mobile, desktop, tablet
            $table->string('browser', 100)->nullable();
            $table->string('os', 100)->nullable();
            $table->string('location', 200)->nullable();
            $table->string('login_type', 20)->default('password'); // password, token, 2fa
            $table->boolean('is_successful')->default(true);
            $table->text('failure_reason')->nullable();
            $table->timestamp('login_at')->useCurrent();
            $table->timestamp('logout_at')->nullable();
            $table->integer('session_duration_minutes')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('login_at');
            $table->index('is_successful');
            $table->index('ip_address');
        });

        // لاگ تغییرات داده (Audit Trail)
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action', 20); // create, update, delete, view, export
            $table->string('model_type', 100);
            $table->unsignedBigInteger('model_id');
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->json('changed_fields')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->text('description')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('user_id');
            $table->index(['model_type', 'model_id']);
            $table->index('action');
            $table->index('created_at');
        });

        // محدودیت نرخ درخواست‌ها
        Schema::create('rate_limits', function (Blueprint $table) {
            $table->id();
            $table->string('key', 255);
            $table->string('ip_address', 45)->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('endpoint', 200);
            $table->integer('attempts')->default(1);
            $table->timestamp('last_attempt_at')->useCurrent();
            $table->timestamp('blocked_until')->nullable();
            $table->timestamps();

            $table->index('key');
            $table->index('ip_address');
            $table->index('user_id');
        });

        // گواهی‌نامه‌های دیجیتال
        Schema::create('digital_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('certificate_type', 50); // ssl, code_signing, email
            $table->text('certificate_data');
            $table->text('private_key')->nullable();
            $table->date('issued_at');
            $table->date('expires_at');
            $table->foreignId('issued_to')->nullable()->constrained('employees')->nullOnDelete();
            $table->foreignId('center_id')->nullable()->constrained('centers')->nullOnDelete();
            $table->string('status', 20)->default('faal');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('expires_at');
            $table->index('status');
        });

        // لاگ API
        Schema::create('api_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('method', 10); // GET, POST, PUT, DELETE
            $table->string('endpoint', 500);
            $table->json('request_headers')->nullable();
            $table->json('request_body')->nullable();
            $table->integer('response_code')->nullable();
            $table->json('response_body')->nullable();
            $table->integer('response_time_ms')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->boolean('is_error')->default(false);
            $table->text('error_message')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('user_id');
            $table->index('endpoint');
            $table->index('response_code');
            $table->index('created_at');
            $table->index('is_error');
        });

        // پشتیبان‌گیری خودکار
        Schema::create('backup_logs', function (Blueprint $table) {
            $table->id();
            $table->string('backup_type', 20); // full, incremental, differential
            $table->string('status', 20)->default('running'); // running, completed, failed
            $table->string('file_path', 500)->nullable();
            $table->unsignedBigInteger('file_size_bytes')->nullable();
            $table->integer('duration_seconds')->nullable();
            $table->text('error_message')->nullable();
            $table->foreignId('triggered_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index('backup_type');
            $table->index('status');
            $table->index('started_at');
        });

        // سیاست‌های امنیتی
        Schema::create('security_policies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->string('policy_type', 50); // password, session, access, data
            $table->json('rules');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('policy_type');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('security_policies');
        Schema::dropIfExists('backup_logs');
        Schema::dropIfExists('api_logs');
        Schema::dropIfExists('digital_certificates');
        Schema::dropIfExists('rate_limits');
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('user_login_logs');
    }
};
