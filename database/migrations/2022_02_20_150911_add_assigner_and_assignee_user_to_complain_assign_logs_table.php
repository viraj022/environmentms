<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssignerAndAssigneeUserToComplainAssignLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('complain_assign_logs', function (Blueprint $table) {
            if (Schema::hasColumn('complain_assign_logs', 'user_id')) {
                $table->dropColumn('user_id');
            }
            $table->unsignedBigInteger('assigner_user')->nullable();
            $table->unsignedBigInteger('assignee_user')->nullable();
            $table->foreign('assigner_user')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('assignee_user')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('complain_assign_logs', function (Blueprint $table) {
            $table->dropForeign(['assigner_user']);
            $table->dropForeign(['assignee_user']);
            $table->dropColumn('assigner_user');
            $table->dropColumn('assignee_user');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
        });
    }
}
