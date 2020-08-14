<?php

use App\Roll;
use App\User;
use App\Level;
use App\AssistantDirector;
use App\EnvironmentOfficer;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChanageLevelToEnvOfficersToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::table('user', function (Blueprint $table) {

            $environmentOfficers = EnvironmentOfficer::where('active_status', '1')->select('user_id as id')->get();

            $level = Level::where('name', 'Environment Officer')->first();
            $roll = Roll::where('level_id', $level->id)->first();

            if (!$roll) {
                DB::table('rolls')->insert([
                    ['name' => 'admin', 'level_id' => $level->id]
                ]);
                $roll = Roll::where('level_id', $level->id)->first();
            }

            User::whereIn('id', $environmentOfficers)->update(array('roll_id' => $roll->id));
            // \DB::table('magazine_details')

        });
    }

    public function down()
    {
        Schema::table('env_officers_to_users', function (Blueprint $table) {
            //
        });
    }
}
