<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTransactionsAddOnlinePaymentId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->text('online_payment_id')->nullable()->after('invoice_id');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->text('online_payment_id')->nullable()->after('canceled_by');
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
            $table->dropColumn('online_payment_id');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('online_payment_id');
        });
    }
}
