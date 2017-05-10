<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsRemovedFieldToCardsAndAccountsTable extends Migration
{
    public function up()
    {
        Schema::table('cards', function (Blueprint $table) { $table->boolean('is_removed'); });
        Schema::table('accounts', function (Blueprint $table) { $table->boolean('is_removed'); });
    }

    public function down()
    {
        Schema::table('cards', function (Blueprint $table) { $table->dropColumn('is_removed'); });
        Schema::table('accounts', function (Blueprint $table) { $table->dropColumn('is_removed'); });
    }
}
