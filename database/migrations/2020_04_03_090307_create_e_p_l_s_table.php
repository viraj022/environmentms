<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEPLSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_p_l_s', function (Blueprint $table) {
            $table->bigIncrements('id');            
            $table->string('name', 255)->unique();
            $table->bigInteger('industry_category_id', 255)->unsigned();
            $table->bigInteger('business_scale_id', 255)->unsigned();
            $table->string('contact_no', 12);
            $table->text('address');
            $table->text('email');
            $table->string('coordinate_x',100);
            $table->string('coordinate_y',100);
            $table->bigInteger('pradesheeyasaba_id', 12)->unsigned();
            $table->integer('is_industry')->default(0)->comment('0 => no 1 => yes');
            $table->double('investment',12,2);
            $table->dateTime('start_date');
            $table->string('registration_no',50);
            $table->text('remark');
            $table->string('application_path');
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('e_p_l_s');
    }
}
