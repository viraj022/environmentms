<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueIndexToInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        return;
        Schema::table('invoices', function (Blueprint $table) {
            $table->unique(['invoice_number'], 'invoice_no_unique_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        return;
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropUnique('invoice_no_unique_index');
        });
    }
}
