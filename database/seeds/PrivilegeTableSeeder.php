<?php

use App\Privilege;
use Illuminate\Database\Seeder;

class PrivilegeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Privilege::truncate();

        $p = new Privilege();
        $p->name = 'userCreate';
        $p->save();

        $p = new Privilege();
        $p->name = 'userRole';
        $p->save();

    }
}
