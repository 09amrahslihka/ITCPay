@extends('User.dashboard.layouts.master')
@section('title', 'My Account')
@section('content')
    <div class="box box-info">
		<div class="box-header dashboard-header">
			<h3 class="box-title dashboard-heading">My Account</h3>
		</div>

		<div class="account-tab clearfix">
			<div class="col-md-12">
                <?php $active = 1; ?>
                @if (Session::has('message'))
                    <div class="alert alert-success">
                        <ul>
                            <li>{{  Session::get('message') }}</li>
                        </ul>
                    </div>
                @endif
                @if(count($errors) > 0)
                    <?php $active = 3; ?>
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
				<ul role="tablist" class="nav nav-tabs">
					<li <?php if($active==1) { ?> class="active" <?php } ?>role="presentation"><a data-toggle="tab" role="tab" aria-controls="home" href="#account_info"><b><i class="fa fa-info"></i> Account Information</b></a></li>
					<li  role="presentation"><a data-toggle="tab" role="tab" aria-controls="profile" href="#personal_info"><b><i class="fa fa-user-plus"></i> Personal Information</b></a></li>
					<li <?php if($active==3) { ?> class="active" <?php } ?> role="presentation"><a data-toggle="tab" role="tab" aria-controls="profile" href="#upgrade_account"><b><i class="fa fa-mail-forward"></i> Upgrade Account</b></a></li>

					@if(!auth()->user()->verify)
					 @if($verification[0]->value==1)
						<li role="presentation"><a  href="{{URL::to('/verifications?type=personal')}}"><b><i class="fa fa-gear"></i> Verifications</b></a></li>
						@endif
					@endif

				</ul>
			</div>
			<div class="col-md-12">
				<div class="row">
					<div class="tab-content" id = 'my_acc'>
						<div id="account_info" class="tab-pane  <?php if($active==1) { ?> active <?php } ?>" role="tabpanel">
							<div class="table-scroll">	
								<table class="table table-hover  ">
									<tbody>
									<tr>
										<td> <h4 style="display: inline-block;">Email</h4></td>
										<td><h5 style="display: inline-block;margin-left: 20px;">{{$email}}</h5></td>
										<td> <a  href="{{URL::to('/dashboard/authorization/email/')}}" class="btn btn-primary" data-toggle="modal" data-target="#authorizationPasswordModal" data-dismiss="modal"><i class="fa fa-mail-forward"></i>Change</a></td>
									</tr>
									<tr>
										<td><h4 style="display: inline-block;">Password</h4></td>
										<td><h5 style="display: inline-block;margin-left: 20px;">***********</h5></td>
										<td> <button type="button" onclick="location.href ='{{URL::to('/dashboard/changePassword')}}'" class="btn btn-primary" ><i class="fa fa-mail-forward"></i> Change</button></td>

									</tr>
									<tr>
										<td> @if($acc=="personal")<h4 style="display: inline-block;">Mobile Number</h4>
											@elseif($acc=="business")
												<h4 style="display: inline-block;">Phone/Mobile</h4>
											@endif</td>
										<td><h5 style="display: inline-block;margin-left: 20px;"><?php if($mobile!="") { ?> +{{$mobile}}<?php } ?></h5></td>
										<td><button type="button" onclick="location.href ='{{URL::to('/dashboard/changePhone')}}'" class="btn btn-primary"><i class="fa fa-mail-forward"></i> Change</button></td>
									</tr>
									<tr>
                                        <?php
                                        $timeZoneValue='';
                                        if($timezone!="")
                                        {
                                            $timeZoneData    = getTimeZones();
                                            $timeZoneValue   = $timeZoneData[$timezone];
                                        }
                                        ?>
                                        <td><h4 style="display: inline-block;">Time zone</h4></td>
										<td><h5 style="display: inline-block;margin-left: 20px;">{{$timezone}} {{$timeZoneValue}}</h5></td>
										<td><button type="button"onclick="location.href ='{{URL::to('/dashboard/changeTimezone')}}'" class="btn btn-primary" ><i class="fa fa-mail-forward"></i> Change</button></td>
									</tr>
									<!-- <tr>
										<td><h4 style="display: inline-block;">Account Type</h4></td>
										<td>@if($acc=="personal")
												<h5 style="display: inline-block;margin-left: 20px;">Personal</h5>
											@elseif($acc=="business")
												<h5 style="display: inline-block;margin-left: 20px;">Business</h5>
											@endif</td>
										<td><button type="button"onclick="location.href ='{{URL::to('/dashboard/upgradeAcc')}}'" class="btn btn-primary" style="width: 100%;">Change</button></td>
									</tr> -->

									</tbody>
								</table>
							</div>
						</div>
							<div id="personal_info" class="tab-pane" role="tabpanel">
								<div class="table-scroll">
									<table class="table table-hover">
										<tbody>
										<tr>
											<td> <h4 style="display: inline-block;">Legal Name</h4></td>
											<td><h5 style="display: inline-block;margin-left: 20px;">{{$name}}</h5></td>
											<td>  <button type="button" data-toggle="modal" data-target="#myModal1" class="btn btn-primary"><i class="fa fa-mail-forward"></i> Change</button> </td>
										</tr>
										<tr>
											<td> <h4 style="display: inline-block;">Current Address</h4></td>
											<td><h5 style="display: inline-block;margin-left: 20px;">
													@if($addresstwo!=""&&$state!=""&&$postal!="")
														{{$addressone}},<br>
														{{$addresstwo}},<br>
														{{$city}},<br>{{$state}},{{$postal}},<br>{{$country}}.

													@elseif($addresstwo==""&&$state==""&&$postal=="")
														{{$addressone}},<br>
														{{$city}},<br>{{$country}}.

													@elseif($state==""&&$postal=="")
														{{$addressone}},<br>
														{{$addresstwo}},<br>
														{{$city}},<br>{{$country}}.

													@elseif($addresstwo==""&&$state=="")
														{{$addressone}},<br>
														{{$city}},{{$postal}},<br>{{$country}}.

													@elseif($addresstwo==""&&$postal=="")
														{{$addressone}},<br>
														{{$city}},<br>{{$state}},<br>{{$country}}.

													@elseif($addresstwo=="")
														{{$addressone}},<br>
														{{$city}},<br>{{$state}},{{$postal}},<br>{{$country}}.

													@elseif($postal=="")
														{{$addressone}},<br>
														{{$addresstwo}},<br>
														{{$city}},<br>{{$state}},<br>{{$country}}.

													@elseif($state=="")
														{{$addressone}},<br>
														{{$addresstwo}},<br>
														{{$city}},{{$postal}},<br>{{$country}}.

													@endif</h5></td>
											<td><button type="button" data-toggle="modal" data-target="#myModal2"  class="btn btn-primary"><i class="fa fa-mail-forward"></i> Change</button> </td>
										</tr>
										<tr>
											<td> <h4 style="display: inline-block;">Nationality</h4></td>
											<td><h5 style="display: inline-block;margin-left: 20px;">{{$nationality}}</h5></td>
											<td> <button type="button" data-toggle="modal" data-target="#myModal4"  class="btn btn-primary"><i class="fa fa-mail-forward"></i> Change</button> </td>
										</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div id="upgrade_account" class="tab-pane  <?php if($active==3) { ?> active <?php } ?>" role="tabpanel">
								<div class="tab-upgrade clearfix">
									<div class="register-box customRegisterBox" style="margin-top:15px;">
									<div class="register-box-body">            
							            <p class="login-box-msg" style="font-size: 30px;">Upgrade Your Account to a Business Account</p>
							             
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
								                        <div class="col-sm-9"> {{ Form::select('bCountry', $countries, $ipCountry, array("class" => "form-control","data-parsley-group" => "block-2","onchange" => "showSsn(this.value,'business')",  "required" => "")) }}
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
								                            <input type="text" class="form-control postal-input" name="bPostal" id="bPostal" value="{{ old('bPostal') }}" required = "">
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
							
							</div>
							<div id="personal_verification" class="tab-pane" role="tabpanel">
								<div class="varification-tab">	
									<a href="{{URL::to('/verify?type=personal')}}" target = "_blank">Click Here</a> To verify Your Account
								</div>
							</div>
						  </div>
				</div>
			</div>
		</div>





<div aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                        <div role="document" class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                                    <h4 id="myModalLabel" class="modal-title">Warning</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Contact our customer support in order to change your email address</p>
                                    </div>
                                <div class="modal-footer">
                                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                                  
                                </div>
                            </div>
                        </div>
                    </div>

  <?php   /* personal info */ ?>

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Change Legal Name</h4>
            </div>
            <div class="modal-body">
                <p>
                    Contact our Customer Support to change your legal name.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Change Address</h4>
            </div>
            <div class="modal-body">
                <p>
                    Contact our Customer Support to change your Address.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Change Date of Birth</h4>
            </div>
            <div class="modal-body">
                <p>
                    Contact our Customer Support to change your date of birth.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Change Nationality</h4>
            </div>
            <div class="modal-body">
                <p>
                    Contact our Customer Support to change your nationality.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

        <div class="modal fade" id="authorizationPasswordModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content"></div>
            </div>
        </div>
<script type="text/javascript">
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
                    if(type=="personal")
                        $('.state-sel').html('State/province');
                    else
                        $('.bstate-sel').html('State/province');
                         $('#bmdtry').text('');
                }else{
                    if(type=="personal")
                    var isbu="";
                    else
                    var isbu="b";
                    $('.'+isbu+'state-sel').html('State');
                    //$('#'+isbu+'mdtry').text('*');
                    $('#'+isbu+'mdtry').text('');
                }

            }
        });
    }
    $(document).ready(function () {
        var bCountry = $("select[name = 'bCountry']").val();
        if(bCountry=="") {
            var bCountry = '<?php echo $ipCountry; ?>';
        }
        showSsn(bCountry, 'business');
    });
</script>
<?php   /* personal info */ ?>

@stop