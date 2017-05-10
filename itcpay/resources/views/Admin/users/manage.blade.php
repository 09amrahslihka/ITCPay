@extends('Admin.dashboard.layouts.master')

@section('content')
    <style>
        .parsley-errors-list>li {
            color:red;
            list-style-type: none;
        }

        .parsley-errors-list {
            padding:0;
        }

        em {
            color:red;
        }
    </style>
    <script>
        var verifyUserEmailUrl = "{{ URL::route('admin_users_manage_verify_user_email') }}";
        var verifyUserAccountUrl = "{{ URL::route('admin_users_manage_verify_user_account') }}";
 	var unverifyUserAccountUrl = "{{ URL::route('admin_users_manage_unverify_user_account') }}";
        var addFundsUrl = "{{ URL::route('admin_users_manage_add_funds') }}";
        var modifyInformationUrl = "{{ URL::route('admin_users_manage_modify_information') }}";
        var generateAuthPasswordUrl = "{{ URL::route('admin_users_manage_generate_auth_password') }}";
        var deleteUserAccountURL = "{{ route('admin_users_delete_user_account') }}";
        var deleteDashRedirectUrl = "{{ URL::route('admin_users_delete_user_account_success_dash_redirect') }}";
        var _token = "{{csrf_token()}}";
    </script>
    <script src="{{ asset('js/admin_users_manage.js') }}"></script>
    <div class="box box-info">
        <div class="col-sm-12">
            <div class="change-form-bg clearfix">
                <div class="message-info clearfix">
                    <h3 class="box-title">Manage Account</h3>
                </div>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(Session::has('message'))
                    <div class="alert alert-success" role="alert">
                        {{Session::get('message')}}
                    </div>
                @endif

                @if(Session::has('emessage'))
                    <div class="alert alert-danger" role="alert">
                        {{Session::get('emessage')}}
                    </div>
                @endif
                <div class="row">
                    <div class="col-sm-8">
                        <table id="" class="table table-bordered table-hover " role="grid" aria-describedby="example2_info">
                            <tr>
                                <td>
                                    <label for="inputEmail3"  class="control-label">First Name</label>
                                </td>
                                <td>
                                    {{ $profile->fname }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="inputEmail3"  class="control-label">Middle Name</label>
                                </td>
                                <td>
                                    {{ $profile->mname }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="inputEmail3"  class="control-label">Last Name</label>
                                </td>
                                <td>
                                    {{ $profile->lname }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="inputEmail3"  class="control-label">Date of birth</label>
                                </td>
                                <td>
                                    {{ (strtotime($profile->dob) ? date('d M Y', strtotime($profile->dob)) : '') }}
                                </td>
                            </tr>
                            @if($business)
                                <tr>
                                    <td>
                                        <label for="inputEmail3"  class="control-label">Company name</label>
                                    </td>
                                    <td>
                                        {{ $business->name }}
                                    </td>
                                </tr>
                            @endif

                                <tr>
                                    <td>
                                        <label for="inputEmail3"  class="control-label">Account status</label>
                                    </td>
                                    <td>
                                        @if($user->active == 1)
                                            <span style="color: green;">Verified </span>
                                        @else
                                            <span style="color: red;">Unverified </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="inputEmail3"  class="control-label">Identity verification status</label>
                                    </td>
                                    <td>
                                        @if($business)
                                        @if($personalInfoSubmitted == 1 && $businessInfoSubmitted == 1)
                                            <span style="color: green;">Verified </span>
                                        @else
                                            <span style="color: red;">Unverified </span>
                                        @endif
                                        @else
                                        @if($personalInfoSubmitted == 1)
                                            <span style="color: green;">Verified </span>
                                        @else
                                            <span style="color: red;">Unverified </span>
                                        @endif
                                        @endif
                                    </td>
                                </tr>
                        </table>
                    </div>
                    <div class="col-sm-4">
                        <input type="hidden" name="verifyEmailToken" value="{{ csrf_token() }}">
                        <input type="hidden" name="verifyAccountToken" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="email-form clearfix">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group clearfix">
                                                <label for="email" class="block"></label>
                                                <input type="text" name="emailTxt" id="emailTxt" class="form-control" value="{{ $user->email }}" readonly="readonly"/>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group margin-bot-15 clearfix hide-able" id="modifyInformationDiv">
                                                <input type="button" value="Modify information" class="next btn btn-primary btn-block btn-flat btn-radius" id="modifyInformationBtn" name="modifyInformationBtn" data-toggle="modal" data-target="#modifyInformationModal" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group margin-bot-15 clearfix hide-able" id="verifyEmailDiv" @if(!$user->active) style="display: block;" @else style="display:none;" @endif>
                                                <input type="button" value="Verify user's email" class="next btn btn-primary btn-block btn-flat btn-radius" id="verifyUserEmailBtn" name="verifyUserEmailBtn" />
                                            </div>
                                        </div>
                       {{--<div class="col-md-12">
                                            <div class="form-group margin-bot-15 clearfix hide-able" id="verifyAccountDiv"  @if($user->active && $user->verify) style="display: block;" @else style="display:none;" @endif>
                                                <input type="button" value="Undo account verification" class="next btn btn-primary btn-block btn-flat btn-radius" id="unverifyUserAccountBtn" name="unverifyUserAccountBtn" />
                                            </div>
              
                                        </div>--}}
                                        {{--<div class="col-md-12">--}}
                                            {{--<div class="form-group margin-bot-15 clearfix active-show hide-able" id="authorizationPasswordDiv" @if($user->active) style="display: block;" @else style="display:none;" @endif>--}}
                                                {{--<input type="button" value="Show authorization password" class="next btn btn-primary btn-block btn-flat btn-radius" data-toggle="modal" data-target="#authorizationPasswordModal" />--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        <div class="col-md-12">
                                            <div class="form-group margin-bot-15 clearfix active-show hide-able" id="addFundsDiv" @if($user->active) style="display: block;" @else style="display:none;" @endif>
                                                <input type="button" value="Add funds" class="next btn btn-primary btn-block btn-flat btn-radius" data-toggle="modal" data-target="#addFundsModal" />
                                            </div>
                                        </div>
                                        @if(($cardDetail))                                        
                                            <div class="col-md-12">
                                                <div class="form-group margin-bot-15 clearfix active-show hide-able" id="cardAuthInfoDiv" @if($user->active) style="display: block;" @else style="display:none;" @endif>
                                                    <a href="{{ URL::route('admin_users_manage_users_cards', ['email' => $user->email]) }}" class="next btn btn-primary btn-block btn-flat btn-radius">Card authentication information and documents</a>
                                                </div>
                                            </div>
                                        @endif    
                                        
                                        @if(($user->account_type == 'personal') && $personalInfoSubmitted)
                                            <div class="form-group margin-bot-15 clearfix active-show hide-able" id="personalVerificationInfoDiv" @if($user->active) style="display: block;" @else style="display:none;" @endif>
                                                <a href="{{ URL::route('admin_users_manage_users_personal_verification_information_and_documents', ['email' => $user->email]) }}" class="next btn btn-info pull-right btn-primary btn-block btn-flat">Personal verification information and documents</a>
                                            </div>
                                        @endif

                                        @if($user->account_type == 'business' && ($businessInfoSubmitted || $personalInfoSubmitted))

                                            <div class="form-group margin-bot-15 clearfix active-show hide-able" id="businessVerificationInfoDiv" @if($user->active) style="display: block;" @else style="display:none;" @endif>
                                                <a href="{{ URL::route('admin_users_manage_users_business_verification_information_and_documents', ['email' => $user->email]) }}" class="next btn btn-info pull-right btn-primary btn-block btn-flat">Personal/Business verification information and documents</a>
                                            </div>
                                        @endif
                                        <div class="col-md-12">
                                            <div class="form-group margin-bot-15 clearfix active-show hide-able" id="deleteAccountDiv" data-user-id="{{ $user->id }}">
                                                <input type="button" value="Delete account" class="next btn btn-danger btn-block btn-flat btn-radius" data-toggle="modal" />
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>



                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="authorizationPasswordModal" tabindex="-1" role="dialog" aria-labelledby="goToUserAccountByEmailLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="goToUserAccountByEmailLabel">Authorization Password</h4>
                </div>
                <div class="modal-body">
                    <p class="text text-danger hide"></p>
                    <div class="form-group has-feedback">
                        <label for="go-to-email">Authorization Password<em>*</em>:</label>
                        <input id="authorizationPasswordTxt" class="form-control" type="text" placeholder="" name="authorizationPasswordTxt" readonly="readonly" value="{{ $user->authorization_password }}" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-secondary btn-primary" id="regenerateAuthPasswordBtn">Generate</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addFundsModal" tabindex="-1" role="dialog" aria-labelledby="addFundsModalLabel" aria-hidden="true">
        <form id="addFundsFrm" method="post" onsubmit="return false;">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="goToUserAccountByEmailLabel">Add Funds to User's Account</h4>
                    </div>
                    <div class="modal-body">
                        <p class="text text-danger hide"></p>
                        <div class="form-group has-feedback">
                            <label for="amountTxt">Amount(in USD)<em>*</em>:</label>
                            <input id="amountTxt" class="form-control" type="text" placeholder="Amount(in USD)" name="amountTxt" data-parsley-required="true" data-parsley-required-message="Amount is required" data-parsley-numeric="true" data-parsley-numeric-message="Only numeric value allowed" data-parsley-min="1" data-parsley-min-message="Minimum $1 required." />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-danger" data-dismiss="modal" id="addFundsCancelBtn">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="addFundsBtn">Add</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="modifyInformationModal" tabindex="-1" role="dialog" aria-labelledby="addFundsModalLabel" aria-hidden="true">
        <form id="modifyInformationFrm" method="post" onsubmit="return false;">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="this.form.reset()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="goToUserAccountByEmailLabel">Modify User Information</h4>
                    </div>
                    <div class="modal-body">
                        <p class="text text-danger hide"></p>
                        <div class="form-group has-feedback">
                            <label for="newEmailTxt">Email<em>*</em>:</label>
                            <input id="newEmailTxt" class="form-control" type="text" placeholder="Email"
                                name="emailTxt"
                                data-parsley-required="true" data-parsley-required-message="Email is required"
                                value="{{ $user->email }}"/>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="firstNameTxt">First Name<em>*</em>:</label>
                            <input id="firstNameTxt" class="form-control" type="text" placeholder="First Name"
                                name="firstNameTxt"
                                data-parsley-required="true" data-parsley-required-message="First Name is required"
                                value="{{ $profile->fname }}"/>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="middleNameTxt">Middle Name:</label>
                            <input id="middleNameTxt" class="form-control" type="text" placeholder="Middle Name"
                                name="middleNameTxt"
                                value="{{ $profile->mname }}"/>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="lastNameTxt">Last Name<em>*</em>:</label>
                            <input id="lastNameTxt" class="form-control" type="text" placeholder="Last Name"
                                name="lastNameTxt"
                                data-parsley-required="true" data-parsley-required-message="Last Name is required"
                                value="{{ $profile->lname }}"/>
                        </div>

                        <div class="form-group has-feedback">
                            <label for="addressOneTxt">Address Line 1<em>*</em>:</label>
                            <input id="addressOneTxt" class="form-control" type="text" placeholder="Address Line 1"
                                name="addressOneTxt"
                                data-parsley-required="true" data-parsley-required-message="Address Line 1 is required"
                                value="{{ $profile->address_one }}"/>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="addressTwoTxt">Address Line 2:</label>
                            <input id="addressTwoTxt" class="form-control" type="text" placeholder="Address Line 2"
                                name="addressTwoTxt"
                                value="{{ $profile->address_two }}"/>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="countrySelect">Country<em>*</em>:</label>
                            <select name="countrySelect" class="form-control" id="countrySelect"
                                data-parsley-required="true" data-parsley-required-message="Country is required">
                                @foreach ($countries as $country)
                                    <option value="{{ $country }}" @if($country == $profile->country) selected @endif>{{ $country }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="cityTxt">City<em>*</em>:</label>
                            <input id="cityTxt" class="form-control" type="text" placeholder="City"
                                name="cityTxt"
                                data-parsley-required="true" data-parsley-required-message="City is required"
                                value="{{ $profile->city }}"/>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="stateTxt">State:</label>
                            <input id="stateTxt" class="form-control" type="text" placeholder="State"
                                name="stateTxt"
                                value="{{ $profile->state }}"/>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="postalTxt">Postal code:</label>
                            <input id="postalTxt" class="form-control" type="text" placeholder="Postal code"
                                name="postalTxt"
                                value="{{ $profile->postal }}"/>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="postalTxt">Date of birth<em>*</em>:</label>
                            <div class='row'>
                                <div class='col-md-4'>
                                    <div class="form-group has-feedback">
                                        {{ Form::select('day', $days, date_parse_from_format('m/d/Y', $profile->dob)['day'], array("optional" => "Date", "class" => "form-control", "required", 'id' => 'daySelect')) }}
                                    </div>
                                </div>
                                <div class='col-md-4' style="    padding: 0px;">
                                    <div class="form-group has-feedback">
                                        {{ Form::selectMonth('month', date_parse_from_format('m/d/Y', $profile->dob)['month'], array("class"=>"form-control", "required", 'id' => 'monthSelect')) }}
                                    </div>
                                </div>
                                <div class='col-md-4'>
                                    <div class="form-group has-feedback">
                                        {{ Form::selectRange('year', date('Y'), 1900, date_parse_from_format('m/d/Y', $profile->dob)['year'], array("class" => "form-control", "required", 'id' => 'yearSelect')) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="countrySelect">Nationality<em>*</em>:</label>
                            <select name="nationalitySelect" class="form-control"
                                data-parsley-required="true" data-parsley-required-message="Country is required" id="nationalitySelect">
                                @foreach ($nationalities as $nationality)
                                    <option value="{{ $nationality }}" @if($nationality == $profile->nationality) selected @endif>{{ $nationality }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if ($user->account_type == 'business')
                            <hr>
                            <div class="form-group has-feedback">
                                <label for="businessNameTxt">Business Name<em>*</em>:</label>
                                <input id="businessNameTxt" class="form-control" type="text" placeholder="Business Name"
                                    name="businessNameTxt"
                                    data-parsley-required="true" data-parsley-required-message="Business Name is required"
                                    value="{{ $business->name }}"/>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="businessAddressOneTxt">Business Address Line 1<em>*</em>:</label>
                                <input id="businessAddressOneTxt" class="form-control" type="text" placeholder="Business Address Line 1"
                                    name="businessAddressOneTxt"
                                    data-parsley-required="true" data-parsley-required-message="Business Address Line 1 is required"
                                    value="{{ $business->address_one }}"/>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="businessAddressTwoTxt">Business Address Line 2:</label>
                                <input id="businessAddressTwoTxt" class="form-control" type="text" placeholder="Business Address Line 2"
                                    name="businessAddressTwoTxt"
                                    value="{{ $business->address_two }}"/>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="businessCountrySelect">Country<em>*</em>:</label>
                                <select name="businessCountrySelect" class="form-control" id="businessCountrySelect"
                                        data-parsley-required="true" data-parsley-required-message="Country is required">
                                    @foreach ($countries as $country)
                                        <option value="{{ $country }}" @if($country == $business->country) selected @endif>{{ $country }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="businessCityTxt">City<em>*</em>:</label>
                                <input id="businessCityTxt" class="form-control" type="text" placeholder="City"
                                    name="businessCityTxt"
                                    data-parsley-required="true" data-parsley-required-message="City is required"
                                    value="{{ $business->city }}"/>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="businessStateTxt">State:</label>
                                <input id="businessStateTxt" class="form-control" type="text" placeholder="State"
                                    name="businessStateTxt"
                                    value="{{ $business->state }}"/>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="businessPostalTxt">Postal code:</label>
                                <input id="businessPostalTxt" class="form-control" type="text" placeholder="Postal code"
                                    name="businessPostalTxt"
                                    value="{{ $business->postal }}"/>
                            </div>
                        @endif
						
                    </div>
                    <div class="modal-footer">
					@if ($user->tmp_email != '')
						<span style="float:left;">Note : Email will be updated after user's verification.</span></br>
						@endif
                        <button type="button" class="btn btn-secondary btn-danger" data-dismiss="modal" id="modifyInformationCancelBtn" onClick="this.form.reset()">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="modifyInformationSubmitBtn">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
