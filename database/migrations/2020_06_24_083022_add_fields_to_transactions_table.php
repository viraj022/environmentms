<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->text('cashier_name')->nullable();
            $table->String('invoice_no', 50)->nullable();
            $table->dateTime('canceled_at')->nullable();
            $table->dateTime('billed_at')->nullable();
            $table->integer('status')->default(0)->comment('0 = > not payed 1=> payed 2=>processed 3 => canceled')->change();
            $table->dropColumn('qty');
            $table->dropColumn('type');
            $table->dropColumn('amount');
            $table->dropForeign('transactions_payment_id_foreign');
            $table->dropForeign('transactions_payment_type_id_foreign');
            $table->dropColumn('payment_type_id');
            $table->dropColumn('payment_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('cashier_name');
            $table->dropColumn('invoice_no');
            $table->dropColumn('canceled_at');
            $table->dropColumn('billed_at');
            $table->double('amount');
            $table->double('qty');
            $table->text('type');
            $table->integer('payment_type_id');
            $table->integer('payment_id');
        });
    }
}
