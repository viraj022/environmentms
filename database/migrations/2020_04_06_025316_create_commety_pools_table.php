<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommetyPoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commety_pools', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name', 255);
            $table->string('last_name', 255)->nullable();
            $table->string('nic', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('contact_no', 12)->nullable();
            $table->string('email', 255)->nullable();          
            $table->timestamps();
        });
        DB::table('privileges')->insertOrIgnore([
            ['id' => 13, 'name' => 'Committee Pool'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commety_pools');
    }
}
