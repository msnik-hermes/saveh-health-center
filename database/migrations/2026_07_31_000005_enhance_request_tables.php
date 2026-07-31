<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // فیلدهای کم‌دار درخواست تاسیسات
        Schema::table('facility_requests', function (Blueprint $table) {
            $table->string('request_number', 30)->unique()->after('id');
            $table->foreignId('unit_id')->nullable()->after('requested_by')->constrained('organizational_units')->nullOnDelete();
            $table->string('exact_location', 300)->nullable()->after('location');
            $table->json('before_images')->nullable()->after('images');
            $table->json('after_images')->nullable()->after('before_images');
            $table->json('materials_used')->nullable()->after('after_images');
            $table->time('work_start_time')->nullable()->after('materials_used');
            $table->time('work_end_time')->nullable()->after('work_start_time');
            $table->foreignId('approved_by')->nullable()->after('assigned_to')->constrained('employees')->nullOnDelete();
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->text('approval_notes')->nullable()->after('approved_at');
            $table->string('service_provided', 200)->nullable()->after('approval_notes');
            $table->string('satisfaction')->nullable()->after('service_provided');
        });

        // فیلدهای کم‌دار درخواست نقلیه
        Schema::table('vehicle_requests', function (Blueprint $table) {
            $table->string('request_number', 30)->unique()->after('id');
            $table->foreignId('unit_id')->nullable()->after('requested_by')->constrained('organizational_units')->nullOnDelete();
            $table->string('origin_address', 500)->nullable()->after('origin');
            $table->string('destination_address', 500)->nullable()->after('destination');
            $table->string('destination_type', 50)->default('markaz_zirmajmooe')->after('destination_address');
            $table->string('trip_type', 50)->default('roozane')->after('destination_type');
            $table->string('passenger_gender', 20)->nullable()->after('passenger_count');
            $table->time('planned_departure')->nullable()->after('passenger_gender');
            $table->time('planned_return')->nullable()->after('planned_departure');
            $table->foreignId('approved_by_deputy')->nullable()->after('driver_id')->constrained('employees')->nullOnDelete();
            $table->timestamp('deputy_approved_at')->nullable()->after('approved_by_deputy');
            $table->foreignId('approved_by_center')->nullable()->after('deputy_approved_at')->constrained('employees')->nullOnDelete();
            $table->timestamp('center_approved_at')->nullable()->after('approved_by_center');
            $table->foreignId('approved_by_transport')->nullable()->after('center_approved_at')->constrained('employees')->nullOnDelete();
            $table->timestamp('transport_approved_at')->nullable()->after('approved_by_transport');
            $table->unsignedBigInteger('start_km')->nullable()->after('transport_approved_at');
            $table->unsignedBigInteger('end_km')->nullable()->after('start_km');
            $table->decimal('fuel_consumed', 8, 2)->nullable()->after('end_km');
            $table->timestamp('actual_departure')->nullable()->after('fuel_consumed');
            $table->timestamp('actual_return')->nullable()->after('actual_departure');
            $table->unsignedBigInteger('travel_cost')->nullable()->after('actual_return');
        });

        // فیلدهای کم‌دار درخواست آی‌تی
        Schema::table('it_requests', function (Blueprint $table) {
            $table->string('request_number', 30)->unique()->after('id');
            $table->foreignId('unit_id')->nullable()->after('requested_by')->constrained('organizational_units')->nullOnDelete();
            $table->string('exact_location', 300)->nullable()->after('problem_description');
            $table->json('before_images')->nullable()->after('screenshots');
            $table->json('after_images')->nullable()->after('before_images');
            $table->json('parts_used')->nullable()->after('after_images');
            $table->time('work_start_time')->nullable()->after('parts_used');
            $table->time('work_end_time')->nullable()->after('work_start_time');
            $table->foreignId('approved_by')->nullable()->after('assigned_to')->constrained('employees')->nullOnDelete();
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->text('approval_notes')->nullable()->after('approved_at');
            $table->string('service_provided', 200)->nullable()->after('approval_notes');
            $table->string('satisfaction')->nullable()->after('service_provided');
        });
    }

    public function down(): void
    {
        Schema::table('facility_requests', function (Blueprint $table) {
            $table->dropColumn([
                'request_number', 'unit_id', 'exact_location', 'before_images',
                'after_images', 'materials_used', 'work_start_time', 'work_end_time',
                'approved_by', 'approved_at', 'approval_notes', 'service_provided', 'satisfaction',
            ]);
        });

        Schema::table('vehicle_requests', function (Blueprint $table) {
            $table->dropColumn([
                'request_number', 'unit_id', 'origin_address', 'destination_address',
                'destination_type', 'trip_type', 'passenger_gender',
                'planned_departure', 'planned_return',
                'approved_by_deputy', 'deputy_approved_at',
                'approved_by_center', 'center_approved_at',
                'approved_by_transport', 'transport_approved_at',
                'start_km', 'end_km', 'fuel_consumed',
                'actual_departure', 'actual_return', 'travel_cost',
            ]);
        });

        Schema::table('it_requests', function (Blueprint $table) {
            $table->dropColumn([
                'request_number', 'unit_id', 'exact_location', 'before_images',
                'after_images', 'parts_used', 'work_start_time', 'work_end_time',
                'approved_by', 'approved_at', 'approval_notes', 'service_provided', 'satisfaction',
            ]);
        });
    }
};
