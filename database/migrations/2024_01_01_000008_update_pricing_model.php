<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('languages', function (Blueprint $table) {
            $table->string('flag_code', 5)->after('flag_emoji')->default('');
        });

        // Remove per-language price since we're going subscription-wide
        // Keep price_monthly for backward compat but it won't be used
    }

    public function down(): void
    {
        Schema::table('languages', function (Blueprint $table) {
            $table->dropColumn('flag_code');
        });
    }
};
