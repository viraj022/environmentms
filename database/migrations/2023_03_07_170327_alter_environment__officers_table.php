<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterEnvironmentOfficersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('environment_officers', function (Blueprint $table) {
            $table->unsignedBigInteger('assistant_director_id')->nullable()->change();
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
            $table->unsignedBigInteger('assistant_director_id')->change();
        });
    }
}
