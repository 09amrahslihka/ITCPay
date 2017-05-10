<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccountIdColumnToUserIdentityVerificationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_identity_verification_details', function (Blueprint $table) {
            $table->integer('account_id')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_identity_verification_details', function (Blueprint $table) {
            $table->dropColumn('account_id');
        });
    }
}
