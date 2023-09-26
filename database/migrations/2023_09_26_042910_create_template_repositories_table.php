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
        Schema::create('template_repositories', function (Blueprint $table) {
            $table->uuid('id')->nullable(false)->primary();
            $table->uuid('categories_id')->nullable(false);
            $table->uuid('template_id')->nullable(false)->unique();
            $table->string('type', 250)->nullable(false);
            $table->timestamps();

            $table->foreign('template_id')->references('id')->on('templates');
            $table->foreign('categories_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_repositories');
    }
};
