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
        Schema::create('form_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_template_id')->constrained('form_templates')->cascadeOnDelete();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->foreignId('submitted_by')->constrained('employees')->cascadeOnDelete();
            $table->json('form_data');
            $table->string('status')->default('ersal_shodeh');
            $table->string('priority')->default('adii');
            $table->foreignId('assigned_to')->nullable()->constrained('employees')->nullOnDelete();
            $table->string('assigned_department', 100)->nullable();
            $table->date('due_date')->nullable();
            $table->date('completion_date')->nullable();
            $table->text('completion_notes')->nullable();
            $table->json('attachments')->nullable();
            $table->json('timeline')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('status');
            $table->index('priority');
            $table->index(['center_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_submissions');
    }
};
