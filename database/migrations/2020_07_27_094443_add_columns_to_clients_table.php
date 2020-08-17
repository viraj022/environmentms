<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('industry_name', 255)->unique();
            $table->bigInteger('industry_category_id')->unsigned();
            $table->bigInteger('business_scale_id')->unsigned();
            $table->string('industry_contact_no', 12);
            $table->text('industry_address');
            $table->text('industry_email')->nullable();
            $table->string('industry_coordinate_x', 100)->nullable();
            $table->string('industry_coordinate_y', 100)->nullable();
            $table->bigInteger('pradesheeyasaba_id')->unsigned();
            $table->integer('industry_is_industry')->default(0)->comment('0 => no 1 => yes');
            $table->double('industry_investment', 12, 2);
            $table->dateTime('industry_start_date')->nullable();
            $table->string('industry_registration_no', 50)->unique();
            $table->foreign('industry_category_id')->references('id')->on('industry_categories')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('business_scale_id')->references('id')->on('business_scales')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('pradesheeyasaba_id')->references('id')->on('pradesheeyasabas')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign('clients_business_scale_id_foreign');
            $table->dropForeign('clients_industry_category_id_foreign');
            $table->dropForeign('clients_pradesheeyasaba_id_foreign');
            $table->dropColumn('business_scale_id');
            $table->dropColumn('industry_name');
            $table->dropColumn('industry_category_id');
            $table->dropColumn('industry_scale_id');
            $table->dropColumn('industry_contact_no');
            $table->dropColumn('industry_address');
            $table->dropColumn('industry_email');
            $table->dropColumn('industry_coordinate_x');
            $table->dropColumn('industry_coordinate_y');
            $table->dropColumn('pradesheeyasaba_id');
            $table->dropColumn('industry_is_industry');
            $table->dropColumn('industry_investment');
            $table->dropColumn('industry_registration_no');
        });
    }
}
