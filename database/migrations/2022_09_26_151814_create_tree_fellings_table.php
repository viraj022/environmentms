<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreeFellingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tree_fellings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('address');
            $table->string('nic');
            $table->string('telephone', 10);
            $table->string('email');
            $table->string('number_of_trees');
            $table->string('land_ownership_type');
            $table->string('extent_of_land');
            $table->string('deed_number');
            $table->string('survey_plan_number');
            $table->string('address_of_land');
            $table->string('trees_already_felt');
            $table->unsignedBigInteger('pradeshiya_sabha');
            $table->string('division_secretariat');
            $table->string('current_land_use');
            $table->string('land_pattern_within_100m');
            $table->text('tree_felling_reason');
            $table->string('rehabilitation_plan')->nullable();
            $table->string('deed_of_land')->nullable();
            $table->string('survey_plan')->nullable();
            $table->string('landowners_affidavit')->nullable();
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
        Schema::dropIfExists('tree_fellings');
    }
}
