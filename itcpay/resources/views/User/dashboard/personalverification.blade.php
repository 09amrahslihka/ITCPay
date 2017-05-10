<?php 
    
    //Fetch to know, whether a presonal details are inserted in the DB or Not
    $rec_exist=0;

    //if($verificationInformation->type=='personal')
    // if($type == "personal")
    // {
    //     $rec_exist =1;
    // }
    // else
    // {
    //     $rec_exist = 0;
    // }

?>



@extends('User.dashboard.layouts.master')
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
             <form method="post" action="{{ url('/verify/personalUp') }}" enctype="multipart/form-data" name="Personalverification" id="Personalverification">

                            <input type="hidden" name="non_edit" id="non_edit" value="<?php echo $rec_exist; ?>">

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

                                    be in English or certified translation should be provided. Your document should be within 10MB of size and among following file formats:  .jpg , .jpeg , .pdf, .png, .gif, .bmp . 

                                </p>
                                <h2 class="personal">Personal verification</h2>
                                {{ csrf_field() }}
                                <h3>Your current valid government-issued photo ID</h3>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group has-feedback">
                                            <label>ID type:</label>
                                            <select name="idtype" class="form-control non_edit" required="">
                                                <option value="">Select one</option>
                                                <option value="National id" <?php if(isset($verificationInformation->id_type) && $verificationInformation->id_type=='National id') { echo "selected"; } ?>>National ID Card</option>
                                                <option value="passport" <?php if(isset($verificationInformation->id_type) && $verificationInformation->id_type=='passport') { echo "selected"; } ?>>Passport</option>
                                                <option value="license" <?php if(isset($verificationInformation->id_type) && $verificationInformation->id_type=='license') { echo "selected"; } ?>>Driver's License</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group has-feedback">
                                            <label>ID number:</label>
                                            <input type="text"  class="form-control non_edit" name="Id_number" required="" value="<?php if(isset($verificationInformation->id_number)) { echo $verificationInformation->id_number; } ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group has-feedback">
                                            <label>Issuing authority:</label>
                                            <input type="text"  class="form-control non_edit" name="issuing_authority" required="" value="<?php if(isset($verificationInformation->issuing_authority)) { echo $verificationInformation->issuing_authority; } ?>">
                                        </div>
                                    </div>
                                </div>
                                <?php if(isset($verificationInformation->expiration_date)) {
                                    $exp_date = explode('-',$verificationInformation->expiration_date); } ?>
                                <div>
                                    <label>Expiration date (if applicable) :</label>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group has-feedback">
                                                <select  id="em" class="form-control non_edit" name="expiration_day">
                                                    <option value="">Day</option>
                                                    @for($i=1;$i<=31;$i++)
                                                         <?php  if($i<=10)  { $i = "0$i";  }  ?>
                                                        <option value="{{$i}}" @if(isset($exp_date[2]) && $exp_date[2]==$i) {{'selected="selected"'}} @endif>{{$i}}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group has-feedback">
                                                <select id="em" class="form-control non_edit" name="expiration_month">
                                                    @foreach($month as $monthKey => $monthValue)
                                                        <option value="{{$monthKey}}" @if(isset($exp_date[1]) && $exp_date[1]==$monthKey) {{'selected="selected"'}} @endif>{{$monthValue}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group has-feedback">
                                                <select  id="ey" class="form-control non_edit" name="expiration_year">
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
                                        <div class = 'row'>
                                        <div class="col-sm-2">

                                           <input type="file" name="photo_id" onchnage="alert('dd');" class="filestyle photo_id non_edit" data-buttontext="Find file" id="filestyle-2" tabindex="-1" style="position: absolute; clip: rect(0px 0px 0px 0px);" accept=".png,.jpg,.jpeg ,.pdf,.gif,.bmp">

                                            <input type = "hidden" name = 'photo_id_exist' value = "<?php if(isset($verificationInformation->photo_id_storage_name)) { echo $verificationInformation->photo_id_storage_name;} ?>">
                                                            <span class="group-span-filestyle input-group-btn" tabindex="0" style="float:left;width:auto">
                                                            <label for="filestyle-2" class="btn btn-default ">
                                                                <span class="fa fa-cloud-upload"></span>
                                                                <span class="buttonText">Upload document</span>
                                                            </label>
                                                        </span>
                                        </div>
                                        <div class="col-sm-10 margin-top-10">
                                            <p><b><?php if(isset($verificationInformation->photo_id_original_name) && (!empty($verificationInformation->photo_id_original_name)))   { echo "File Name    : $verificationInformation->photo_id_original_name" ; } ?>&nbsp;&nbsp;<?php  if(isset($verificationInformation->photo_id_size) && (!empty($verificationInformation->photo_id_size)))  {   $size = number_format($verificationInformation->photo_id_size/1024,2);  echo "File Size    : $size KB"; } ?></b></p>
                                        </div>
                                        </div>
                                    </div>
                                    <div class = "clearfix">&nbsp;</div>
                                    <div class="upload-desc clearfix">
                                        <ul>
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
                                                    <select id="documenttype" name="document_type" class="form-control non_edit" required="">
                                                        <option value="">Select document type</option>
                                                        <option value="utilitybill" <?php if(isset($verificationInformation->document_type) && $verificationInformation->document_type=='utilitybill') { echo "selected"; } ?>>Utility bill</option>
                                                        <option value="bankstatement" <?php if(isset($verificationInformation->document_type) && $verificationInformation->document_type=='bankstatement') { echo "selected"; } ?>>Bank Statement</option>
                                                        <option value="creditcard" <?php if(isset($verificationInformation->document_type) && $verificationInformation->document_type=='creditcard') { echo "selected"; } ?>>Credit Card Statement</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group has-feedback"<?php if(isset($verificationInformation->document_type) && $verificationInformation->document_type=='utilitybill') { ?>  style="display: block;" <?php } ?> id="billtype_div" style = "display:none;">
                                                    <label>Select utility bill type</label>
                                                    <input type="text" class="form-control non_edit" name="billtype" value="<?php if(isset($verificationInformation->document_utility_type)) { echo $verificationInformation->document_utility_type; } ?>" placeholder="Enter your utility bill type">
                                                </div>
                                            </div>
                                        </div>
                                        <?php if(isset($verificationInformation->document_issue_date)) {
                                            $issuing_date = explode('-',$verificationInformation->document_issue_date); } ?>
                                        <div>
                                            <label>Issue date</label>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group has-feedback">
                                                        <select id="em" class="form-control non_edit" name="issue_day" required="">
                                                            <option value="">Day</option>
                                                            @for($i=1;$i<=31;$i++)
                                                                <?php  if($i<=10)  { $i = "0$i";  }  ?>
                                                                <option value="{{$i}}" @if(isset($issuing_date[2]) && $issuing_date[2]==$i) {{'selected="selected"'}} @endif>{{$i}}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="form-group has-feedback">
                                                        <select id="em" class="form-control non_edit" name="issue_month" required="">
                                                            @foreach($month as $monthKey => $monthValue)
                                                                <option value="{{$monthKey}}" @if(isset($issuing_date[1]) && $issuing_date[1]==$monthKey) {{'selected="selected"'}} @endif>{{$monthValue}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="form-group has-feedback">
                                                        <select id="ey" class="form-control non_edit" name="issue_year" required="">
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
                                                <div class="row">
                                                    <div class="col-md-2">

                                                        <input type="file" name="address_proof" class="filestyle non_edit" data-buttontext="Find file" id="addressproof" tabindex="-1" style="position: absolute; clip: rect(0px 0px 0px 0px);" accept=".png,.jpg,.jpeg ,.pdf,.gif,.bmp ">

                                                        <div class="bootstrap-filestyle input-group">
                                                            <span class="group-span-filestyle input-group-btn" tabindex="0">
																	<label for="addressproof" class="btn btn-default ">
                                                                        <span class="fa fa-cloud-upload"></span>
                                                                        <span class="buttonText">Upload document</span>
                                                                    </label>
																</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-8 margin-top-10">
                                                         <p><b><?php if(isset($verificationInformation->document_id_original_name) && (!empty($verificationInformation->document_id_original_name)))   { echo "File Name    : $verificationInformation->document_id_original_name" ; } ?>&nbsp;&nbsp;<?php  if(isset($verificationInformation->document_id_size) && (!empty($verificationInformation->document_id_size))) { echo "File Size    :".number_format($verificationInformation->document_id_size/1024,2)."&nbsp;KB"; } ?></b></p>
                                                    </div>
                                                </div>
                                            </div>
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
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="verify-btns clearfix">
                                                <div class="btn-return">
                                                    <button type="button" onclick="location.href ='{{URL::to('/verifications?type='.$type.'')}}'" class="next btn btn-danger pull-right btn-primary btn-block btn-flat">Return to Verifications</button>
                                                </div>
                                                <div class="btn-submit">

                                                    <input type="submit" name="" class="next btn  pull-right btn-primary btn-block btn-flat btn_submit" value="Submit">

                                                </div>
                                            </div>
                                        </div>
                                    </div>



                        </div></form>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <script src="{{URL:: asset('js/jquery.validate.min.js') }}"></script>
    <script>

    $.validator.setDefaults({
        submitHandler: function() {
           return true;
        }
    });

    // validate signup form on keyup and submit
        //$("#document").validate({
            /*rules: {
                //photo_id: "required",
                //cardfront: "required",
                //cardback: "required",
                field: {
                  required: true,
                  minlength: 10
                }
                photoIdValue: "required",
                cardfrontExistValue: "required",
                cardbackExistValue: "required",

                
                
            },
            messages: {

                photoIdValue: "This field required",
                photoIdValue: "This field required",
                cardbackExistValue: "This field required",
                
                
            }*/
      //$().ready(function() {     
        /*$("#Personalverification").validate({    
              rules: {
                    photo_id: {
                        required: true,
                        accept: "jpg,png,jpeg,gif,application/pdf"
                    },
                    address_proof: {
                        required: true,
                        accept: "jpg,png,jpeg,gif,application/pdf"
                    }
            },
                    messages: {
                        photo_id: {
                            required: 'This field is required.',
                            accept: 'Only images with type jpg/png/jpeg/gif/PDF/bmp  are allowed'
                        },
                        address_proof: {
                            required: "This field is required.",
                             accept: 'Only images with type jpg/png/jpeg/gif/PDF/bmp  are allowed'
                        }
                    },
            });*/
       
          //});
         
            /*$('.photo_id').change(
                function () {
                    alert('hjhj')
                    var fileExtension = ['jpeg', 'jpg', 'pdf'];
                    if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                        alert("Only '.jpeg','.jpg','.pdf' formats are allowed.");
                        return false; }
            });*/


  

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

            //Set all the textbox and dropdown fields as non editable
            var non_edit = $("#non_edit").val();
            if(non_edit=="1")
            {
                $(".non_edit").attr("disabled", "disabled");
                $(".btn_submit").attr("disabled", "disabled");
            }
            
        });
    </script>
@stop