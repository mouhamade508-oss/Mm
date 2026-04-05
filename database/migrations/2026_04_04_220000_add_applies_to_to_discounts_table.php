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
        Schema::table('discounts', function (Blueprint $table) {
            if (! Schema::hasColumn('discounts', 'applies_to')) {
                $table->enum('applies_to', ['all', 'products', 'game_recharge'])
                      ->default('all')
                      ->after('type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('discounts', function (Blueprint $table) {
            if (Schema::hasColumn('discounts', 'applies_to')) {
                $table->dropColumn('applies_to');
            }
        });
    }
};
