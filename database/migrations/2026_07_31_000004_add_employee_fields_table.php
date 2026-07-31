<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // فیلدهای بهورزی
            $table->string('behvarz_code', 20)->nullable()->after('status');
            $table->string('village_name', 100)->nullable()->after('behvarz_code');
            $table->string('health_post_name', 100)->nullable()->after('village_name');
            $table->integer('health_post_population')->nullable()->after('health_post_name');
            $table->unsignedBigInteger('parent_center_id')->nullable()->after('health_post_population');
            $table->string('training_center', 200)->nullable()->after('parent_center_id');
            $table->date('training_start_date')->nullable()->after('training_center');
            $table->date('training_end_date')->nullable()->after('training_start_date');
            $table->date('graduation_date')->nullable()->after('training_end_date');
            $table->date('rural_service_start')->nullable()->after('graduation_date');

            // فیلدهای رانندگان
            $table->string('driver_license_number', 30)->nullable()->after('rural_service_start');
            $table->string('driver_license_type', 20)->nullable()->after('driver_license_number');
            $table->date('driver_license_expiry')->nullable()->after('driver_license_type');
            $table->unsignedBigInteger('assigned_vehicle_id')->nullable()->after('driver_license_expiry');
            $table->json('driving_record')->nullable()->after('assigned_vehicle_id');

            // فیلدهای تکنسین تاسیسات
            $table->json('facilities_certifications')->nullable()->after('driving_record');
            $table->string('facilities_specialization', 100)->nullable()->after('facilities_certifications');
            $table->json('facilities_equipment')->nullable()->after('facilities_specialization');

            // فیلدهای تکنسین آی‌تی
            $table->json('it_certifications')->nullable()->after('facilities_equipment');
            $table->string('it_specialization', 100)->nullable()->after('it_certifications');
            $table->json('it_equipment')->nullable()->after('it_specialization');

            // فیلدهای بازنشستگی
            $table->date('expected_retirement_date')->nullable()->after('it_equipment');
            $table->string('retirement_type', 50)->nullable()->after('expected_retirement_date');
            $table->boolean('early_retirement_eligible')->default(false)->after('retirement_type');
            $table->integer('retirement_warning_level')->default(0)->after('early_retirement_eligible');

            // فیلدهای قرارداد
            $table->string('contract_company', 200)->nullable()->after('retirement_warning_level');
            $table->unsignedBigInteger('unit_id')->nullable()->after('contract_company');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'behvarz_code', 'village_name', 'health_post_name',
                'health_post_population', 'parent_center_id', 'training_center',
                'training_start_date', 'training_end_date', 'graduation_date',
                'rural_service_start',
                'driver_license_number', 'driver_license_type', 'driver_license_expiry',
                'assigned_vehicle_id', 'driving_record',
                'facilities_certifications', 'facilities_specialization', 'facilities_equipment',
                'it_certifications', 'it_specialization', 'it_equipment',
                'expected_retirement_date', 'retirement_type', 'early_retirement_eligible',
                'retirement_warning_level',
                'contract_company', 'unit_id',
            ]);
        });
    }
};
