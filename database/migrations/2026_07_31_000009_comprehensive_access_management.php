<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // جدول نقش‌ها
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->text('description')->nullable();
            $table->string('hierarchy_level')->default('unit_staff');
            $table->boolean('is_system')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->index('hierarchy_level');
            $table->index('is_system');
        });

        // جدول سطوح دسترسی
        Schema::create('access_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->integer('level')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->index('level');
        });

        // جدول دسترسی‌ها
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 150)->unique();
            $table->string('module', 50);
            $table->string('action', 50);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('access_level_id');
            $table->boolean('requires_approval')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('access_level_id')->references('id')->on('access_levels');
            $table->index('module');
            $table->index('action');
            $table->index('access_level_id');
        });

        // جدول نقش‌های کاربران
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('center_id')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->index('user_id');
            $table->index('role_id');
            $table->index('unit_id');
            $table->index('center_id');
            $table->index('is_active');
        });

        // جدول دسترسی‌های نقش
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('permission_id');
            $table->boolean('is_granted')->default(true);
            $table->timestamps();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('permission_id')->references('id')->on('permissions');
            $table->unique(['role_id', 'permission_id']);
        });

        // جدول دسترسی‌های ویژه کاربر
        Schema::create('user_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('permission_id');
            $table->boolean('is_granted')->default(true);
            $table->date('expires_at')->nullable();
            $table->text('reason')->nullable();
            $table->unsignedBigInteger('granted_by');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('permission_id')->references('id')->on('permissions');
            $table->foreign('granted_by')->references('id')->on('users');
            $table->index('user_id');
            $table->index('permission_id');
            $table->index('expires_at');
        });

        // جدول محدودیت‌های واحد
        Schema::create('unit_access_restrictions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('role_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('restriction_type', ['restrict', 'allow']);
            $table->string('resource_type', 50);
            $table->text('conditions')->nullable();
            $table->timestamps();
            $table->foreign('unit_id')->references('id')->on('organizational_units');
            $table->index('unit_id');
            $table->index('role_id');
            $table->index('user_id');
            $table->index('restriction_type');
        });

        // جدول سطوح دسترسی مدیران
        Schema::create('manager_access_levels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('access_level_id');
            $table->boolean('can_approve')->default(false);
            $table->boolean('can_escalate')->default(false);
            $table->boolean('can_override')->default(false);
            $table->timestamps();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('access_level_id')->references('id')->on('access_levels');
            $table->unique(['role_id', 'access_level_id']);
        });

        // جدول گزارش‌های دسترسی
        Schema::create('access_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('report_type', 50);
            $table->text('filters')->nullable();
            $table->text('results')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->index('user_id');
            $table->index('report_type');
        });

        // جدول تغییرات دسترسی
        Schema::create('access_changes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('changed_by');
            $table->string('change_type', 50);
            $table->string('old_value', 255)->nullable();
            $table->string('new_value', 255)->nullable();
            $table->text('reason')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('changed_by')->references('id')->on('users');
            $table->index('user_id');
            $table->index('changed_by');
            $table->index('change_type');
        });

        // جدول جلسات فعال
        Schema::create('active_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('session_id', 100)->unique();
            $table->string('ip_address', 45);
            $table->text('user_agent')->nullable();
            $table->string('device_type', 50)->nullable();
            $table->timestamp('last_activity');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->index('user_id');
            $table->index('last_activity');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('active_sessions');
        Schema::dropIfExists('access_changes');
        Schema::dropIfExists('access_reports');
        Schema::dropIfExists('manager_access_levels');
        Schema::dropIfExists('unit_access_restrictions');
        Schema::dropIfExists('user_permissions');
        Schema::dropIfExists('role_permissions');
        Schema::dropIfExists('user_roles');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('access_levels');
        Schema::dropIfExists('roles');
    }
};