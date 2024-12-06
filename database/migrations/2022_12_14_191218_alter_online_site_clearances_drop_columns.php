<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOnlineSiteClearancesDropColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('online_site_clearances', function (Blueprint $table) {
            $table->dropColumn('chimney_height');
            $table->dropColumn('number_of_chimneys');
            $table->dropColumn('within5km');
            $table->dropColumn('waterDischargeMethod');
            $table->dropColumn('discharge_toxics_substances');
            $table->dropColumn('water_treatment_process');
            $table->dropColumn('characteristics_of_water');
            $table->dropColumn('water_recycling');
            $table->dropColumn('disposalMethods');
            $table->dropColumn('machine_type');
            $table->dropColumn('machine_horse_power');
            $table->dropColumn('machine_units');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('online_site_clearances', function (Blueprint $table) {
            $table->float('chimney_height', 10, 2)->nullable();
            $table->string('number_of_chimneys')->nullable();
            $table->string('within5km')->nullable();
            $table->string('waterDischargeMethod')->nullable();
            $table->text('discharge_toxics_substances')->nullable();
            $table->text('water_treatment_process')->nullable();
            $table->text('characteristics_of_water')->nullable();
            $table->text('water_recycling')->nullable();
            $table->string('disposalMethods')->nullable();
            $table->string('machine_type')->nullable();
            $table->string('machine_horse_power')->nullable();
            $table->float('machine_units', 10, 2)->nullable();
        });
    }
}
