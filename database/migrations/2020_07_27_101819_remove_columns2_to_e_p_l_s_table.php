<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumns2ToEPLSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('e_p_l_s', function (Blueprint $table) {
            $table->dropForeign('e_p_l_s_environment_officer_id_foreign');
            $table->dropColumn('industry_category_id');
            $table->dropColumn('pradesheeyasaba_id');
            $table->dropColumn('start_date');
            $table->dropColumn('site_clearance_file');

            ////
            $table->dropColumn('application_path');
            $table->dropColumn('environment_officer_id');
            $table->dropColumn('file_01');
            $table->dropColumn('file_02');
            $table->dropColumn('file_03');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('e_p_l_s', function (Blueprint $table) {
            //
        });
    }
}
