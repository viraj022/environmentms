<?php

use App\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::insertOrIgnore([
            ['id' => 2, 'name' => 'epl_ai', 'value' => '502'],
            ['id' => 3, 'name' => 'site_ai', 'value' => '600'],
        ]);
    }
}
