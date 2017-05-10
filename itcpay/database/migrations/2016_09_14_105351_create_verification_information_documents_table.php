<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVerificationInformationDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verification_information_documents', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger('verification_id');
			$table->string('photo_id_storage_name', 250);
			$table->string('photo_id_original_name', 250);
			$table->integer('photo_id_size');
			$table->string('document_id_storage_name', 250);
			$table->string('document_id_original_name', 250);
			$table->integer('document_id_size');
			$table->string('company_registration_document_storage_name', 250);
			$table->string('company_registration_document_original_name', 250);
			$table->integer('company_registration_document_size');
			$table->string('company_address_proof_storage_name', 250);
			$table->string('company_address_proof_original_name', 250);
			$table->integer('company_address_proof_size');
			$table->string('business_details_storage_name', 250);
			$table->string('business_details_original_name', 250);
			$table->integer('business_details_proof_size');
			$table->string('authorization_letter_storage_name', 250);
			$table->string('authorization_letter_original_name', 250);
			$table->integer('authorization_letter_proof_size');
            $table->timestamps();
        });
		 Schema::table('verification_information_documents', function(Blueprint $table) {
            $table->foreign('verification_id')->references('id')->on('verification_information')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('verification_information_documents', function(Blueprint $table) {
            $table->dropForeign('verification_information_documents_verification_id_foreign');
        });
        Schema::drop('verification_information_documents');
    }
}
