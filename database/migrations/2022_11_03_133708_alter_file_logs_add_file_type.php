<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterFileLogsAddFileType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('file_logs', function (Blueprint $table) {
            $table->string('file_type')->after('status');
            $table->string('file_type_reference')->nullable()->after('file_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('file_logs', function (Blueprint $table) {
            $table->dropColumn('file_type');
            $table->dropColumn('file_type_reference');
        });
    }
}
