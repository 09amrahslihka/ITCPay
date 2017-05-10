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
        var addFundsUrl = "{{ URL::route('admin_users_manage_add_funds') }}";
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
                    <h3 class="box-title">Manage User</h3>
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
                                    {{ date('d M Y', strtotime($profile->dob)) }}
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
                                            <div class="form-group margin-bot-15 clearfix hide-able" id="verifyEmailDiv" @if(!$user->active) style="display: block;" @else style="display:none;" @endif>
                                                <input type="button" value="Verify user's email" class="next btn btn-primary btn-block btn-flat btn-radius" id="verifyUserEmailBtn" name="verifyUserEmailBtn" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group margin-bot-15 clearfix hide-able" id="verifyAccountDiv"  @if($user->active && !$user->verify) style="display: block;" @else style="display:none;" @endif>
                                                <input type="button" value="Verify user's account" class="next btn btn-primary btn-block btn-flat btn-radius" id="verifyUserAccountBtn" name="verifyUserAccountBtn" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group margin-bot-15 clearfix active-show hide-able" id="authorizationPasswordDiv" @if($user->active) style="display: block;" @else style="display:none;" @endif>
                                                <input type="button" value="Show authorization password" class="next btn btn-primary btn-block btn-flat btn-radius" data-toggle="modal" data-target="#authorizationPasswordModal" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group margin-bot-15 clearfix active-show hide-able" id="addFundsDiv" @if($user->active) style="display: block;" @else style="display:none;" @endif>
                                                <input type="button" value="Add funds" class="next btn btn-primary btn-block btn-flat btn-radius" data-toggle="modal" data-target="#addFundsModal" />
                                            </div>
                                        </div>
                                        @if($cardInfoSubmitted)
                                            <div class="form-group margin-bot-15 clearfix active-show hide-able" id="cardAuthInfoDiv" @if($user->active) style="display: block;" @else style="display:none;" @endif>
                                                <a href="{{ URL::route('admin_users_manage_users_cards', ['email' => $user->email]) }}" class="next btn btn-primary btn-block btn-flat btn-radius">Card authentication information and documents</a>
                                            </div>
                                        @endif
                                        @if(($user->account_type == 'personal' || $user->account_type == 'business') && $personalInfoSubmitted)
                                            <div class="form-group margin-bot-15 clearfix active-show hide-able" id="personalVerificationInfoDiv" @if($user->active) style="display: block;" @else style="display:none;" @endif>
                                                <a href="{{ URL::route('admin_users_manage_users_personal_verification_information_and_documents', ['email' => $user->email]) }}" class="next btn btn-info pull-right btn-primary btn-block btn-flat">Personal verification information and documents</a>
                                            </div>
                                        @endif
                                        @if($user->account_type == 'business' && $businessInfoSubmitted)
                                            <div class="form-group margin-bot-15 clearfix active-show hide-able" id="businessVerificationInfoDiv" @if($user->active) style="display: block;" @else style="display:none;" @endif>
                                                <a href="{{ URL::route('admin_users_manage_users_business_verification_information_and_documents', ['email' => $user->email]) }}" class="next btn btn-info pull-right btn-primary btn-block btn-flat">Business verification information and documents</a>
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
@stop
