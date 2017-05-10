@extends('layouts.master')
@section('title', 'Sign up')
@section('content')
    <link rel="stylesheet" href="{{asset('js/jquery-ui-1.12.0.custom/jquery-ui.css')}}">
    <script src="{{ asset("js/jquery-ui-1.12.0.custom/jquery-ui.js") }}"></script>
<div class="container-fluid hold-transition register-page">
    <div class="register-box customRegisterBox">
        <div class="register-logo">
           <a href="{{URL::to('/')}}"><img src="{{URL::asset(getLogo())}}"/></a>
        </div>
        <div class="register-box-body">
            @if($type=="personal")
                <p class="login-box-msg" style="font-size: 30px;">Sign up for a personal account</p>
            @elseif($type=="business")
                <p class="login-box-msg" style="font-size: 30px;">Sign up for a business account</p>
            @endif
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach               
                    </ul>
                </div>
            @endif

            @if($type=="personal")
                <form class="demo-form" name="myform" action="{{action('Registration\RegisterController@doRegisterPersonal')}}" method="POST">
            @elseif($type=="business")
                <form class="demo-form" name="myform" action="{{action('Registration\RegisterController@doRegisterBusiness')}}" method="POST">
            @endif
            <div class="form-group form-section">
				<div class="col-sm-offset-3">
					<p>Already have an account? <a href="{{URL::to('/login')}}">Click here to Log in.</a></p>
                    <p  class="subheadmain">Fields marked with <span style="color:red">*</span> are mandatory</p>
                    <h2>Your Account Information</h2>
                </div>
                
                <div class="form-group has-feedback row">
					<label class="col-sm-3 control-label">Email<sup>*</sup></label>
                   <div class="col-sm-9"> <input type="email" id="Email" class="form-control" name="Email" value="{{ old('Email') }}" required=""><span class="glyphicon glyphicon-envelope form-control-feedback"></span></div>
                </div>
                <div class="form-group has-feedback row">
					<label class="col-sm-3 control-label">Password<sup>*</sup></label>
                    <div class="col-sm-9">
                        <input id="passwordi" class="form-control" title="<h1>Your password must contain</h1><ul><li>At least 8 characters</li><li>At least 1 letter</li><li> At least 1 number/special character.</li></ul>" type="password" name="Password" required="" value="{{ old('Password') }}"><span class="glyphicon glyphicon-lock form-control-feedback"></span></div>
                </div>
               
                <div class="form-group has-feedback row">
					<label class="col-sm-3 control-label">Re-enter Password<sup>*</sup> </label>
                    <div class="col-sm-9"> <input id="confirmpasss" type="password" class="form-control" title="<h1>Your password must contain</h1><ul><li>At least 8 characters</li><li>At least 1 letter</li><li> At least 1 number/special character.</li></ul>" data-parsley-equalto="#passwordi" data-parsley-equalto-message="Password does not match" required=""  value="{{ old('Password') }}" name="PasswordAgain" >
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span></div>
                </div>
                
                <div class="form-group has-feedback row">
					<label class="col-sm-3 control-label">{{($type=="business")?'Phone/mobile':'Mobile number'}}<sup>*</sup></label>
                    <div class="col-sm-9">
                        <div class='row'>
                            <div class='col-sm-6'>
                                <div class="form-group has-feedback signup-input">
        							 <select name="countryCode" id="countryCode" class="form-control" required>
                                        <?php
                                        $optionString = "";
                                        foreach($countryCodes as $key => $value) {
                                            if(isset($value['value']))
                                            {
                                                $sel = '';
                                                if ($key == old('code_phone')) $sel = ' selected="selected"';
                                                $optionString .= '<option data-countryCode="' . $key . '" value="' . $value['value'] . '" ' . $sel . '>' . $value['title'] . '</option>';
                                            }
                                        }
                                        echo $optionString;
                                        ?>
                                    </select>
                                    <input type="hidden" name="code_phone" value="" id="code_phone">
                                    <span class=" fa fa-mobile form-control-feedback" style="margin-right: 3px"></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group has-feedback">
        						 <input type="number" id="mobile_number" class="form-control" placeholder="Mobile number" name="PhoneNo" value="{{ old('PhoneNo') }}" required="">
                                    <span class=" fa fa-mobile form-control-feedback"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
 
            <div class="form-group has-feedback row">
				<label class="col-sm-3 control-label">Time Zone<sup>*</sup></label>
               <div class="col-sm-9"> {{ Form::select('TimeZone', $timeZones, $TimeZone, array("class" => "form-control", "required")) }}
                <span class=" fa fa-clock-o form-control-feedback" style="margin-right: 3px"></span></div>
            </div>                        
 

            @if($type=="business")
            <div class="">
                <div class="col-sm-offset-3"><h2>Your Business Name</h2>
                <p class="subhead">As it appears on your business bank account and business documents</p></div>
                <div class="form-group has-feedback row">
					<label class="col-sm-3 control-label">Business name<sup>*</sup> </label>
                 <div class="col-sm-9">   <input type="text" class="form-control" placeholder="" name="bName" value="{{ old('bName') }}" required=""><span class="glyphicon glyphicon-user form-control-feedback"></span></div>
                </div>                  
            </div>
            <div class="">
               <div class="col-sm-offset-3"> <h2>Your Business Address</h2>
                <p class="subhead">As it appears on your business address proof documents.</p></div>
                <div class="form-group has-feedback row">
						<label class="col-sm-3 control-label">Country<sup>*</sup></label>
                   <div class="col-sm-9"> {{ Form::select('bCountry', $country, $bCountry, array("class" => "form-control","onchange" => "showSsn(this.value,'$type')",  "required" => "")) }}
                    <span class=" fa fa-globe form-control-feedback" style="margin-right: 3px" ></span></div>
                </div>
                <div class="form-group has-feedback row">
					<label class="col-sm-3 control-label">Address line 1<sup>*</sup></label>
                   <div class="col-sm-9">  <input type="text" class="form-control" name="bAddress1" value="{{ old('bAddress1') }}" required="">
                    <span class=" fa fa-map-marker form-control-feedback"></span></div>
                </div>
                <div class="form-group has-feedback row">
					<label class="col-sm-3 control-label">Address line 2</label>
                   <div class="col-sm-9">   
                    <input type="text" class="form-control"  name="bAddress2" value="{{ old('bAddress2') }}" placeholder="if applicable" >
                    <span class="fa fa-map-marker form-control-feedback"></span></div>
                </div>
                <div class="form-group has-feedback row">
					<label class="col-sm-3 control-label">City<sup>*</sup></label>
                   <div class="col-sm-9"> <input type="text" class="form-control" name="bCity" value="{{ old('bCity') }}" required="">                    
                    <span class="fa fa-map-marker form-control-feedback"></span></div>
                </div>
                <div class="form-group has-feedback row">
					<label class="col-sm-3 control-label"><span class="bstate-sel">State/province</span><sup id="bmdtry"></sup></label>
                   <div class="col-sm-9" id="bStatelist"> <input type="text" class="form-control" name="bState" value="{{ old('bState') }}"><span class="fa fa-location-arrow form-control-feedback"></span></div>
                </div>
                <div class="form-group has-feedback row">
					<label class="col-sm-3 control-label"><span id="postal-code-b">Postal code</span><sup>*</sup></label>
                   <div class="col-sm-9"> <input type="text" class="form-control postal-input" name="bPostal" id="bPostal" value="{{ old('bPostal') }}">
                    <span class="fa fa-envelope-o form-control-feedback"></span></div>
                </div>
            </div>
            @endif
            <div class="">
                <div class="col-sm-offset-3"> <h2>Your Legal Name</h2>
                <p class="subhead">As it appears on your bank account and Photo ID</p></div>
                <div class="form-group has-feedback row">
					<label class="col-sm-3 control-label">First name<sup>*</sup></label>
                     <div class="col-sm-9"><input type="text" class="form-control" name="FirstName" value="{{ old('FirstName') }}" required=""> <span class="glyphicon glyphicon-user form-control-feedback"></span></div>
                </div>
                <div class="form-group has-feedback row">
					<label class="col-sm-3 control-label">Middle name</label>
                   <div class="col-sm-9"> <input type="text" class="form-control" name="MiddleName" value="{{ old('MiddleName') }}" placeholder="if applicable">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span></div>
                </div>
                <div class="form-group has-feedback row">
					<label class="col-sm-3 control-label">Last name<sup>*</sup></label>
                    <div class="col-sm-9"><input type="text" class="form-control" name="LastName" value="{{ old('LastName') }}" required=""> <span class="glyphicon glyphicon-user form-control-feedback"></span></div>
                </div>
            </div>
            <div class="">
				@if($type=="personal")
               <div class="col-sm-offset-3">  <h2>Your Current Address</h2></div>
                @elseif($type=="business")
                <div class="col-sm-offset-3"> <h2>Your Personal Address</h2></div>
                @endif
                <div class="col-sm-offset-3"> <p class="subhead">As it appears on your business address proof documents.</p></div></div>
                <div class="form-group has-feedback row">
					<label class="col-sm-3 control-label">Country<sup>*</sup></label>
                    <div class="col-sm-9"> {{ Form::select('Country', $country, $Country, array("class" => "form-control", "onchange" => "showSsn(this.value,'personal')",  "required" => "")) }}
                    <span class=" fa fa-globe form-control-feedback" style="margin-right: 3px"></span></div>
                </div>
                <div class="form-group has-feedback row">
					<label class="col-sm-3 control-label">Address line 1<sup>*</sup></label>
                    <div class="col-sm-9"><input type="text" class="form-control" name="Address1" value="{{ old('Address1') }}" required="">
                    <span class=" fa fa-map-marker form-control-feedback"></span></div>
                </div>
                <div class="form-group has-feedback row">
					<label class="col-sm-3 control-label">Address line 2</label>
                    <div class="col-sm-9"><input type="text" class="form-control" name="Address2" value="{{ old('Address2') }}" placeholder="if applicable">
                    <span class=" fa fa-map-marker form-control-feedback"></span></div>
                </div>
                <div class="form-group has-feedback row">
					<label class="col-sm-3 control-label">City<sup>*</sup></label>
                   <div class="col-sm-9"> <input type="text" class="form-control" name="City" value="{{ old('City') }}" required="">
                    <span class=" fa fa-map-marker form-control-feedback"></span></div>
                </div>
                <div class="form-group has-feedback row">
					<label class="col-sm-3 control-label"><span class="state-sel">State/province</span><sup id="mdtry"></sup></label>
                   <div class="col-sm-9" id="Statelist"> <input type="text" class="form-control" name="State" value="{{ old('State') }}">
                    <span class=" fa fa-location-arrow form-control-feedback"></span></div>
                </div>
                <div class="form-group has-feedback row">
					<label class="col-sm-3 control-label"><span id="postal-code">Postal code</span><sup>*</sup></label>
                   <div class="col-sm-9">
                       <input type="text" class="form-control postal-input" name="Postal" value="{{ old('Postal') }}" required="">
                      <span class=" fa fa-envelope-o form-control-feedback"></span></div>
                </div>
            
            <div class=""> 
                <div class="col-sm-offset-3">  <h2>Your Personal Information</h2>
                <p class="subhead">Date of birth As it appears on your photo ID</p></div>
			</div>	
            <div class=""> 
                <div class="form-group has-feedback row">
                  <label class="col-sm-3 control-label">Date of birth<sup>*</sup></label>
                  <div class="col-sm-9">
                      <div class='row'>
                          <div class='col-sm-4'>
                              <!--<label>Day</label>-->
                              <div class="form-group has-feedback signup-input">
                                  {{ Form::select('day', $days, old('day'), array("optional" => "Date", "class" => "form-control", "required")) }}
                              </div>
                          </div>
                          <div class='col-sm-4'>
                              <!--<label>Month</label>-->
                              <div class="form-group has-feedback signup-input">
                                  {{ Form::selectMonth('month', old('month'), array("id"=>"months", "class"=>"form-control", "required")) }}
                              </div>
                          </div>
                          <div class='col-sm-4'>
                              <!--<label>Year</label>-->
                              <div class="form-group has-feedback">
                                  {{ Form::selectRange('year', date('Y'), 1900, old('year'), array("class" => "form-control", "required")) }}
                              </div>

                          </div>
                      </div>
                  </div>
                </div>
            </div>   


            <div class="form-group has-feedback row">
            	<label class="col-sm-3 control-label">Nationality<sup>*</sup></label>
                <div class="col-sm-9"> {{ Form::select('Nationality', $nationality, $Nationality, array("class" => "form-control", "required")) }}</div>
            </div>
			<div class="col-sm-offset-3"><p>Human Verification Challange.</p></div>
                
			<div class="col-sm-offset-3">
                <div class="form-group has-feedback captcha" style="text-align: center;">
                {!! captcha_image_html('ExampleCaptcha') !!}
                </div>
            </div>
            <div class="form-group has-feedback row">
              <label class="col-sm-3 control-label padding-left-0">Enter captcha code here<sup>*</sup></label>
                <!--<input type="text" class="form-control" placeholder="Enter captcha code here*" name="captcha" /> -->
               <div class="col-sm-9"> <input type="text" class="form-control" placeholder="" name="captcha" id="captcha"></div>
            </div>
                <p class="text-center  col-sm-offset-5" style="margin: 10px 30px 0px 0px;">I agree to the {{ getSiteName() }} <a target="_blank" href="{{URL::to('/pages/terms')}}">Terms of Service</a>, <a  target="_blank" href="{{URL::to('/pages/legal-agreements')}}">Legal Agreements</a> and <a  target="_blank" href="{{URL::to('/pages/privacy-policy')}}">Privacy Policy</a>.</p>
            <div class="form-navigation  col-sm-offset-5">
                <button type="button" class="next btn btn-info pull-right btn-primary btn-block btn-flat">Continue</button>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="submit" name="submit" value="Sign Up" style="font-weight: 500; font-size: 16px;width: 120px; margin-top: 15px; margin-bottom: 5px;" class=" btn btn-primary btn-block btn-flat">
                <span class="clearfix"></span>
            </div>
        </form>
        </div>
    </div>
</div>

<script type="text/javascript">
function resetValues()
{ 
//	var passwordi = document.getElementById("passwordi");
//	var Email = document.getElementById("Email");
//	passwordi.value = "";
	//Email.value = "";
}
setTimeout(resetValues(), 2000);
function showSsn(countryCode,type)
{
    if($.trim(countryCode) == "India")
    {
        if(type=="personal")
            $("#postal-code").text('Pin code');
        else
            $("#postal-code-b").text('Pin code');
            $('.postal-input').attr('maxlength','6');
     
    }else if($.trim(countryCode) == "United States"){
       
        if(type=="personal")    
            $("#postal-code").text('Zip');  
        else
            $("#postal-code-b").text('Zip');

        $('.postal-input').attr('maxlength','5')
    }else{
        //$("#postal-code").text('Postal code');   

        if(type=="personal")    
            $("#postal-code").text('Postal code');  
        else
            $("#postal-code-b").text('Postal code');
         
        $('.postal-input').attr('maxlength','')
    }

    $.ajax({
            url: "{{ URL::to('/getstatelist')}}/" + countryCode+'/'+type,
            type: "get",
            async: false,
            dataType:"json",
            success: function(data) {
               if(type=="personal")
                    $('#Statelist').html(data.result);
                else
                    $('#bStatelist').html(data.result);
                
                if(data.isSelect==false){
                    if(type=="personal") {
                        $('.state-sel').html('State/province');
                        $('#mdtry').text('');
                    }
                    else {
                        $('.bstate-sel').html('State/province');
                         $('#bmdtry').text('');
                    }
                }else{
                    if(type=="personal") 
                        var isbu="";
                    else
                        var isbu="b";
                    $('.'+isbu+'state-sel').html('State');
                    $('#'+isbu+'mdtry').text('*');
                } 

            }
    });
}
$(document).ready(function () {

    $("#countryCode").change(function () {
        $('#code_phone').val($("#countryCode option:selected").data('countrycode'));
    });


    var pCountry = $("select[name = 'Country']").val();
    if(pCountry=="") {
        var pCountry = '<?php echo $bCountry; ?>';
    }
    var bCountry = $("select[name = 'bCountry']").val();
    if(bCountry=="") {
        var bCountry = '<?php echo $bCountry; ?>';
    }
    showSsn(pCountry, 'personal');
    <?php if($type=="business") { ?>
    showSsn(bCountry, 'business');
    <?php } ?>

        $( "#datepicker" ).datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            yearRange: '1900:'+(new Date).getFullYear(),
            onChangeMonthYear:function(y, m, i){
                var d = i.selectedDay + '';
                if (d.length < 2)
                    d = '0' + d;
                var m = m + '';
                if (m.length < 2)
                    m = '0' + m;
                $(this).datepicker( "setDate", d + '-' + m + '-' + y );
            }
        });


    $('select[name=day]').prepend($('<option>', {
        value: "",
        text:  'Day'
    }));
    <?php if (!old('day')):?>
        $('select[name=day]').val("");
    <?php endif; ?>
    $('select[name=month]').prepend($('<option>', {
        value: "",
        text:  'Month'
    }));
    <?php if (!old('month')):?>
        $('select[name=month]').val("");
    <?php endif; ?>
    $('select[name=year]').prepend($('<option>', {
        value: "",
        text:  'Year'
    }));
    <?php if (!old('year')):?>
        $('select[name=year]').val("");
    <?php endif; ?>

	var password = document.getElementById("passwordi")
	  , confirm_password = document.getElementById("confirmpasss");

	function validatePassword(){
		
		if(password.value != confirm_password.value) {
			confirm_password.setCustomValidity("Passwords does not match");
		} else {
			confirm_password.setCustomValidity('');
		}
	}

	password.onchange = validatePassword;
	confirm_password.onkeyup = validatePassword;

	var mobile_number = document.getElementById("mobile_number");

	// function validateMobileNumber(){
	// 	var phoneRe = /^[0-9]+$/;
	// 	if(mobile_number.value.match(phoneRe)) {
	// 		mobile_number.setCustomValidity('');
	// 	} else {
	// 		mobile_number.setCustomValidity('Mobile number must be numeric');
	// 	}
	// }
	// mobile_number.onchange = validateMobileNumber;

function validateMobileNumberOfDigit(){
    var phoneRe = /^[0-9]+$/;
    
    if(!mobile_number.value.match(phoneRe))
    {
        mobile_number.setCustomValidity('Mobile number must be numeric'); 
    }
    else if(!(mobile_number.value.toString().length>=4 &&  mobile_number.value.toString().length<=15)) 
    {
        mobile_number.setCustomValidity('Mobile number should be between 4 to 15 digits');
    } 
    else 
    {
      mobile_number.setCustomValidity('');
    }
  }
  mobile_number.onkeyup=validateMobileNumberOfDigit;

});
</script>
@stop
