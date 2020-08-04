<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnsFromEPLSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('e_p_l_s', function (Blueprint $table) {
            $table->dropForeign('e_p_l_s_business_scale_id_foreign');
            $table->dropForeign('e_p_l_s_industry_category_id_foreign');
            $table->dropForeign('e_p_l_s_pradesheeyasaba_id_foreign');
            $table->dropColumn('business_scale_id');
            $table->dropColumn('name');
            $table->dropColumn('industry_scale_id');
            $table->dropColumn('contact_no');
            $table->dropColumn('address');
            $table->dropColumn('email');
            $table->dropColumn('coordinate_x');
            $table->dropColumn('coordinate_y');
            $table->dropColumn('is_industry');
            $table->dropColumn('investment');
            $table->dropColumn('registration_no');
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
