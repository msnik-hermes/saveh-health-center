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
        Schema::create('center_network_connections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->string('connection_type', 50);
            $table->string('provider', 100)->nullable();
            $table->decimal('speed_download', 8, 2)->nullable();
            $table->decimal('speed_upload', 8, 2)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('contract_number', 100)->nullable();
            $table->string('status')->default('faal');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('center_network_connections');
    }
};
