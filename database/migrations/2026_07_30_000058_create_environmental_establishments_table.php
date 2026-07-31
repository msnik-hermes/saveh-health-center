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
        Schema::create('environmental_establishments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->string('name', 200);
            $table->string('name_english', 200)->nullable();
            $table->string('type')->default('nanvaiee');
            $table->text('address');
            $table->decimal('gps_lat', 10, 8)->nullable();
            $table->decimal('gps_lng', 11, 8)->nullable();
            $table->string('owner_name', 100);
            $table->string('owner_national_code', 10)->nullable();
            $table->string('owner_phone', 15)->nullable();
            $table->string('manager_name', 100)->nullable();
            $table->string('business_license_number', 100)->nullable();
            $table->string('health_permit_number', 100)->nullable();
            $table->date('health_permit_issue_date')->nullable();
            $table->date('health_permit_expiry')->nullable();
            $table->integer('employee_count')->nullable();
            $table->string('business_hours', 100)->nullable();
            $table->string('risk_category')->default('bala');
            $table->string('compliance_status')->default('monaseb');
            $table->date('last_inspection_date')->nullable();
            $table->date('next_inspection_due')->nullable();
            $table->json('violations_history')->nullable();
            $table->string('status')->default('faal');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('owner_national_code');
            $table->index('owner_phone');
            $table->index('status');
            $table->index('compliance_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('environmental_establishments');
    }
};
