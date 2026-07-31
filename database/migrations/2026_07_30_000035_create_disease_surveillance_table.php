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
        Schema::create('disease_surveillance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->string('case_id', 20);
            $table->string('disease_category')->default('gharentinei');
            $table->string('disease_code', 20);
            $table->string('disease_name', 200);
            $table->date('report_date');
            $table->date('onset_date')->nullable();
            $table->integer('patient_age')->nullable();
            $table->string('patient_gender')->default('mard')->nullable();
            $table->string('patient_occupation', 100)->nullable();
            $table->string('residence_location', 200)->nullable();
            $table->string('infection_location', 200)->nullable();
            $table->text('symptoms')->nullable();
            $table->boolean('lab_confirmed')->default(false);
            $table->text('lab_result')->nullable();
            $table->string('severity')->default('khafif')->nullable();
            $table->text('treatment')->nullable();
            $table->string('outcome')->default('behbood')->nullable();
            $table->integer('contacts_identified')->nullable();
            $table->boolean('contact_tracing_done')->nullable();
            $table->boolean('isolation_applied')->nullable();
            $table->string('report_source', 100)->nullable();
            $table->string('follow_up_status', 100)->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('disease_code');
            $table->index('report_date');
            $table->index('disease_category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disease_surveillance');
    }
};
