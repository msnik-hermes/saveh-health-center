<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('facility_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('facility_requests', 'request_number')) {
                $table->string('request_number', 30)->unique()->after('id');
            }
            if (!Schema::hasColumn('facility_requests', 'unit_id')) {
                $table->foreignId('unit_id')->nullable()->after('requested_by')->constrained('organizational_units')->nullOnDelete();
            }
            if (!Schema::hasColumn('facility_requests', 'exact_location')) {
                $table->string('exact_location', 300)->nullable()->after('location');
            }
            if (!Schema::hasColumn('facility_requests', 'before_images')) {
                $table->json('before_images')->nullable();
            }
            if (!Schema::hasColumn('facility_requests', 'after_images')) {
                $table->json('after_images')->nullable();
            }
            if (!Schema::hasColumn('facility_requests', 'materials_used')) {
                $table->json('materials_used')->nullable();
            }
            if (!Schema::hasColumn('facility_requests', 'work_start_time')) {
                $table->time('work_start_time')->nullable();
            }
            if (!Schema::hasColumn('facility_requests', 'work_end_time')) {
                $table->time('work_end_time')->nullable();
            }
            if (!Schema::hasColumn('facility_requests', 'approved_by')) {
                $table->foreignId('approved_by')->nullable()->after('assigned_to')->constrained('employees')->nullOnDelete();
            }
            if (!Schema::hasColumn('facility_requests', 'approved_at')) {
                $table->timestamp('approved_at')->nullable();
            }
            if (!Schema::hasColumn('facility_requests', 'approval_notes')) {
                $table->text('approval_notes')->nullable();
            }
            if (!Schema::hasColumn('facility_requests', 'service_provided')) {
                $table->string('service_provided', 200)->nullable();
            }
            if (!Schema::hasColumn('facility_requests', 'satisfaction')) {
                $table->string('satisfaction')->nullable();
            }
        });

        Schema::table('vehicle_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('vehicle_requests', 'request_number')) {
                $table->string('request_number', 30)->unique()->after('id');
            }
            if (!Schema::hasColumn('vehicle_requests', 'destination')) {
                $table->string('destination', 300)->nullable()->after('purpose');
            }
            if (!Schema::hasColumn('vehicle_requests', 'distance_km')) {
                $table->decimal('distance_km', 8, 2)->nullable()->after('destination');
            }
            if (!Schema::hasColumn('vehicle_requests', 'approved_by')) {
                $table->foreignId('approved_by')->nullable()->after('driver_id')->constrained('employees')->nullOnDelete();
            }
            if (!Schema::hasColumn('vehicle_requests', 'approved_at')) {
                $table->timestamp('approved_at')->nullable();
            }
            if (!Schema::hasColumn('vehicle_requests', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('facility_requests', function (Blueprint $table) {
            $table->dropColumn([
                'request_number', 'unit_id', 'exact_location',
                'before_images', 'after_images', 'materials_used',
                'work_start_time', 'work_end_time',
                'approved_by', 'approved_at', 'approval_notes',
                'service_provided', 'satisfaction',
            ]);
        });

        Schema::table('vehicle_requests', function (Blueprint $table) {
            $table->dropColumn([
                'request_number', 'destination', 'distance_km',
                'approved_by', 'approved_at', 'rejection_reason',
            ]);
        });
    }
};
