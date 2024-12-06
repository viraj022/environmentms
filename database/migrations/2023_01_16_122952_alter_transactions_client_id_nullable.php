<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTransactionsClientIdNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->bigInteger('client_id')->unsigned()->nullable()->change();
            $table->bigInteger('type_id')->unsigned()->nullable()->change();
        });

        Schema::table('transaction_items', function (Blueprint $table) {
            $table->bigInteger('client_id')->unsigned()->nullable()->change();
            $table->bigInteger('transaction_type_id')->unsigned()->nullable()->change();
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
            $table->bigInteger('client_id')->unsigned()->change();
            $table->bigInteger('type_id')->unsigned()->change();
        });

        Schema::table('transaction_items', function (Blueprint $table) {
            $table->bigInteger('client_id')->unsigned()->change();
            $table->bigInteger('transaction_type_id')->unsigned()->change();
        });
    }
}
