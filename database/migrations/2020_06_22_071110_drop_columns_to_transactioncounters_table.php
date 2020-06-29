<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnsToTransactioncountersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactioncounters', function (Blueprint $table) {
            $table->dropForeign('transactioncounters_payment_id_foreign');
            $table->dropForeign('transactioncounters_payment_type_id_foreign');
            $table->dropColumn('payment_type_id');
            $table->dropColumn('payment_id');
            $table->dropColumn('transaction_type');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactioncounters', function (Blueprint $table) {
            //
        });
    }
}
