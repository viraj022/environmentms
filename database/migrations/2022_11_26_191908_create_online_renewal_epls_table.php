<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineRenewalEplsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_renewal_epls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('industry_name');
            $table->text('industry_address');
            $table->string('applicant_name');
            $table->text('applicant_address');
            $table->string('applicant_nic');
            $table->string('applicant_telephone');
            $table->string('applicant_email')->nullable();
            $table->unsignedBigInteger('pradeshiya_sabha');
            $table->string('epl_number');
            $table->date('epl_issued');
            $table->date('epl_expired');
            $table->text('changes_after_last_epl')->nullable();
            $table->text('production_changes')->nullable();
            $table->text('other_department_report')->nullable();
            $table->text('other_details')->nullable();
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
        Schema::dropIfExists('online_renewal_epls');
    }
}