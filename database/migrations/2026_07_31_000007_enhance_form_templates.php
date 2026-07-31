<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('form_templates', function (Blueprint $table) {
            $table->foreignId('unit_id')->nullable()->after('category')->constrained('organizational_units')->nullOnDelete();
            $table->json('target_units')->nullable()->after('target_center_types');
            $table->string('icon', 50)->nullable()->after('target_units');
            $table->string('color', 20)->nullable()->after('icon');
            $table->integer('sort_order')->default(0)->after('color');
            $table->text('instructions')->nullable()->after('sort_order');
            $table->json('required_attachments')->nullable()->after('instructions');
            $table->boolean('requires_approval')->default(false)->after('required_attachments');
            $table->json('approval_steps')->nullable()->after('requires_approval');
        });
    }

    public function down(): void
    {
        Schema::table('form_templates', function (Blueprint $table) {
            $table->dropColumn([
                'unit_id', 'target_units', 'icon', 'color', 'sort_order',
                'instructions', 'required_attachments', 'requires_approval', 'approval_steps',
            ]);
        });
    }
};
