<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraDataColumnToSiteClearenceSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_clearence_sessions', function (Blueprint $table) {
            $table->json('content_paths');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_clearence_sessions', function (Blueprint $table) {
            $table->dropColumn('content_paths');
        });
    }
}
