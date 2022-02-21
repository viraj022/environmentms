<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnFromComplainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('complains', function (Blueprint $table) {
            if (Schema::hasColumn('complains', 'assigner_user')) {
                $table->dropForeign('complains_assigner_user_foreign');
                $table->dropColumn('assigner_user');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('complains', function (Blueprint $table) {
            $table->unsignedBigInteger('assigner_user')->nullable();
            $table->foreign('assigner_user')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
        });
    }
}
