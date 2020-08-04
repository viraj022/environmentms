<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLevelsToLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('levels', function (Blueprint $table) {
            //
        });

        DB::table('levels')->insertOrIgnore([
            ['id' => 2, 'name' => 'Director', 'value' => 1],
            ['id' => 3, 'name' => 'Assistant Director', 'value' => 2],
            ['id' => 4, 'name' => 'Environment Officer', 'value' => 3],
        ]);
        DB::table('levels')
            ->where('id', 1)
            ->limit(1)
            ->update(array('value' => 4));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('levels', function (Blueprint $table) {
            //
        });
    }
}
