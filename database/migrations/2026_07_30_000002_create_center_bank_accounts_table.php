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
            $table->string('account_type')->default('jari');
            $table->string('purpose', 200)->nullable();
            $table->boolean('is_default')->default(false);
            $table->unsignedBigInteger('balance')->nullable();
            $table->timestamp('last_activity')->nullable();
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
        Schema::dropIfExists('center_bank_accounts');
    }
};
