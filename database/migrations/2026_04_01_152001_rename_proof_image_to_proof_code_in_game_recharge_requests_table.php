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
            if (Schema::hasColumn('game_recharge_requests', 'proof_image')) {
                $table->renameColumn('proof_image', 'proof_code');
            } elseif (!Schema::hasColumn('game_recharge_requests', 'proof_code')) {
                $table->string('proof_code')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_recharge_requests', function (Blueprint $table) {
            if (Schema::hasColumn('game_recharge_requests', 'proof_code')) {
                $table->renameColumn('proof_code', 'proof_image');
            }
        });
    }
};
