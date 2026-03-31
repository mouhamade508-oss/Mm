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
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('requires_whatsapp')->default(false)->after('is_digital');
            $table->string('order_method')->default('direct')->after('requires_whatsapp'); // 'direct' or 'whatsapp'
            $table->string('whatsapp_phone')->nullable()->after('order_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['requires_whatsapp', 'order_method', 'whatsapp_phone']);
        });
    }
};
