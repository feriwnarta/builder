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
        Schema::table('templates', function (Blueprint $table) {
            $table->string('data')->nullable()->change();
            $table->string('title')->nullable()->change();
            $table->string('subtitle')->nullable()->change();
            $table->string('thumbnail')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->string('data')->nullable(false)->change();
            $table->string('title')->nullable(false)->change();
            $table->string('subtitle')->nullable(false)->change();
            $table->string('thumbnail')->nullable(false)->change();
        });
    }
};
