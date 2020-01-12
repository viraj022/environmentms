<?php

use App\ProvincialCouncil;
use Illuminate\Database\Seeder;

class ProvinceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pc = new   ProvincialCouncil();
        $pc->name = 'Western Provinceial Council';
        $pc->save();
    }
}
