<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFiledToCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('certificates', function (Blueprint $table) {
        $table->bigInteger('user_id_certificate_upload')->unsigned()->nullable();
        $table->foreign('user_id_certificate_upload')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
        $table->date('certificate_upload_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropForeign('certificates_user_id_certificate_upload_foreign');
            $table->dropColumn('user_id_certificate_upload');
            $table->dropColumn('certificate_upload_date');
        });
    }
}
