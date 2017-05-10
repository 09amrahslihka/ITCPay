<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSizeFieldToCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->string('card_front_original_name',255)->after('card_front_img');
			$table->string('card_front_size',255)->after('card_front_original_name');
			$table->string('card_back_original_name',255)->after('card_back_img');
			$table->string('card_back_size',255)->after('card_back_original_name');
			$table->string('photo_size',255)->after('photo_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cards', function (Blueprint $table) {
            //
        });
    }
}
