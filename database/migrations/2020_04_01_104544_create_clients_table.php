<?php

use App\Privilege;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->text('address')->nullable();
            $table->string('contact_no', 12)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('nic', 12)->unique();
            $table->string('password', 80)->nullable();
            $table->string('api_token', 80)
                ->unique()
                ->nullable()
                ->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
        DB::table('privileges')->insertOrIgnore([
            ['id' => 10, 'name' => 'Client Space'],
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
