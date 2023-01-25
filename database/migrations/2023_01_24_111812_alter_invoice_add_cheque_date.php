<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterInvoiceAddChequeDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->date('cheque_issue_date')->nullable()->after('payment_reference_number');
            $table->date('canceled_at')->nullable()->after('status');
            $table->unsignedBigInteger('canceled_by')->nullable()->after('canceled_at');
            $table->softDeletes();
        });

        Schema::table('tax_rates', function (Blueprint $table) {
            $table->unsignedBigInteger('changed_user')->nullable()->after('rate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('cheque_issue_date');
            $table->dropColumn('canceled_at');
            $table->dropColumn('canceled_by');
            $table->dropSoftDeletes();
        });

        Schema::table('tax_rates', function (Blueprint $table) {
            $table->dropColumn('changed_user');
        });
    }
}
