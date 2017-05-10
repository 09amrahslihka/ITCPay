@extends('User.dashboard.layouts.master')
@section('title', 'Upgrade')
@section('content')
<div class="container-fluid hold-transition register-page" style="margin-top: -55px;">
    <div class="register-box customRegisterBox">         
        <div class="register-box-body">            
            <p class="login-box-msg" style="font-size: 30px;">Upgrade Your Account to a Business Account</p>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach               
                    </ul>
                </div>
            @endif
             <form method="post" class="demo-form"  action="{{action('Dashboard\DashController@upgradeAccount')}}">
            <div class="form-group form-section1">
                <div class="col-sm-offset-3">
                    <p  class="subheadmain">Fields marked with <span style="color:red">*</span> are mandatory</p>                    
                </div>
                
                <div class="">
                    <div class="col-sm-offset-3"><h2>Your Business Name</h2>
                    <p class="subhead">As it appears on your business bank account and business documents</p></div>
                    <div class="form-group has-feedback row">
                        <label class="col-sm-3 control-label">Business name<sup>*</sup> </label>
                     <div class="col-sm-9">   
                         
                        <input type="text" class="form-control" required="" name="bName" value="{{ old('bName') }}" data-parsley-group="block-2">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>

                        @if ($errors->has('bName'))
                            <div class="form-group error">Please enter your Business Name</div>
                        @endif
                    </div>
                    </div>                  
                </div>

                <div class="">

                   <div class="col-sm-offset-3"> <h2>Your Business Address</h2>
                    <p class="subhead">As it appears on your business address proof documents.</p>
                    </div>
                    <div class="form-group has-feedback row">
                        <label class="col-sm-3 control-label">Country<sup>*</sup></label>
                        <div class="col-sm-9"> {{ Form::select('bCountry', $countries, "", array("class" => "form-control","data-parsley-group" => "block-2","onchange" => "showSsn(this.value,'business')",  "required" => "")) }}                    
                            <span class=" fa fa-globe form-control-feedback" style="margin-right: 3px" ></span>
                            @if ($errors->has('bCountry'))
                            <div class="form-group error">Please select a country</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group has-feedback row">
                        <label class="col-sm-3 control-label">Address line 1<sup>*</sup></label>
                        <div class="col-sm-9">  <input type="text" class="form-control" name="bAddress1" value="{{ old('bAddress1') }}" required="">
                            <span class=" fa fa-map-marker form-control-feedback"></span>
                            @if ($errors->has('bAddress1'))
                            <div class="form-group error">Please enter your address</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group has-feedback row">
                        <label class="col-sm-3 control-label">Address line 2</label>
                       <div class="col-sm-9">   
                        <input type="text" class="form-control" name="bAddress2" value="{{ old('bAddress2') }}" placeholder="if applicable" >
                        <span class="fa fa-map-marker form-control-feedback"></span></div>
                    </div>
                    <div class="form-group has-feedback row">
                        <label class="col-sm-3 control-label">City<sup>*</sup></label>
                       <div class="col-sm-9"> 
                            <input type="text" class="form-control" name="bCity" value="{{ old('bCity') }}" required="">
                            <span class="fa fa-map-marker form-control-feedback"></span>
                            @if ($errors->has('bCity'))
                            <div class="form-group error">Please enter your city</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group has-feedback row">
                        <label class="col-sm-3 control-label"><span class="bstate-sel">State/province</span><sup id="bmdtry"></sup></label>
                       <div class="col-sm-9" id="bStatelist"> <input type="text" class="form-control" placeholder="if applicable" name="bState" value="{{ old('bState') }}"><span class="fa fa-location-arrow form-control-feedback"></span></div>
                    </div>
                    <div class="form-group has-feedback row">
                        <label class="col-sm-3 control-label"><span id="postal-code-b">Postal code</span><sup>*</sup></label>
                       <div class="col-sm-9"> 
                            <input type="text" class="form-control postal-input" name="bPostal" id="bPostal" value="{{ old('bPostal') }}">
                            <span class="fa fa-envelope-o form-control-feedback"></span>
                             @if ($errors->has('bPostal'))
                            <div class="form-group error">Please enter your postal code</div>
                            @endif
                        </div>
                    </div>
                </div>
                         
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row" style="float: none;margin: 0 auto;">
                    <div class="col-md-3"></div>
                        <div class="col-md-3">
                            <input value="Back" type="button"  style="font-weight: 500; font-size: 16px;" id='back' class="next btn btn-danger pull-right btn-primary btn-block btn-flat">
                        </div>
                        <div class="col-md-3">
                            <input type="submit" name="Change" style="font-weight: 500; font-size: 16px;" Value="Upgrade"  class="next btn  pull-right btn-primary btn-block btn-flat">
                        </div>
                </div>
                 
            </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
function showSsn(ssnVal,type)
{    
    if($.trim(ssnVal) == "India"){
        if(type=="personal")    
            $("#postal-code").text('Pin');  
        else
            $("#postal-code-b").text('Pin');  
     $('.postal-input').attr('maxlength','6');
     
    }else if($.trim(ssnVal) == "United States"){       
        if(type=="personal")    
            $("#postal-code").text('Zip');  
        else
            $("#postal-code-b").text('Zip');

        $('.postal-input').attr('maxlength','5')
    }else{      

        if(type=="personal")    
            $("#postal-code").text('Postal code');  
        else
            $("#postal-code-b").text('Postal code');
         
        $('.postal-input').attr('maxlength','')
    }
  
    $.ajax({
            url: "{{ URL::to('/getstatelist')}}/" + ssnVal+'/'+type,
            type: "get",
            async: false,
            dataType:"json",
            success: function(data) {   
                if(type=="personal")             
                    $('#Statelist').html(data.result);
                else
                    $('#bStatelist').html(data.result);
                
                if(data.isSelect==false){
                    if(type=="personal")        
                        $('.state-sel').html('State/province (if applicable)');
                    else
                         $('.bstate-sel').html('State/province (if applicable)');
                }else{
                    $('.bstate-sel').html('State');
                    $('#bmdtry').text('*');
                }

            }
    });
}
</script>
@stop