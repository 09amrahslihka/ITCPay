<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommandsTable extends Migration
{
    public function up()
    {
        Schema::create('commands', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('name', 250);
            $table->string('value', 250);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('verification_information');
    }
}
