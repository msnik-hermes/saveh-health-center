<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Note: SQLite does not support ALTER TABLE to add foreign key constraints.
     * FK constraints are enforced at the application layer for SQLite.
     * On MySQL/PostgreSQL, this migration would add proper FK constraints.
     */
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver !== 'sqlite') {
            Schema::table('users', function (Blueprint $table) {
                $table->foreign('employee_id')->references('id')->on('employees')->nullOnDelete();
                $table->foreign('center_id')->references('id')->on('centers')->nullOnDelete();
            });

            $tables = [
                'centers', 'center_bank_accounts', 'center_phone_lines', 'center_utilities',
                'center_rooms', 'center_equipment', 'center_classifications',
                'center_network_connections', 'center_relations',
                'employees', 'employee_contracts', 'attendance_records', 'leave_records',
                'performance_evaluations', 'form_templates', 'form_submissions',
                'facility_requests', 'work_orders', 'it_requests', 'vehicle_requests',
                'vehicles', 'drivers', 'vehicle_trips', 'vehicle_maintenance', 'fuel_records',
                'budgets', 'financial_transactions', 'supply_inventory', 'inspections',
                'company_inspections', 'vaccines_drugs', 'vaccine_drug_distributions',
                'immunization_records', 'disease_surveillance', 'chronic_disease_tracking',
                'thyroid_screening', 'dental_services', 'suicide_statistics',
                'mental_health_clinic', 'referrals', 'pest_control',
                'pregnant_women', 'maternal_health', 'infants_children',
                'school_health', 'elderly_care', 'youth_health', 'demographics',
                'family_planning', 'training_materials', 'training_distributions',
                'training_service_records', 'occupational_examinations', 'hazard_assessments',
                'early_retirement_cases', 'security_incidents',
                'environmental_establishments', 'environmental_inspections', 'health_permits',
            ];

            foreach ($tables as $table) {
                Schema::table($table, function (Blueprint $table) {
                    $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
                    $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver !== 'sqlite') {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['employee_id']);
                $table->dropForeign(['center_id']);
            });
        }
    }
};
