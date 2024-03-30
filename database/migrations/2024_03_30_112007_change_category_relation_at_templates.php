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
            $table->uuid('category_template_id')->nullable(false)->after('id');
            $table->foreign('category_template_id')->references('id')->on('category_templates');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
