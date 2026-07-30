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
        Schema::create('employee_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->enum('contract_type', ['rasmi', 'peymani', 'tab_3', 'tab_4', 'peymankari', 'sherkati', 'tahghighi', 'sarbazee', 'madde_32']);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('renewal_count')->default(0);
            $table->string('salary_grade', 50)->nullable();
            $table->json('benefits')->nullable();
            $table->enum('insurance_provider', ['sandogh_bazneshasteei', 'tamin_ejtemaei', 'niruha_mosalah', 'sherkati']);
            $table->date('insurance_start')->nullable();
            $table->string('pension_source', 100)->nullable();
            $table->boolean('convertible_to_permanent')->default(false);
            $table->string('service_region', 200)->nullable();
            $table->json('restrictions')->nullable();
            $table->string('legal_basis', 200)->nullable();
            $table->json('attachments')->nullable();
            $table->enum('status', ['faal', 'payan_yafteh', 'faskh_shodeh'])->default('faal');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('employee_id');
            $table->index('contract_type');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_contracts');
    }
};
