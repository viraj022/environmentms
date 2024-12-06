<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefilingPaddyLandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refiling_paddy_lands', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('address');
            $table->string('nic');
            $table->string('telephone');
            $table->string('email')->nullable();
            $table->unsignedBigInteger('pradeshiya_sabha');
            $table->string('division_secretariat');
            $table->string('gs_division');
            $table->string('agrarian_service_division');
            $table->string('paddy_land_owner_name');
            $table->string('deed_number')->nullable();
            $table->string('survey_plan_number')->nullable();
            $table->string('extent_of_land')->nullable();
            $table->string('utility_of_land')->nullable();
            $table->string('utility_of_bounded_land')->nullable();
            $table->string('proposed_land_utility')->nullable();
            $table->text('reason')->nullable();
            $table->string('route_map')->nullable();
            $table->string('deed_of_land')->nullable();
            $table->string('survey_plan')->nullable();
            $table->string('add_issue_letter')->nullable();
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
        Schema::dropIfExists('refiling_paddy_lands');
    }
}
