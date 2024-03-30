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
        Schema::create('templates', function (Blueprint $table) {
            $table->uuid('id')->nullable(false)->primary();
            $table->uuid('user_id')->nullable(false);
            $table->text('data')->nullable(false);
            $table->string('title', 50)->nullable(false);
            $table->string('subtitle', 50)->nullable();
            $table->string('thumbnail', 255)->nullable(false);
            $table->string('type', 50)->nullable(false);
            $table->foreign('user_id')->references('id')->on('users');



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
