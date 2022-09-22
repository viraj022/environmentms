<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOnlineNewApplicationsRejected extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('online_new_application_requests', function (Blueprint $table) {
            $table->timestamp('rejected_at')->nullable()->after('status');
            $table->text('rejected_minute')->nullable()->after('rejected_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('online_new_application_requests', function (Blueprint $table) {
            $table->dropColumn('rejected_at');
            $table->dropColumn('rejected_minute');
        });
    }
}
