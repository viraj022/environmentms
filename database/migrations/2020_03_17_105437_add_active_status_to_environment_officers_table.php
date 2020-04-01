<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActiveStatusToEnvironmentOfficersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('environment_officers', function (Blueprint $table) {
          $table->integer('active_status')->unsigned()->default(0)->comment('1 => active environment office 0 => deleted or inactive officer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('environment_officers', function (Blueprint $table) {
            $table->dropColumn('active_status');
        });
    }
}
