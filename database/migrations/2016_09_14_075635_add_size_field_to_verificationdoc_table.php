<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSizeFieldToVerificationdocTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('verificationdoc', function (Blueprint $table) {
			$table->string('photo_size',255)->after('photo_id');
			$table->string('document_size',255)->after('document');
			$table->integer('personal_form_status')->after('status');
			$table->integer('business_form_status')->after('personal_form_status');
			$table->string('company_registration_document_size',255)->after('company_registration_document');
			$table->string('company_address_proof_size',255)->after('company_address_proof');
			$table->string('business_details_size',255)->after('business_details');
			$table->string('authorization_letter_size',255)->after('authorization_letter');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('verificationdoc', function (Blueprint $table) {
				$table->dropColumn('photo_size');
				$table->dropColumn('document_size');
				$table->dropColumn('personal_form_status');
				$table->dropColumn('business_form_status');				
                $table->dropColumn('company_registration_document_size');
				$table->dropColumn('company_address_proof_size');
				$table->dropColumn('business_details_size');
				$table->dropColumn('authorization_letter_size');
        });
    }
}
