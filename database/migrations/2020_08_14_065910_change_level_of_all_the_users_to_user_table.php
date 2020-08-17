<?php

use App\Roll;
use App\User;
use App\Level;
use App\AssistantDirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeLevelOfAllTheUsersToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user', function (Blueprint $table) {
            $assDir = AssistantDirector::join('users', 'assistant_directors.user_id', '=', 'users.id')
                ->join('zones', 'assistant_directors.zone_id', '=', 'zones.id')
                ->where('assistant_directors.active_status', '=', '1')
                ->select('assistant_directors.id', 'users.first_name as first_name', 'users.last_name as last_name', 'users.user_name as user_name', 'users.id as user_id', 'zones.id as zone_id', 'zones.name as zone_name')
                ->get();
            $dirIdList = array();
            foreach ($assDir as $data) {
                array_push($dirIdList, $data['user_id']);
            }
            $level = Level::where('name', 'Assistant Director')->first();
            $roll = Roll::where('level_id', $level->id)->first();

            if (!$roll) {
                DB::table('rolls')->insert([
                    ['name' => 'admin', 'level_id' => $level->id]
                ]);
                $roll = Roll::where('level_id', $level->id)->first();
            }

            User::whereIn('id', $dirIdList)->update(array('roll_id' => $roll->id));
            // \DB::table('magazine_details')

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user', function (Blueprint $table) {
            //
        });
    }
}
