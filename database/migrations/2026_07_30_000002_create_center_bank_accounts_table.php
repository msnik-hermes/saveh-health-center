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
        Schema::create('center_bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete();
            $table->string('bank_name', 100);
            $table->string('branch_name', 100)->nullable();
            $table->string('account_number', 50);
            $table->string('card_number', 20)->nullable();
            $table->string('shaba', 26);
            $table->enum('account_type', ['jari', 'pas_andaz', 'saborde']);
            $table->string('purpose', 200)->nullable();
            $table->boolean('is_default')->default(false);
            $table->decimal('balance', 18, 2)->nullable();
            $table->timestamp('last_activity')->nullable();
            $table->enum('status', ['faal', 'masdood', 'basteh'])->default('faal');
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
        Schema::dropIfExists('center_bank_accounts');
    }
};
