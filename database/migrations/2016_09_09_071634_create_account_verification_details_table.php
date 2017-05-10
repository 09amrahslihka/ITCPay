<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountVerificationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_verification_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id');
            $table->string('account_user_id', 150);
            $table->string('account_password', 250);
            $table->timestamps();
        });

        Schema::table('account_verification_details', function(Blueprint $table) {
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('account_verification_details');
    }
}
