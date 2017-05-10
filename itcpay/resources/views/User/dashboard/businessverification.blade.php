@extends('User.dashboard.layouts.master')
@section('content')
    <style>
        .content{padding:15px 15px 40px;}
    </style>
  <div class="box box-info clearfix">
        <div class="col-sm-12">
            <div class="verify">
                <div class="tabs-varify clearfix">
                    <form method="post" action="{{ url('/verify/businessUp') }}" enctype="multipart/form-data">
                    <div class="tab-content clearfix">

                            <div id="personal">
                                @if(Session::has('message'))
                                    <div class="alert alert-success" role="alert">
                                        {{Session::get('message')}}
                                    </div>
                                @endif
                                @if(count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <p class="identity">
                                    <!-- Submit the documents asked below with high resolution and high quality in order to verify your identity. Any low resolution and low
                                    quality document will be rejected. All the 4 edges of the document
                                    must be visible. Do not crop or rotate the images. Your document must
                                    be in English or certified translation should be provided. Your document must be either in .jpg, .jpeg, .pdf, .png, .gif, .bmp etc. format
                    and Max Size 10MB. -->

                    Submit the documents asked below with high resolution and high quality in order to verify your identity. Any low resolution and low
                                    quality document will be rejected. All the 4 edges of the document
                                    must be visible. Do not crop or rotate the images. Your document must

                                    be in English or certified translation should be provided. Your document should be within 10MB of size and among following file formats:  .jpg , .jpeg , .pdf, .png, .gif, .bmp . 


                                {{ csrf_field() }}
                                    </div>
                            <div id="business">
    <h2 class="margin-top-10">Business verification</h2>
    {{ csrf_field() }}
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group has-feedback">
                <label>Company type:</label>
                <input type="text"  class="form-control" name="company_type" required="" value="<?php if(isset($verificationInformation->company_type)) { echo $verificationInformation->company_type; } ?>">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group has-feedback">
                <label>Number of employees:</label>
                <input type="text"  class="form-control" name="employees" required="" value="<?php if(isset($verificationInformation->number_of_employee) && (!empty($verificationInformation->number_of_employee))) { echo $verificationInformation->number_of_employee; } ?>">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group has-feedback">
                <label>Company registration number:</label>
                <input type="text"  class="form-control" name="company_registration_no" required="" value="<?php if(isset($verificationInformation->company_registration_no)) { echo $verificationInformation->company_registration_no; } ?>">
            </div>
        </div>
    </div>
    <div>
        <label>Registration date:</label>
        <?php if(isset($verificationInformation->registration_date)) {
            $registration_date = explode('-',$verificationInformation->registration_date); } ?>
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group has-feedback">
                    <select class="form-control" name="registration_day" required="">
                        <option value="">Day</option>
                        @for($i=1;$i<=31;$i++)
                            <?php  if($i<=10)  { $i = "0$i";  }  ?>
                            <option value="{{$i}}" @if(isset($registration_date[2]) && $registration_date[2]==$i) {{'selected="selected"'}} @endif>{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group has-feedback">
                    <select class="form-control" name="registration_month" required="">
                        @foreach($month as $monthKey => $monthValue)
                            <option value="{{$monthKey}}" @if(isset($registration_date[1]) && $registration_date[1]==$monthKey) {{'selected="selected"'}} @endif>{{$monthValue}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group has-feedback">
                    <select class="form-control" name="registration_year" required="">
                        <option value="">Year</option>
                        @for($i=date('Y');$i>=1900;$i--)
                            <option value="{{$i}}" @if(isset($registration_date[0]) && $registration_date[0]==$i) {{'selected="selected"'}} @endif>{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
        <div class="clearfix"> </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group has-feedback">
                <label>Registration country :</label>
                @if(isset($verificationInformation->registration_country))
                {{ Form::select('registration_country',$country,$verificationInformation->registration_country, array("class" => "form-control", "required")) }}
                 @else
                    {{ Form::select('registration_country',$country,"", array("class" => "form-control", "required")) }}
                @endif
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group has-feedback">
                <label>Tax ID</label>
                <input type="text" class="form-control" name="text_id" placeholder="Tax ID" style="" value="<?php if(isset($verificationInformation->tax_id) && $verificationInformation->tax_id<>'') { echo $verificationInformation->tax_id; } ?>">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group has-feedback">
                <label>Do you use trade license?</label>
                <select id="license" name="license" class="form-control">
                    <option value="">Select one</option>
                    <option value="yes" <?php if(isset($verificationInformation->license_no) && $verificationInformation->license_no<>'') { echo "selected"; } ?>>Yes</option>
                    <option value="no" <?php if(isset($verificationInformation->license_no) && $verificationInformation->license_no=='') { echo "selected"; } ?>>No</option>
                </select>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group has-feedback" id="license_no_div" <?php if(isset($verificationInformation->license_no) && $verificationInformation->license_no!='') { ?>  style="display:block;" <?php } ?> style = 'display:none;'>
                <label>Enter license number</label>
                <input type="text" class="form-control" id="license_no" name="license_no" placeholder="License Number" value="<?php if(isset($verificationInformation->license_no)) { echo $verificationInformation->license_no; } ?>">
            </div>
        </div>
    </div>
        <div class="upload-file clearfix">
            <label>Company registration document (Certificate of Incorporation)</label>
            <p>Upload high resolution color scan of your document.</p>
            <div class="business-docs col-sm-2">
                @if(empty($verificationInformation->company_registration_document_size))

                <input type="file"  required="" name="company_registration_document" class="filestyle" data-buttontext="Find file" id="company_registration_document" tabindex="-1" style="position: absolute; clip: rect(0px 0px 0px 0px);" accept=".png,.jpg,.jpeg ,.pdf,.gif,.bmp">

                @else
                    <input type="file" name="company_registration_document" class="filestyle" data-buttontext="Find file" id="company_registration_document" tabindex="-1" style="position: absolute; clip: rect(0px 0px 0px 0px);">
                 @endif
                    <div class="bootstrap-filestyle input-group">
                    <span class="group-span-filestyle input-group-btn" tabindex="0">
													<label for="company_registration_document" class="btn btn-default ">
                                                        <span class="fa fa-cloud-upload"></span>
                                                        <span class="buttonText">Upload document</span>
                                                    </label>
												</span>
                </div>
            </div>
            <div class="col-sm-4">
                <label class="margin-top-10"> <?php if(isset($verificationInformation->company_registration_document_size) && (!empty($verificationInformation->company_registration_document_size))) { echo "File Name : $verificationInformation->company_registration_document_original_name"; } ?>&nbsp;&nbsp;<?php  if(isset($verificationInformation->company_registration_document_size) && (!empty($verificationInformation->company_registration_document_size))) { echo "File Size    :".number_format($verificationInformation->company_registration_document_size/1024,2)."&nbsp;KB"; } ?></label>
                <input type = "hidden" name = 'companyRegistrationDocument' value = "<?php if(isset($verificationInformation->company_registration_document_size)) { echo $verificationInformation->company_registration_document_size;} ?>">
            </div>
        </div>
    </div>
        <div class="clearfix">
        <div class="upload-file clearfix">
            <label>Company address proof document</label>
            <p>Submit your company address proof document such as a utility bill or
                bank statement issued within 2 months. Company name, address and
                document issue date must be clearly visible on the document. Company
                name and address on the document must match the company name and
                address on your account.
            </p>
            <label>Issue date:</label>
            <?php if(isset($verificationInformation->company_address_proof_issue_date)) {
                $business_addproof_issue_date = explode('-',$verificationInformation->company_address_proof_issue_date); } ?>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group has-feedback">
                        <select class="form-control" name="business_addproof_issue_day" required="">
                            <option value="">Day</option>
                            @for($i=1;$i<=31;$i++)
                                <?php  if($i<=10)  { $i = "0$i";  }  ?>
                                <option value="{{$i}}" @if(isset($business_addproof_issue_date[2]) && $business_addproof_issue_date[2]==$i) {{'selected="selected"'}} @endif>{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group has-feedback">

                        <select class="form-control" name="business_addproof_issue_month" required="">
                            @foreach($month as $monthKey => $monthValue)
                                <option value="{{$monthKey}}" @if(isset($business_addproof_issue_date[1]) && $business_addproof_issue_date[1]==$monthKey) {{'selected="selected"'}} @endif>{{$monthValue}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group has-feedback">
                        <select class="form-control" name="business_addproof_issue_year" required="">
                            <option value="">Year</option>
                            @for($i=date('Y');$i>=date('Y')-1;$i--)
                                <option value="{{$i}}" @if(isset($business_addproof_issue_date[0]) && $business_addproof_issue_date[0]==$i) {{'selected="selected"'}} @endif>{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
            <div class="business-docs col-sm-2">
                @if(!empty($verificationInformation->company_address_proof_size))

                <input type="file" name="company_address_proof" class="filestyle" data-buttontext="Find file" id="company_address_proof" tabindex="-1" style="position: absolute; clip: rect(0px 0px 0px 0px);" accept=".png,.jpg,.jpeg ,.pdf,.gif,.bmp">
                @else
                    <input type="file" name="company_address_proof" required="" class="filestyle" data-buttontext="Find file" id="company_address_proof" tabindex="-1" style="position: absolute; clip: rect(0px 0px 0px 0px);" accept=".png,.jpg,.jpeg ,.pdf,.gif,.bmp">

                @endif
                <div class="bootstrap-filestyle input-group">
                    <span class="group-span-filestyle input-group-btn" tabindex="0">
													<label for="company_address_proof" class="btn btn-default ">
                                                        <span class="fa fa-cloud-upload"></span>
                                                        <span class="buttonText">Upload document</span>
                                                    </label>
												</span>
                </div>
            </div>
            <div class="col-sm-4">
               <label class="margin-top-10"> <?php if(isset($verificationInformation->company_address_proof_size) && (!empty($verificationInformation->company_address_proof_size))) { echo "File Name : $verificationInformation->company_address_proof_original_name"; } ?>&nbsp;&nbsp;<?php  if(isset($verificationInformation->company_address_proof_size) && (!empty($verificationInformation->company_address_proof_size))) { echo "File Size    :".number_format($verificationInformation->company_address_proof_size/1024,2)."&nbsp;KB"; } ?></label>
               <input type = "hidden" name = 'companyAddressProof' value = "<?php if(isset($verificationInformation->company_address_proof_size)) { echo $verificationInformation->company_address_proof_size;} ?>">
            </div>
        </div>
    </div>
                            <div class="form-group has-feedback ">
        <div class="upload-file clearfix">
            <label>Details of shareholders, directors and beneficial owners</label>
            <p>Please enter the names, percent of shares and addresses of the
                shareholders, directors and beneficial owners of the company on a
                company letterhead and have this signed and stamped.</p>
            <div class="business-docs col-sm-2">
                @if(empty($verificationInformation->business_details_proof_size))

                <input type="file" required="" name="business_details" class="filestyle" data-buttontext="Find file" id="business_details" tabindex="-1" style="position: absolute; clip: rect(0px 0px 0px 0px);" accept=".png,.jpg,.jpeg ,.pdf,.gif,.bmp">

              @else
                    <input type="file" name="business_details" class="filestyle" data-buttontext="Find file" id="business_details" tabindex="-1" style="position: absolute; clip: rect(0px 0px 0px 0px);">
                @endif
                    <div class="bootstrap-filestyle input-group">
                    <span class="group-span-filestyle input-group-btn" tabindex="0">
														<label for="business_details" class="btn btn-default ">
                                                            <span class="fa fa-cloud-upload"></span>
                                                            <span class="buttonText">Upload document</span>
                                                        </label>
													</span>
                </div>
            </div>
            <div class="col-sm-4">
                <label class="margin-top-10"> <?php if(isset($verificationInformation)  && (!empty($verificationInformation->business_details_proof_size))) { echo "File Name : $verificationInformation->business_details_original_name"; } ?>&nbsp;&nbsp;<?php  if(isset($verificationInformation)  && (!empty($verificationInformation->business_details_proof_size))) { echo "File Size    :".number_format($verificationInformation->	business_details_proof_size/1024,2)."&nbsp;KB"; } ?></label>
                <input type = "hidden" name = 'businessDetails' value = "<?php if(isset($verificationInformation->business_details_proof_size)) { echo $verificationInformation->business_details_proof_size;} ?>">

            </div>
        </div>
    </div>
                             <div class="form-group has-feedback ">
        <div class="upload-file clearfix">
            <label>Authorization letter (if applicable)</label>
            <p>If the accountholder's name is not registered in the business
                registration document, submit an authorization letter under your
                company's letterhead signed by one of your directors to authorize you
                to operate this account on behalf of your company.</p>
            <div class="business-docs col-sm-2">

                <input type="file" name="authorization_letter" class="filestyle" data-buttontext="Find file" id="authorization_letter" tabindex="-1" style="position: absolute; clip: rect(0px 0px 0px 0px);" accept=".png,.jpg,.jpeg ,.pdf,.gif,.bmp">

                <div class="bootstrap-filestyle input-group">
                    <span class="group-span-filestyle input-group-btn" tabindex="0">
						<label for="authorization_letter" class="btn btn-default ">
                            <span class="fa fa-cloud-upload"></span>
                            <span class="buttonText">Upload document</span>
                        </label>
					</span>

                </div>
            </div>
            <div class="col-sm-4">
                <label class="margin-top-10"> <?php if(isset($verificationInformation)  && (!empty($verificationInformation->authorization_letter_proof_size))) { echo "File Name : $verificationInformation->authorization_letter_original_name"; } ?>&nbsp;&nbsp;<?php  if(isset($verificationInformation)  && (!empty($verificationInformation->authorization_letter_proof_size))) { echo "File Size    :".number_format($verificationInformation->authorization_letter_proof_size/1024,2)."&nbsp;KB"; } ?></label>
                <input type = "hidden" name = 'businessDetails' value = "<?php if(isset($verificationInformation->authorization_letter_proof_size)) { echo $verificationInformation->authorization_letter_proof_size;} ?>">

            </div>
    {{--<input type="file" name="bDocuments">--}}

            <input type="hidden" value="{{$type}}" name="type" />

                    

</div>
                       <div class="row">
    <div class="col-sm-12">
        <div class="verify-btns clearfix">
            <div class="btn-return">
                <button type="button" onclick="location.href ='{{URL::to('/verifications?type='.$type.'')}}'" class="next btn btn-danger pull-right btn-primary btn-block btn-flat">Return to Verifications</button>
            </div>
            <div class="btn-submit">

                <input type="submit" name="" class="next btn  pull-right btn-primary btn-block btn-flat" value="Submit">

            </div>
        </div>
    </div>
</div>
                        </form>
                  </div>
</div>
</div>
</div>
<script>
    jQuery(document).ready(function(){
        $("#documenttype").change(function(){
            var documenttype = $(this).val();
            if(documenttype == "utilitybill"){
                $("#billtype_div").css('display','block');
            }else{
                $("#billtype_div").css('display','none');
            }

        });
        $("#license").change(function(){
            var license = $(this).val();
            if(license == "yes"){
                $("#license_no_div").css('display','block');
            }else{
                $("#license_no_div").css('display','none');
            }

        });
    });
</script>
@stop
