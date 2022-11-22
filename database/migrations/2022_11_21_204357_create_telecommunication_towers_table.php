<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelecommunicationTowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telecommunication_towers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('address');
            $table->string('contact_name');
            $table->text('contact_address');
            $table->string('contact_number');
            $table->string('extent_of_land')->nullable();
            $table->string('land_owner_name')->nullable();
            $table->text('land_owner_address')->nullable();
            $table->string('land_owner_phone')->nullable();
            $table->unsignedBigInteger('pradeshiya_sabha');
            $table->string('sketch_of_road')->nullable();
            $table->decimal('investment_amount', 10, 2)->default(0.00);
            $table->string('tower_height')->nullable();
            $table->string('tower_length')->nullable();
            $table->string('tower_width')->nullable();
            $table->text('power_requirements')->nullable();
            $table->text('des_minimize_lightening')->nullable();
            $table->text('lightening_monitoring')->nullable();
            $table->string('public_places_distance')->nullable();
            $table->text('catastrophic_event')->nullable();
            $table->text('towers_within_500m')->nullable();
            $table->string('nearest_residence_distance')->nullable();
            $table->string('houses_within_50m')->nullable();
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
        Schema::dropIfExists('telecommunication_towers');
    }
}
