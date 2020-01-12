<?php

use App\Level;
use App\Roll;
use Illuminate\Database\Seeder;

class RollTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roll = new Roll();
        $roll->name = 'Super Roll';
        $roll->level_id = Level::where('name', Level::LOCAL)->first()->id;
        $roll->save();

        $roll = ROll::where('name', 'Super Roll')->first();
        $roll->privileges()->detach();
        $roll->privileges()->attach(
            '1', [
                'is_read' => '1',
                'is_create' => '1',
                'is_update' => '1',
                'is_delete' => '1',
            ]);

    }
}
