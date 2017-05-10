<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToVerificationdocTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('verificationdoc', function (Blueprint $table) {
            $table->string('originalPhotoIdName', 255);
			$table->string('originalDocumentName', 255);
            $table->string('originalRegistrationDocumentName',255);
			$table->string('originalcomanyAddressName',255);
	    	$table->string('originalBusinessDetailsDocument',255);
			$table->string('originalAuthorizationletterName',255);
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
           $table->dropColumn('originalPhotoIdName');
		   $table->dropColumn('originalDocumentName');
		   $table->dropColumn('originalRegistrationDocumentName');
		   $table->dropColumn('originalcomanyAddressName');
		   $table->dropColumn('originalBusinessDetailsDocument');
		   $table->dropColumn('originalAuthorizationletterName'); 
        });
    }
}
