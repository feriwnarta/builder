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
        Schema::table('user_websites', function (Blueprint $table) {
            $table->longText('css')->nullable(false)->after('html');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_websites', function (Blueprint $table) {
            $table->dropColumn('css');
        });
    }
};
