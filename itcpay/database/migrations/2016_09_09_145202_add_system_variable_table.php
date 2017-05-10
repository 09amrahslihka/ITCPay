<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSystemVariableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_variable', function (Blueprint $table) {
            $table->string('key', 250);
			$table->string('value', 250);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('system_variable');
		Schema::table('system_variable', function (Blueprint $table) {
            $table->dropColumn('key');
			 $table->dropColumn('value');
        });
	}
}
