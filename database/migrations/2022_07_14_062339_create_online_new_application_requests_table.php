<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineNewApplicationRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_new_application_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('online_request_id');
            $table->string('title');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('address')->nullable();
            $table->string('mobile_number', 10);
            $table->string('email_address');
            $table->string('nic_number')->nullable();
            $table->unsignedBigInteger('pradesheeyasaba_id');
            $table->unsignedBigInteger('industry_category_id');
            $table->string('business_scale');
            $table->string('industry_sub_category')->nullable();
            $table->string('business_registration_number');
            $table->string('business_name');
            $table->string('is_in_industry_zone')->default(false);
            $table->decimal('investment_amount', 10, 2)->default(0.00);
            $table->string('industry_address');
            $table->date('start_date');
            $table->date('submitted_date')->nullable();
            $table->string('industry_contact_no', 10)->nullable();
            $table->string('industry_email_address')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string('status')->default('acceptance_pending');
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
        Schema::dropIfExists('online_new_application_requests');
    }
};
