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
        Schema::table('game_recharge_requests', function (Blueprint $table) {
            $table->foreignId('game_category_id')->nullable()->constrained('game_categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_recharge_requests', function (Blueprint $table) {
            $table->dropForeign(['game_category_id']);
            $table->dropColumn('game_category_id');
        });
    }
};
