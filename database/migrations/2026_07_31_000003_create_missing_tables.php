<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('official_correspondence', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number', 50)->unique();
            $table->string('type', 20); // dakhel, kharej
            $table->foreignId('sender_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->foreignId('receiver_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->string('subject', 255);
            $table->text('body')->nullable();
            $table->json('attachments')->nullable();
            $table->string('priority')->default('adadi');
            $table->string('status')->default('erza_shodeh');
            $table->date('send_date')->nullable();
            $table->date('receive_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('tracking_number');
            $table->index('center_id');
            $table->index('sender_id');
            $table->index('receiver_id');
            $table->index('type');
            $table->index('status');
        });

        Schema::create('staff_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->foreignId('from_center_id')->nullable()->constrained('centers')->nullOnDelete();
            $table->foreignId('to_center_id')->nullable()->constrained('centers')->nullOnDelete();
            $table->foreignId('from_unit_id')->nullable()->constrained('organizational_units')->nullOnDelete();
            $table->foreignId('to_unit_id')->nullable()->constrained('organizational_units')->nullOnDelete();
            $table->date('transfer_date');
            $table->text('reason')->nullable();
            $table->foreignId('requested_by')->nullable()->constrained('employees')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('employees')->nullOnDelete();
            $table->string('status')->default('dar_entzaar');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('employee_id');
            $table->index('from_center_id');
            $table->index('to_center_id');
            $table->index('status');
        });

        Schema::create('medical_equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->string('name', 200);
            $table->string('category', 100); // tajhizat_pezeshki, tajhizat_edari, tajhizat_fanni
            $table->string('brand', 100)->nullable();
            $table->string('model', 100)->nullable();
            $table->string('serial_number', 100)->nullable();
            $table->string('asset_code', 50)->nullable();
            $table->date('purchase_date')->nullable();
            $table->unsignedBigInteger('purchase_price')->nullable();
            $table->date('warranty_end')->nullable();
            $table->string('location', 200)->nullable();
            $table->unsignedBigInteger('room_id')->nullable();
            $table->foreignId('custodian_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->string('status')->default('faal');
            $table->date('last_maintenance')->nullable();
            $table->date('next_maintenance')->nullable();
            $table->integer('maintenance_interval_months')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('category');
            $table->index('status');
        });

        Schema::create('sim_cards', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number', 20);
            $table->string('operator', 50); // hamrah_aval, irancell, rightel, mobinnet
            $table->string('card_type', 20); // eghterazi, daeemi, data
            $table->string('iccid', 30)->nullable();
            $table->string('current_plan', 100)->nullable();
            $table->unsignedBigInteger('monthly_cost')->nullable();
            $table->date('activation_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->foreignId('center_id')->nullable()->constrained('centers')->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('employees')->nullOnDelete();
            $table->string('status')->default('faal');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('phone_number');
            $table->index('center_id');
            $table->index('assigned_to');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sim_cards');
        Schema::dropIfExists('medical_equipment');
        Schema::dropIfExists('staff_transfers');
        Schema::dropIfExists('official_correspondence');
    }
};
