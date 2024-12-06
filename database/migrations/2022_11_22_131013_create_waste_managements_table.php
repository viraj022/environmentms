<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWasteManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waste_managements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('facility_name');
            $table->text('address');
            $table->string('telephone');
            $table->unsignedBigInteger('pradeshiya_sabha');
            $table->string('district');
            $table->string('province');
            $table->string('emergency_name');
            $table->string('emergency_number');
            $table->string('emergency_phone')->nullable();
            $table->string('emergency_fax')->nullable();
            $table->string('emergency_email')->nullable();
            $table->text('emergency_address');
            $table->string('activities')->nullable();
            $table->string('applicant_name');
            $table->text('applicant_address');
            $table->string('applicant_number');
            $table->string('applicant_fax')->nullable();
            $table->string('licence_number')->nullable();
            $table->text('permit_qualifications')->nullable();
            $table->text('insurance')->nullable();
            $table->text('emergency_procedures')->nullable();
            $table->text('accidents_info')->nullable();
            $table->text('workers_health')->nullable();
            $table->string('map')->nullable();
            $table->text('waste_category')->nullable();
            $table->text('waste_handle')->nullable();
            $table->text('detail_operation')->nullable();
            $table->text('disposal_des')->nullable();
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
        Schema::dropIfExists('waste_managements');
    }
}
