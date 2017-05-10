<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCountryStatesTable
 *
 * migration class to create country_states table
 * created Sep 16, 2016
 *
 * @author Naman Attri
 */
class CreateCountryStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_states', function (Blueprint $table) {
            $table->increments('id');
            $table->string('country', 250);
            $table->string('state', 250);
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
        Schema::drop('country_states');
    }
}
