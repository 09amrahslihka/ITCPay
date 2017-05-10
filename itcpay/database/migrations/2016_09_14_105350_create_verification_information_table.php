<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVerificationInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verification_information', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id');
			$table->string('type', 250);
			$table->string('id_type', 250);
			$table->string('id_number', 250);
			$table->string('issuing_authority', 250);
			$table->date('expiration_date', 250);
			$table->string('document_type', 250);
			$table->string('document_utility_type', 250);
			$table->date('document_issue_date', 250);
			$table->string('company_type', 250);
			$table->string('number_of_employee', 250);
			$table->string('company_registration_no', 250);
			$table->date('registration_date', 250);
			$table->string('registration_country', 250);
			$table->string('tax_id', 250);
			$table->string('license_no', 250);
			$table->date('company_address_proof_issue_date', 250);
			$table->tinyInteger('is_saved');
            $table->timestamps();
        });
		Schema::table('verification_information', function(Blueprint $table) {
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
        Schema::table('verification_information', function(Blueprint $table) {
            $table->dropForeign('verification_information_user_id_foreign');
        });
        Schema::drop('verification_information');
    }
}
