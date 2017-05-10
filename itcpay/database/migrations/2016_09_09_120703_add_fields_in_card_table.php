<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsInCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('cards', function (Blueprint $table) {
			$table->string('pan_card_number', 100);
            $table->string('id_type', 50);
			$table->string('id_number', 50);
			$table->date('expiry_date');
			$table->string('issuing_authority', 255);
			$table->string('photo_id', 100);
			$table->string('photo_name', 100);
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
            $table->dropColumn('pan_card_number');
			$table->dropColumn('id_type');
			$table->dropColumn('id_number');
			$table->dropColumn('expiry_date');
			$table->dropColumn('issuing_authority');
			$table->dropColumn('photo_name');
        });
    }
}
