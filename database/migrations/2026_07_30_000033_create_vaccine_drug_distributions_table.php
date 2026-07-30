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
        Schema::create('vaccine_drug_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vaccine_drug_id')->constrained('vaccines_drugs')->cascadeOnDelete();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->date('distribution_date');
            $table->integer('quantity_sent');
            $table->integer('quantity_received')->nullable();
            $table->decimal('temperature_at_distribution', 4, 1)->nullable();
            $table->string('distributor_name', 100)->nullable();
            $table->string('recipient_name', 100)->nullable();
            $table->string('transport_method', 100)->nullable();
            $table->boolean('cold_chain_maintained')->nullable();
            $table->json('delivery_receipt')->nullable();
            $table->enum('status', ['ersal_shodeh', 'tahvil_shodeh', 'marjoo_shodeh']);
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('vaccine_drug_id');
            $table->index('center_id');
            $table->index('distribution_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccine_drug_distributions');
    }
};
