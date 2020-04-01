<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Privilege;
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
        $privilage = new Privilege();
        $privilage->id=10;
        $privilage->name='Client Space';
        $privilage->save();

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
