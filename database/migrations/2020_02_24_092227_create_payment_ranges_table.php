<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentRangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_ranges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('payments_id')->unsigned();
            $table->decimal('from',12,2);
            $table->decimal('to',12,2);
            $table->decimal('amount',12,2);
            $table->foreign('payments_id')->references('id')->on('payments')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('payment_ranges');
    }
}
