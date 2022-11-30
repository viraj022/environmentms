<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOnlineRequestsChangeType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('online_requests', function (Blueprint $table) {
            $table->string('request_type', 30)->comment('Either renewal or new-application')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('online_requests', function (Blueprint $table) {
            $table->string('request_type', 15)->comment('Either renewal or new-application')->change();
        });
    }
}
