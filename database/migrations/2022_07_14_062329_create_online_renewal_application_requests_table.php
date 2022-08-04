<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineRenewalApplicationRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_renewal_application_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('online_request_id');
            $table->string('renewal_type');
            $table->string('certificate_number', 15);
            $table->string('person_name');
            $table->string('industry_name');
            $table->string('business_registration_no');
            $table->string('contact_no', 10);
            $table->string('mobile_no', 10);
            $table->string('email');
            $table->string('nic_number')->nullable();
            $table->string('attachment_file');
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
        Schema::dropIfExists('online_renewal_application_requests');
    }
};
