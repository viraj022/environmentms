<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOnlineRequestsAddRequestId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('online_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('request_id')->after('request_type');
            $table->string('request_model')->after('request_id');
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
            $table->dropColumn('request_id');
            $table->dropColumn('request_model');
        });
    }
}
