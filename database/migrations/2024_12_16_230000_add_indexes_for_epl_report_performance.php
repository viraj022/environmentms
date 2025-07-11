<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesForEplReportPerformance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add indexes for EPL table
        Schema::table('e_p_l_s', function (Blueprint $table) {
            $table->index(['issue_date', 'client_id'], 'idx_epl_issue_date_client');
            $table->index(['submitted_date', 'client_id'], 'idx_epl_submitted_date_client');
            $table->index(['status', 'issue_date'], 'idx_epl_status_issue_date');
        });

        // Add indexes for transactions table
        Schema::table('transactions', function (Blueprint $table) {
            $table->index(['client_id', 'type'], 'idx_transactions_client_type');
            $table->index(['billed_at'], 'idx_transactions_billed_at');
        });

        // Add indexes for transaction_items table
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->index(['transaction_id', 'payment_type_id'], 'idx_transaction_items_payment');
            $table->index(['transaction_type', 'payment_type_id'], 'idx_transaction_items_type_payment');
        });

        // Add indexes for clients table
        Schema::table('clients', function (Blueprint $table) {
            $table->index(['industry_category_id'], 'idx_clients_industry_category');
            $table->index(['environment_officer_id'], 'idx_clients_environment_officer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('e_p_l_s', function (Blueprint $table) {
            $table->dropIndex('idx_epl_issue_date_client');
            $table->dropIndex('idx_epl_submitted_date_client');
            $table->dropIndex('idx_epl_status_issue_date');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex('idx_transactions_client_type');
            $table->dropIndex('idx_transactions_billed_at');
        });

        Schema::table('transaction_items', function (Blueprint $table) {
            $table->dropIndex('idx_transaction_items_payment');
            $table->dropIndex('idx_transaction_items_type_payment');
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->dropIndex('idx_clients_industry_category');
            $table->dropIndex('idx_clients_environment_officer');
        });
    }
}
