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
            $table->dropForeign('user_websites_template_repository_id_foreign');
            $table->dropColumn('template_repository_id');

            $table->uuid('user_template_id')->nullable(false)->after('user_id');
            $table->foreign('user_template_id')->references('id')->on('user_templates');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('template_id_at_user_websites', function (Blueprint $table) {
            //
        });
    }
};
