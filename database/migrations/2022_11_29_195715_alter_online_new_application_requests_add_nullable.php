<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOnlineNewApplicationRequestsAddNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('online_new_application_requests', function (Blueprint $table) {
            $table->string('lastname')->nullable()->change();
            $table->string('email_address')->nullable()->change();
            $table->unsignedBigInteger('industry_category_id')->nullable()->change();
            $table->string('business_scale')->nullable()->change();
            $table->string('business_registration_number')->nullable()->change();
            $table->string('business_name')->nullable()->change();
            $table->string('industry_address')->nullable()->change();
            $table->string('start_date')->nullable()->change();
        });

        Schema::table('online_renewal_application_requests', function (Blueprint $table) {
            $table->string('business_registration_no')->nullable()->change();
            $table->string('mobile_no', 10)->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('attachment_file')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('online_new_application_requests', function (Blueprint $table) {
            $table->string('lastname')->change();
            $table->string('email_address')->change();
            $table->unsignedBigInteger('industry_category_id')->change();
            $table->string('business_scale')->change();
            $table->string('business_registration_number')->change();
            $table->string('business_name')->change();
            $table->string('industry_address')->change();
            $table->string('start_date')->change();
        });

        Schema::table('online_renewal_application_requests', function (Blueprint $table) {
            $table->string('business_registration_no')->change();
            $table->string('mobile_no', 10)->change();
            $table->string('email')->change();
            $table->string('attachment_file')->change();
        });
    }
}
