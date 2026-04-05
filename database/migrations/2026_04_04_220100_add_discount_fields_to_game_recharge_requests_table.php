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
            if (! Schema::hasColumn('game_recharge_requests', 'discount_code')) {
                $table->string('discount_code')->nullable()->after('referral_code');
            }
            if (! Schema::hasColumn('game_recharge_requests', 'discount_id')) {
                $table->foreignId('discount_id')->nullable()->constrained('discounts')->nullOnDelete()->after('discount_code');
            }
            if (! Schema::hasColumn('game_recharge_requests', 'discount_percentage')) {
                $table->decimal('discount_percentage', 5, 2)->nullable()->after('discount_id');
            }
            if (! Schema::hasColumn('game_recharge_requests', 'discount_amount')) {
                $table->decimal('discount_amount', 10, 2)->nullable()->after('discount_percentage');
            }
            if (! Schema::hasColumn('game_recharge_requests', 'original_price')) {
                $table->decimal('original_price', 10, 2)->nullable()->after('discount_amount');
            }
            if (! Schema::hasColumn('game_recharge_requests', 'final_price')) {
                $table->decimal('final_price', 10, 2)->nullable()->after('original_price');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_recharge_requests', function (Blueprint $table) {
            if (Schema::hasColumn('game_recharge_requests', 'final_price')) {
                $table->dropColumn('final_price');
            }
            if (Schema::hasColumn('game_recharge_requests', 'original_price')) {
                $table->dropColumn('original_price');
            }
            if (Schema::hasColumn('game_recharge_requests', 'discount_amount')) {
                $table->dropColumn('discount_amount');
            }
            if (Schema::hasColumn('game_recharge_requests', 'discount_percentage')) {
                $table->dropColumn('discount_percentage');
            }
            if (Schema::hasColumn('game_recharge_requests', 'discount_id')) {
                $table->dropForeign(['discount_id']);
                $table->dropColumn('discount_id');
            }
            if (Schema::hasColumn('game_recharge_requests', 'discount_code')) {
                $table->dropColumn('discount_code');
            }
        });
    }
};
