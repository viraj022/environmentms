<?php

use App\Privilege;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessScalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_scales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',50);
            $table->string('code',50);
            $table->timestamps();
        });

        $privilege = new Privilege();
        $privilege->id=11;
        $privilege->name='Industry Scale';
        $privilege->save();
        DB::table('business_scales')->insertOrIgnore([
            [ 'name' => 'Small –S (Industries of Category C)','code'=>'S'],
            [ 'name' => 'Medium- M(Industries of Category B)','code'=>'M'],
            [ 'name' => 'Large- L(Industries of Category A)','code'=>'L'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_scales');
    }
}
