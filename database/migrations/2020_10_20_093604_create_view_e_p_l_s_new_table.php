<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewEPLSNewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = "select * from `e_p_l_s` where `count` = 0 and `e_p_l_s`.`deleted_at` is null";
        // dd($sql);
        \DB::statement("
            CREATE VIEW view_e_p_l_s_new 
            AS " . $sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_e_p_l_s_new');
    }
}
