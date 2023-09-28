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
        Schema::create('components', function (Blueprint $table) {
            $table->uuid('id')->nullable(false)->primary();
            $table->uuid('component_categories_id')->nullable(false);
            $table->foreign('component_categories_id')->references('id')->on('component_categories');
            $table->string('label', 255)->nullable(false)->unique();
            $table->text('media')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('components');
    }
};
