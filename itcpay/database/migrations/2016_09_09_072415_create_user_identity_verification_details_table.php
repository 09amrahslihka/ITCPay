<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserIdentityVerificationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_identity_verification_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('ssn');
            $table->string('drivers_license_number');
            $table->timestamps();
        });

        Schema::table('user_identity_verification_details', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_identity_verification_details');
    }
}
