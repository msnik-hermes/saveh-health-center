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
        Schema::create('security_incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->dateTime('incident_date');
            $table->enum('incident_type', ['soroogh', 'takhrab', 'dastresi_ghair_mojaz', 'khoshunat_shoghli', 'basteh_mashkoak', 'khatr_eaymani', 'atash', 'poshtibani_orzhans']);
            $table->string('location', 200);
            $table->enum('severity', ['1', '2', '3', '4', '5']);
            $table->text('persons_involved')->nullable();
            $table->text('witnesses')->nullable();
            $table->text('description');
            $table->text('immediate_actions')->nullable();
            $table->json('evidence')->nullable();
            $table->string('police_report_number', 50)->nullable();
            $table->text('investigation_report')->nullable();
            $table->text('corrective_actions')->nullable();
            $table->string('follow_up_status', 100)->nullable();
            $table->foreignId('reported_by')->nullable()->constrained('employees')->nullOnDelete();
            $table->enum('status', ['baz', 'dar_barresi', 'hal_shodeh']);
            $table->date('resolution_date')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('center_id');
            $table->index('incident_date');
            $table->index('status');
            $table->index('incident_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_incidents');
    }
};
