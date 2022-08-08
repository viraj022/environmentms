<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlinePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('online_request_id');
            $table->string('reference_no');
            $table->decimal('amount', 10, 2);
            $table->string('ipg_success_indicator')->nullable();
            $table->string('ipg_result_indicator')->nullable();
            $table->string('ipg_payment_status')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->string('status')->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('online_payments');
    }
}
