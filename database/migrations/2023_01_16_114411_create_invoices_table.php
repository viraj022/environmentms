<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('contact')->nullable();
            $table->string('nic')->nullable();
            $table->string('invoice_number');
            $table->string('payment_method');
            $table->string('payment_reference_number')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->double('amount', 8, 2);
            $table->double('sub_total', 8, 2);
            $table->double('vat_amount', 8, 2);
            $table->double('nbt_amount', 8, 2);
            $table->date('invoice_date')->nullable();
            $table->string('remark')->nullable();
            $table->tinyInteger('status')->default('1');
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
        Schema::dropIfExists('invoices');
    }
}
