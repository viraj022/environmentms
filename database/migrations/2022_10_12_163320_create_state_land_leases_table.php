<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStateLandLeasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('state_land_leases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('address');
            $table->string('nic');
            $table->string('telephone');
            $table->string('email')->nullable();
            $table->string('extent_of_land')->nullable();
            $table->string('survey_plan_number')->nullable();
            $table->unsignedBigInteger('pradeshiya_sabha');
            $table->string('utility_of_land')->nullable();
            $table->string('purpose')->nullable();
            $table->string('sensitive_area_100m')->nullable();
            $table->string('route_map')->nullable();
            $table->string('survey_plan')->nullable();
            $table->string('lessor_letter')->nullable();
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
        Schema::dropIfExists('state_land_leases');
    }
}
