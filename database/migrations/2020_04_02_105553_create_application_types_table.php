<?php

use App\ApplicationType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name",50);
            $table->timestamps();
        });
       $epl = new ApplicationType();

       $epl->name = "Environment Protection Licence";
       $epl->save();

       $site = new ApplicationType();
       $site->name = "Site Clearance Licence";
       $site->save();

        $sch = new ApplicationType();
       $sch->name = "Schedule Waste Licence";
       $sch->save();

       $tel = new ApplicationType();
       $tel->name = "Telecommunication Clearance Licence";
       $tel->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application_types');
    }
}
