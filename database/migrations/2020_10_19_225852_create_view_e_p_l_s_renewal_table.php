<?php

use App\EPL;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewEPLSRenewalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $sql = "select * from `e_p_l_s` where `count` > 0 and `e_p_l_s`.`deleted_at` is null";
        // dd($sql);
        \DB::statement("
            CREATE VIEW e_p_l_s_renewals_view 
            AS " . $sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('e_p_l_s_renewals_view');
    }
}
