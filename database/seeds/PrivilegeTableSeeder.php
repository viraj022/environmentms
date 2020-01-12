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
        $p = new Privilege();
        $p->name = 'localAuthority';
        $p->save();

        $p = new Privilege();
        $p->name = 'plant';
        $p->save();

        $p = new Privilege();
        $p->name = 'transferStation';
        $p->save();

        $p = new Privilege();
        $p->name = 'dumpsite';
        $p->save();

        $p = new Privilege();
        $p->name = 'sampath';
        $p->save();

        $p = new Privilege();
        $p->name = 'suboffice';
        $p->save();

    }
}
