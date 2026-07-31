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
        Schema::create('centers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name', 200);
            $table->string('type')->default('khane_behdasht');
            $table->foreignId('parent_id')->nullable()->constrained('centers')->nullOnDelete();
            $table->integer('level')->default(1);
            $table->string('university', 200);
            $table->string('province', 100);
            $table->string('city', 100);
            $table->string('district', 100)->nullable();
            $table->text('address');
            $table->string('postal_code', 10)->nullable();
            $table->decimal('gps_lat', 10, 8)->nullable();
            $table->decimal('gps_lng', 11, 8)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('fax', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('website', 200)->nullable();
            $table->integer('population_served')->nullable();
            $table->string('service_area_type')->default('shahri')->nullable();
            $table->decimal('area_sqm', 10, 2)->nullable();
            $table->integer('floors')->nullable();
            $table->integer('rooms_count')->nullable();
            $table->integer('parking_spaces')->nullable();
            $table->boolean('has_elevator')->default(false);
            $table->boolean('has_generator')->default(false);
            $table->decimal('generator_power_kw', 8, 2)->nullable();
            $table->boolean('has_fire_system')->default(false);
            $table->boolean('has_cctv')->default(false);
            $table->string('building_type')->default('melki')->nullable();
            $table->string('status')->default('faal');
            $table->date('established_date')->nullable();
            $table->string('license_number', 100)->nullable();
            $table->date('license_expiry')->nullable();
            $table->string('accreditation_level', 50)->nullable();
            $table->time('working_hours_start')->nullable();
            $table->time('working_hours_end')->nullable();
            $table->string('working_days', 100)->nullable();
            $table->string('emergency_hours', 100)->nullable();
            $table->string('logo', 255)->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('type');
            $table->index('status');
            $table->index('phone');
            $table->index('email');
            $table->index('parent_id');
            $table->index('province');
            $table->index('city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('centers');
    }
};
