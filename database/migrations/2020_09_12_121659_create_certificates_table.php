<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {         
            $table->bigIncrements('id');
            $table->bigInteger('client_id')->unsigned();
            $table->integer('certificate_type')->comment('0=epl,1=site clearance');
            $table->string('cetificate_number', 50);
            $table->datetime('issue_date')->nullable();
            $table->integer('issue_status')->comment('0=not issued, 1=issued, 2 =hand over')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->text('certificate_path')->nullable();
            $table->text('signed_certificate_path')->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('certificates');
    }
}
