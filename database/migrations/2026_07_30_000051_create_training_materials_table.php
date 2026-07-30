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
        Schema::create('training_materials', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->enum('type', ['poster', 'brochure', 'takbarg', 'kotchakeh', 'video', 'infographic', 'shabake_ejtemaei', 'radio']);
            $table->string('category', 100);
            $table->string('target_audience', 200)->nullable();
            $table->string('language', 50)->nullable();
            $table->date('production_date');
            $table->string('designer', 100)->nullable();
            $table->string('reviewer', 100)->nullable();
            $table->enum('approval_status', ['pishnevis', 'tayeed_shodeh', 'red_shodeh']);
            $table->integer('print_quantity')->nullable();
            $table->string('digital_format', 50)->nullable();
            $table->string('file_location', 255)->nullable();
            $table->integer('version')->default(1);
            $table->decimal('cost', 12, 2)->nullable();
            $table->integer('current_stock')->nullable();
            $table->integer('minimum_stock')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('category');
            $table->index('approval_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_materials');
    }
};
