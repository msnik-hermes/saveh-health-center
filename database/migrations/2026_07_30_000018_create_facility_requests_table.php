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
        Schema::create('facility_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->foreignId('requested_by')->constrained('employees')->cascadeOnDelete();
            $table->enum('facility_type', ['loole_keshi', 'barq', 'gaz', 'sarmayesh', 'germayesh', 'negahi', 'banei', 'nezafat']);
            $table->string('location', 200);
            $table->text('description');
            $table->enum('priority', ['adii', 'fori', 'bahrani']);
            $table->dateTime('preferred_time')->nullable();
            $table->boolean('budget_approval')->nullable();
            $table->json('images')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('employees')->nullOnDelete();
            $table->enum('status', ['ersal_shodeh', 'takhseez_yafteh', 'dar_anjam', 'anjam_shodeh', 'red_shodeh']);
            $table->date('completion_date')->nullable();
            $table->decimal('cost', 12, 2)->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('status');
            $table->index('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facility_requests');
    }
};
