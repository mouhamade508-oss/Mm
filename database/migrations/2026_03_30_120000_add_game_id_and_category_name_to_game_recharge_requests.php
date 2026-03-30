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
            $table->foreignId('game_id')->nullable()->constrained('games')->onDelete('set null')->after('id');
            $table->string('category_name')->nullable()->after('game_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_recharge_requests', function (Blueprint $table) {
            $table->dropForeign(['game_id']);
            $table->dropColumn('game_id');
            $table->dropColumn('category_name');
        });
    }
};
