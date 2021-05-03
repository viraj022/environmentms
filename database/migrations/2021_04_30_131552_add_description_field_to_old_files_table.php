<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionFieldToOldFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('old_files', function (Blueprint $table) {
            $table->text('description')->nullable();
            $table->text('file_catagory');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('old_files', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('file_catagory');
        });
    }
}
