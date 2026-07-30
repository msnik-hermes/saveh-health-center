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
        Schema::create('form_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('slug', 100)->unique();
            $table->enum('category', ['darkhast_kala', 'darkhast_tasisat', 'darkhast_it', 'darkhast_khadamat', 'gozaresh', 'bazresi', 'behdashti', 'amoozeshi']);
            $table->text('description')->nullable();
            $table->json('fields_schema');
            $table->json('target_roles')->nullable();
            $table->json('target_center_types')->nullable();
            $table->integer('version')->default(1);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('category');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_templates');
    }
};
