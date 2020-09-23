<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPathColumnToCommitteeRemarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('committee_remarks', function (Blueprint $table) {
            $table->text('path')->nullable();
            $table->text('remark')->default('')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('committee_remarks', function (Blueprint $table) {
            $table->dropColumn('path');
        });
    }
}
