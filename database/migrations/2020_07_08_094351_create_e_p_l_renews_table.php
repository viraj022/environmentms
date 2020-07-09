<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEPLRenewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_p_l_renews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('e_p_l_id')->unsigned();
            $table->integer('count');
            $table->integer('is_old')->default(0)->comment('0 for old 1 for new');
            $table->string('certificate_no', 100);
            $table->dateTime('renew_date')->nullable();
            $table->dateTime('expire_date')->nullable();
            $table->integer('issue_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('e_p_l_renews');
    }
}
