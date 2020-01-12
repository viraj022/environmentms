<?php

use App\Roll;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $u = new User();
        $u->user_name = 'National';
        $u->first_name = 'National';
        $u->last_name = 'National';
        $u->roll_id = Roll::where('name', 'Super Roll')->first()->id;
        $u->password = Hash::make('12345678');
        $u->api_token = Str::random(80);
        $u->save();
        $u->privileges()->attach(
            '1', [
                'is_read' => '1',
                'is_create' => '1',
                'is_update' => '1',
                'is_delete' => '1',
            ]);

    }
}
