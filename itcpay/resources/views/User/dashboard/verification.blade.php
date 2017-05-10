@extends('User.dashboard.layouts.master')
@section('title', 'Verification')
@section('content')
<style>
.content{padding:15px 15px 40px;}
</style>
<?php if($type == "business") {
    $url = "businessUp";
} else {
    $url = "personalUp";
}?>

<div class="box box-info clearfix">
	<div class="col-sm-12">
			<div class="verify">
					<div class="tabs-varify clearfix">
						<div class="tab-content clearfix">
                            <form method="post" action="{{ url('/verify/'.$url.'') }}" enctype="multipart/form-data">
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
									Submit the documents asked below with high resolution and high quality in order to verify your identity. Any low resolution and low
									quality document will be rejected. All the 4 edges of the document
									must be visible. Do not crop or rotate the images. Your document must
									be in English or certified translation should be provided. Your
									document must be either in .jpg, .jpeg or .pdf format.
								</p>
								<h2 class="personal">Personal verification</h2>

									{{ csrf_field() }}
									<h3>Your current valid government-issued photo ID</h3>
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group has-feedback">
												<label>ID type:</label>
													<select name="idtype" class="form-control" required="">
														<option value="">Select one</option>
														<option value="National id" <?php if(isset($verificationdoc->id_type) && $verificationdoc->id_type=='National id') { echo "selected"; } ?>>National ID Card</option>
														<option value="passport" <?php if(isset($verificationdoc->id_type) && $verificationdoc->id_type=='passport') { echo "selected"; } ?>>Passport</option>
														<option value="license" <?php if(isset($verificationdoc->id_type) && $verificationdoc->id_type=='license') { echo "selected"; } ?>>Driver's License</option>
													</select>
											</div>
										</div>
										<div class="col-sm-4">	
											<div class="form-group has-feedback">
												<label>ID number:</label>
												 <input type="text"  class="form-control" name="Id_number" required="" value="<?php if(isset($verificationdoc->id_num)) { echo $verificationdoc->id_num; } ?>">
											</div>
										</div>
										<div class="col-sm-4">	
											<div class="form-group has-feedback">
												<label>Issuing authority:</label>
												 <input type="text"  class="form-control" name="issuing_authority" required="" value="<?php if(isset($verificationdoc->issuing_authority)) { echo $verificationdoc->issuing_authority; } ?>">
											</div>
										</div>
									</div>	
											 <?php if(isset($verificationdoc->expiration_date)) { 
												$exp_date = explode('-',$verificationdoc->expiration_date); } ?>
											<div>
												<label>Expiration date (if applicable) :</label>
													<div class="row">
														<div class="col-sm-4">
															<div class="form-group has-feedback">	
																<select  id="em" class="form-control" name="expiration_day">
																	<option value="">Day</option>
																	@for($i=1;$i<=31;$i++)
																	 <option value="{{$i}}" @if(isset($exp_date[2]) && $exp_date[2]==$i) {{'selected="selected"'}} @endif>{{$i}}</option>
																	@endfor
																</select>
															</div>
														</div>
														<div class="col-sm-4">
															<div class="form-group has-feedback">		
																<select id="em" class="form-control" name="expiration_month">
                                                                    @foreach($month as $monthKey => $monthValue)
                                                                        <option value="{{$monthKey}}" @if(isset($exp_date[1]) && $exp_date[1]==$monthKey) {{'selected="selected"'}} @endif>{{$monthValue}}</option>
                                                                    @endforeach
																</select>
															</div>
														</div>
														<div class="col-sm-4">
															<div class="form-group has-feedback">		
																<select  id="ey" class="form-control" name="expiration_year">
																	<option value="">Year</option>
																	@for($i=date('Y');$i<=date('Y')+60;$i++)
																		<option value="{{$i}}" @if(isset($exp_date[0]) && $exp_date[0]==$i) {{'selected="selected"'}} @endif>{{$i}}</option>
																	@endfor
																</select>
															</div>
														</div>
													</div>
													<div class="clearfix"> </div>
											</div>
											<div class="form-group has-feedback ">
                                                <div class="upload-file">
                                                <div class="col-sm-12"><label>Upload your Photo ID (both sides)</label></div>
                                                    <div class="col-sm-4">
                                                    <br />
                                                        <input type="file" name="photo_id" onchnage="alert('dd');" class="filestyle" data-buttontext="Find file" id="filestyle-2" tabindex="-1" style="position: absolute; clip: rect(0px 0px 0px 0px);">
                                                            <input type = "hidden" name = 'photo_id_exist' value = "<?php if(isset($verificationdoc->photo_id)) { echo $verificationdoc->photo_id;} ?>">
                                                            <span class="group-span-filestyle input-group-btn" tabindex="0" style="float:left;width:auto">
                                                            <label for="filestyle-2" class="btn btn-default ">
                                                            <span class="fa fa-cloud-upload"></span>
                                                            <span class="buttonText">Upload document</span>
                                                            </label>
                                                        </span>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="bootstrap-filestyle input-group" style="border:1px solid #d3d3db;padding:10px;">
                                                        <?php if(isset($verificationdoc->photo_id)) { ?>
                                                        <img src = "{{URL::asset('/uploads/athunticate_card/6')}}/{{($verificationdoc->photo_id)}}" style="height: 150px">
                                                        <br />
                                                        <?php   } ?>
                                                        </div>
                                                  </div>
											</div>
											<div class="upload-desc clearfix">
												<ul>	
													<li>Accepted file formats: .jpg, .jpeg, .pdf.</li>
													<li>Acceptable documents include national ID card, passport and driver's license.</li>
													<li>The image must be a color scan of both sides of your ID.</li>
													<li>The four edges of the ID card must be visible in the scanned image.</li>
													<li>Your name, date of birth and ID number must be clearly visible.</li>
													<li>Your name and date of birth must match the information on our file.</li>
												</ul>
											</div>
									<h3>A recent billing statement (proof of address)</h3>
									<div class="col-sm-12">
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group has-feedback">
														<label>Document type</label>
														<select id="documenttype" name="document_type" class="form-control" required="">
															<option value="">Select document type</option>
															<option value="utilitybill" <?php if(isset($verificationdoc->document_type) && $verificationdoc->document_type=='utilitybill') { echo "selected"; } ?>>Utility bill</option>
															<option value="bankstatement" <?php if(isset($verificationdoc->document_type) && $verificationdoc->document_type=='bankstatement') { echo "selected"; } ?>>Bank Statement</option>
															<option value="creditcard" <?php if(isset($verificationdoc->document_type) && $verificationdoc->document_type=='creditcard') { echo "selected"; } ?>>Credit Card Statement</option>
														</select>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group has-feedback"<?php if(isset($verificationdoc->document_type) && $verificationdoc->document_type<>'utilitybill') { ?>  style="display: none;" <?php } ?> id="billtype_div" style = "display:none;">
														<label>Select utility bill type</label>
														<input type="text" class="form-control" name="billtype" value="<?php if(isset($verificationdoc->utility_type)) { echo $verificationdoc->utility_type; } ?>" placeholder="Enter your utility bill type">
													</div>
												</div>
											</div>
											 <?php if(isset($verificationdoc->issuing_date)) { 
													$issuing_date = explode('-',$verificationdoc->issuing_date); } ?>
											 <div>
												<label>Issue date</label>
													<div class="row">
														<div class="col-sm-4">
															<div class="form-group has-feedback">
																<select id="em" class="form-control" name="issue_day" required="">
																	<option value="">Day</option>
																	@for($i=1;$i<=31;$i++)
																	 <option value="{{$i}}" @if(isset($issuing_date[2]) && $issuing_date[2]==$i) {{'selected="selected"'}} @endif>{{$i}}</option>
																	@endfor
																</select>
															</div>
														</div>
														
														<div class="col-sm-4">
															<div class="form-group has-feedback">
																<select id="em" class="form-control" name="issue_month" required="">
                                                                    @foreach($month as $monthKey => $monthValue)
                                                                        <option value="{{$monthKey}}" @if(isset($issuing_date[1]) && $issuing_date[1]==$monthKey) {{'selected="selected"'}} @endif>{{$monthValue}}</option>
                                                                    @endforeach
																</select>
															</div>
														</div>

														<div class="col-sm-4">
															<div class="form-group has-feedback">
																<select id="ey" class="form-control" name="issue_year" required="">
																	<option value="">Year</option>
																	  @for($i=date('Y');$i>=date('Y')-1;$i--)
																	  <option value="{{$i}}" @if(isset($issuing_date[0]) && $issuing_date[0]==$i) {{'selected="selected"'}} @endif>{{$i}}</option>
																	  @endfor
																</select>
															</div>
														</div>
													</div>
													<div class="clearfix"> </div>
											</div>
											<div class="form-group has-feedback">
												<div class="upload-file">
													<label>Upload address proof document</label>
													{{--<input type="file"  name="address_proof" required="">--}}
													<div class="row">
														<div class="col-md-12">
															<input type="file" name="address_proof" class="filestyle" data-buttontext="Find file" id="addressproof" tabindex="-1" style="position: absolute; clip: rect(0px 0px 0px 0px);">
															<div class="bootstrap-filestyle input-group">
															   <?php if(isset($verificationdoc->document)) { echo $verificationdoc->document; } ?>
																<span class="group-span-filestyle input-group-btn" tabindex="0">
																	<label for="addressproof" class="btn btn-default ">
																		<span class="fa fa-cloud-upload"></span>
																		<span class="buttonText">Upload document</span>
																	</label>
																</span>
															</div>
														</div>
													 </div>
												</div> 
											</div>
											<div class="upload-desc clearfix">
												<ul>	
													<li>Accepted file formats: .jpg, .jpeg, .pdf.</li>
												</ul>
											</div>
                                        <div class="row">
                                            <div class="upload-desc clearfix">
                                                <ul>
                                                    <li>
                                                        Acceptable documents include a recurring bank statement, credit
                                                        card statement, utility bill such as electricity bill, gas bill, water
                                                        bill, telephone bill (but not mobile phone bill, wireless internet
                                                        bill or any wireless service bill).
                                                    </li>
                                                    <li>Your document must be issued within 2 months and must be a recurring statement.</li>
                                                    <li>Your name, address and document issue date must be clearly visible.</li>
                                                    <li>Your name on the document must match the name on your account.</li>
                                                    <li>Your address on the document must match the address on your account too.</li>
                                                    <li>
                                                        If you are submitting a bank statement or credit card statement,
                                                        please ensure that it is either a scan of your official bank statement
                                                        or credit card statement issued by your bank or the downloaded .pdf
                                                        file of your online banking statement or credit card statement and not
                                                        a screenshot. We are unable to accept a screenshot of your online
                                                        banking statement or credit card statement.
                                                    </li>
                                                </ul>
                                            </div>
											{{--<div class="col-md-3">--}}
												{{--<input type="submit" name="" class="next btn btn-info pull-right btn-primary btn-block btn-flat ">--}}
											{{--</div>--}}

										</div>
									</div>
									<input type="hidden" value="<?php echo $type; ?>" name="type" />
									{{--<button type="button" onclick="location.href ='{{URL::to('/dashboard')}}'" class="btn btn-danger">Return to My Account</button>--}}

								{{--<button type="button" onclick="location.href ='{{URL::to('/dashboard')}}'" class="btn btn-danger">Return to My Account</button>--}}
							</div>
                                @if($type=="business")
							<div id="business">
								<h2 class="margin-top-10">Business verification</h2>

								   {{ csrf_field() }}
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group has-feedback">
											<label>Company type:</label>
											<input type="text"  class="form-control" name="company_type" required="" value="<?php if(isset($verificationdoc->company_type)) { echo $verificationdoc->company_type; } ?>">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group has-feedback">
											<label>Number of employees:</label>
											<input type="text"  class="form-control" name="employees" required="" value="<?php if(isset($verificationdoc->employees)) { echo $verificationdoc->employees; } ?>">
										</div> 	
									</div>
									<div class="col-sm-4">
										<div class="form-group has-feedback">
											<label>Company registration number:</label>
											<input type="text"  class="form-control" name="company_registration_no" required="" value="<?php if(isset($verificationdoc->company_registration_no)) { echo $verificationdoc->company_registration_no; } ?>">
										</div>	
									</div>	    
								</div>		   
								<div>
									<label>Registration date:</label>
									 <?php if(isset($verificationdoc->registration_date)) { 
									$registration_date = explode('-',$verificationdoc->registration_date); } ?>                 
										<div class="row">
											<div class="col-sm-4">
												<div class="form-group has-feedback">	
													<select class="form-control" name="registration_day" required="">
														<option value="">Day</option>
														@for($i=1;$i<=31;$i++)
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
											<label>Registration country:</label>
											{{ Form::select('registration_country', $country, "", array("class" => "form-control", "required")) }}
										</div>	
									</div>
									<div class="col-sm-3">
										<div class="form-group has-feedback">
											<label>Tax ID</label>
											<input type="text" class="form-control" name="text_id" placeholder="Tax ID" style="" value="<?php if(isset($verificationdoc->text_id) && $verificationdoc->text_id<>'') { echo $verificationdoc->text_id; } ?>">
									    </div>		
									</div>
									<div class="col-sm-3">
										<div class="form-group has-feedback">
											<label>Do you use trade license?</label>
											<select id="license" name="license" class="form-control">
												<option value="">Select one</option>
												<option value="yes" <?php if(isset($verificationdoc->license_no) && $verificationdoc->license_no<>'') { echo "selected"; } ?>>Yes</option>
												<option value="no">No</option>
											</select>
									    </div>	
									</div>
									<div class="col-sm-3">
										<div class="form-group has-feedback" id="license_no_div" <?php if(isset($verificationdoc->license_no) && $verificationdoc->license_no=='') { ?>  style="display:none;" <?php } ?> style = 'display:none;'>
											<label>Enter license number</label>
											<input type="text" class="form-control" id="license_no" name="license_no" placeholder="License Number" value="<?php if(isset($verificationdoc->license_no)) { echo $verificationdoc->license_no; } ?>">
									    </div>	
									</div>
								</div>	
								
								<div class="form-group has-feedback">
									<div class="upload-file clearfix">	
										<label>Company registration document (Certificate of Incorporation)</label>
										 <p>Upload high resolution color scan of your document.</p>
										<div class="business-docs">
											<input type="file" name="company_registration_document" class="filestyle" data-buttontext="Find file" id="company_registration_document" tabindex="-1" style="position: absolute; clip: rect(0px 0px 0px 0px);">
											<div class="bootstrap-filestyle input-group">
												 <?php if(isset($verificationdoc->company_registration_document)) { echo $verificationdoc->company_registration_document; } ?>
												<span class="group-span-filestyle input-group-btn" tabindex="0">
													<label for="company_registration_document" class="btn btn-default ">
														<span class="fa fa-cloud-upload"></span> 
														<span class="buttonText">Upload document</span>
													</label>
												</span>
											</div>
										</div>
									</div>	
									<div class="upload-desc clearfix">
										<ul>
											<li>Accepted file formats: .jpg, .jpeg, .pdf.</li>
										</ul>
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
                                        <?php if(isset($verificationdoc->business_addproof_issue_date)) {
                                            $business_addproof_issue_date = explode('-',$verificationdoc->business_addproof_issue_date); } ?>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group has-feedback">
                                                    <select class="form-control" name="business_addproof_issue_day" required="">
                                                        <option value="">Day</option>
                                                        @for($i=1;$i<=31;$i++)
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
                                                        @for($i=date('Y');$i>=1900;$i--)
                                                            <option value="{{$i}}" @if(isset($business_addproof_issue_date[0]) && $business_addproof_issue_date[0]==$i) {{'selected="selected"'}} @endif>{{$i}}-{{$i-1}}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
										<div class="business-docs">
											<input type="file" name="company_address_proof" class="filestyle" data-buttontext="Find file" id="company_address_proof" tabindex="-1" style="position: absolute; clip: rect(0px 0px 0px 0px);">
											<div class="bootstrap-filestyle input-group">
											   <?php if(isset($verificationdoc->company_address_proof)) { echo $verificationdoc->company_address_proof; } ?>  
												<span class="group-span-filestyle input-group-btn" tabindex="0">
													<label for="company_address_proof" class="btn btn-default ">
														<span class="fa fa-cloud-upload"></span> 
														<span class="buttonText">Upload document</span>
													</label>
												</span>
											</div>
										</div>
									</div>	
									<div class="upload-desc clearfix">
										<ul>	
											<li>Accepted file formats: .jpg, .jpeg, .pdf.</li>
										</ul>
									</div>

								</div>
									<div class="form-group has-feedback ">
										<div class="upload-file clearfix">
											<label>Details of shareholders, directors and beneficial owners</label>
											<p>Please enter the names, percent of shares and addresses of the
											   shareholders, directors and beneficial owners of the company on a
											   company letterhead and have this signed and stamped.</p>
											<div class="business-docs">
												<input type="file" name="business_details" class="filestyle" data-buttontext="Find file" id="business_details" tabindex="-1" style="position: absolute; clip: rect(0px 0px 0px 0px);">
												<div class="bootstrap-filestyle input-group"> 
												<?php if(isset($verificationdoc->business_details)) { echo $verificationdoc->business_details; } ?>          
													<span class="group-span-filestyle input-group-btn" tabindex="0">
														<label for="business_details" class="btn btn-default ">
															<span class="fa fa-cloud-upload"></span> 
															<span class="buttonText">Upload document</span>
														</label>
													</span>
												</div>
											</div>
										</div>	
										<div class="upload-desc clearfix">
											<ul>	
												<li>Accepted file formats: .jpg, .jpeg, .pdf.</li>
											</ul>
										</div>
									</div>


									 <div class="form-group has-feedback ">
										<div class="upload-file clearfix">
											<label>Authorization letter (if applicable)</label>
											<p>If the accountholder's name is not registered in the business
											   registration document, submit an authorization letter under your
											   company's letterhead signed by one of your directors to authorize you
											   to operate this account on behalf of your company.</p>
											<div class="business-docs">
												<input type="file" name="authorization_letter" class="filestyle" data-buttontext="Find file" id="authorization_letter" tabindex="-1" style="position: absolute; clip: rect(0px 0px 0px 0px);">
												<div class="bootstrap-filestyle input-group">        
												 <?php if(isset($verificationdoc->authorization_letter)) { echo $verificationdoc->authorization_letter; } ?>            
													<span class="group-span-filestyle input-group-btn" tabindex="0">
														<label for="authorization_letter" class="btn btn-default ">
															<span class="fa fa-cloud-upload"></span> 
															<span class="buttonText">Upload document</span>
														</label>
													</span>
												</div>
											</div>
										</div>
										<div class="upload-desc clearfix">		
											<ul>	
												<li>Accepted file formats: .jpg, .jpeg, .pdf.</li>
											</ul>
										</div>
									</div>                                      
									{{--<input type="file" name="bDocuments">--}}
									<input type="hidden" value="{{$type}}" name="type" />


							</div>
                                    @endif
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="verify-btns clearfix">
                                            <div class="btn-return">
                                                <button type="button" onclick="location.href ='{{URL::to('/verifications?type='.$type.'')}}'" class="next btn btn-danger pull-right btn-primary btn-block btn-flat">Return to Verifications</button>
                                            </div>
                                            <div class="btn-submit">
                                                <input type="submit" name="" class="next btn  pull-right btn-primary btn-block btn-flat" value="Save">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>
						</div> 
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
