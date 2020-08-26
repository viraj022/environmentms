<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApplicationTypeColumnToInspectionSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inspection_sessions', function (Blueprint $table) {
            $table->dropColumn('application_type_id');
            $table->string('application_type')->comment('EPL , Site clearance', 'file')->default('');
            $table->bigInteger('profile_id')->unsigned()->nullable()->change();
            $table->bigInteger('client_id')->unsigned()->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inspection_sessions', function (Blueprint $table) {
            $table->integer('application_type_id')->default(0);
            $table->dropColumn('application_type');
            $table->dropForeign('inspection_sessions_client_id_foreign');
            $table->drop_foreign('client_id');
        });
    }
}
