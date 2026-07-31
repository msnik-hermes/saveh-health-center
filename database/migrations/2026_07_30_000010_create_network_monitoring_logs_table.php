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
        Schema::create('network_monitoring_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('connection_id')->constrained('center_network_connections')->cascadeOnDelete();
            $table->dateTime('check_time');
            $table->decimal('download_speed', 8, 2)->nullable();
            $table->decimal('upload_speed', 8, 2)->nullable();
            $table->decimal('latency', 8, 2)->nullable();
            $table->decimal('packet_loss', 5, 2)->nullable();
            $table->decimal('uptime_pct', 5, 2)->nullable();
            $table->string('status')->default('faal');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('connection_id');
            $table->index('check_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('network_monitoring_logs');
    }
};
