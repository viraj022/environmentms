<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactioncountersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactioncounters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('payment_type_id')->unsigned();    
            $table->bigInteger('payment_id')->unsigned();     
            $table->string('transaction_type',50)->comment('EPL,SITE Clearance');     
            $table->string('cashier_name',255)->nullable();     
            $table->string('request_ip',50)->nullable();     
            $table->bigInteger('transaction_id')->unsigned();     
            $table->integer('payment_status')->default(0)->comment('0 => not payed 1 => payed');
            $table->double('amount');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('payment_type_id')->references('id')->on('payment_types')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactioncounters');
    }
}
