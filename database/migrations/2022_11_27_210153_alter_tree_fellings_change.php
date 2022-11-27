<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTreeFellingsChange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tree_fellings', function (Blueprint $table) {
            $table->text('current_land_use')->nullable()->change();
            $table->text('tree_felling_reason')->nullable()->change();
            $table->text('land_pattern_within_100m')->nullable()->change();
            $table->text('rehabilitation_plan')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('extent_of_land')->nullable()->change();
            $table->string('deed_number')->nullable()->change();
            $table->string('survey_plan_number')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tree_fellings', function (Blueprint $table) {
            $table->string('current_land_use')->nullable(false)->change();
            $table->text('tree_felling_reason')->nullable(false)->change();
            $table->text('land_pattern_within_100m')->nullable(false)->change();
            $table->string('rehabilitation_plan')->nullable()->change();
            $table->string('email')->nullable(false)->change();
            $table->string('extent_of_land')->nullable(false)->change();
            $table->string('deed_number')->nullable(false)->change();
            $table->string('survey_plan_number')->nullable(false)->change();
        });
    }
}
