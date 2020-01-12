<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullableToLocalAuthorities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('local_authorities', function (Blueprint $table) {

            $table->unsignedBigInteger('provincial_council_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('local_authorities', function (Blueprint $table) {
            $table->unsignedBigInteger('provincial_council_id')->change();
        });
    }
}
