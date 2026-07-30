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
        Schema::create('company_inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable();
            $table->string('company_name', 200);
            $table->foreignId('inspector_id')->constrained('employees')->cascadeOnDelete();
            $table->enum('inspection_type', ['adii', 'peygiri', 'shekaayat', 'barresi']);
            $table->date('inspection_date');
            $table->integer('workers_inspected')->nullable();
            $table->text('findings');
            $table->integer('violations_found')->nullable();
            $table->decimal('compliance_score', 5, 2)->nullable();
            $table->json('violations')->nullable();
            $table->text('corrective_actions')->nullable();
            $table->date('next_inspection_date')->nullable();
            $table->enum('status', ['takmil_shodeh', 'dar_barresi', 'peygiri']);
            $table->json('photos')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('inspector_id');
            $table->index('inspection_date');
            $table->index('company_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_inspections');
    }
};
