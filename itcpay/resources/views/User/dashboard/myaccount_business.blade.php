@extends('User.dashboard.layouts.master')
@section('title', 'My Account')
@section('content')
<div class="box box-info">
    <div class="box-header dashboard-header">
        <h3 class="box-title dashboard-heading">My Account</h3>
    </div>
    <div class="account-tab clearfix">
        <div class="col-md-12">
            @if (Session::has('message'))
            <div class="alert alert-success">
                <ul>
                    <li>{{  Session::get('message') }}</li>
                </ul>
            </div>
            @endif
            <ul role="tablist" class="nav nav-tabs">
                <li class="active" role="presentation"><a data-toggle="tab" role="tab" aria-controls="home" href="#account_info"><b><i class="fa fa-info"></i> Account Information</b></a></li>
                <li role="presentation"><a data-toggle="tab" role="tab" aria-controls="profile" href="#personal_info"><b><i class="fa fa-user-plus"></i> Personal Information</b></a></li>
                <li role="presentation"><a data-toggle="tab" role="tab" aria-controls="profile" href="#business_info"><b><i class="fa fa-mail-forward"></i> Business Information</b></a></li>

                @if(!auth()->user()->verify)
                 @if($verification[0]->value==1)
                 <li role="presentation"><a  href="{{URL::to('/verifications?type=business')}}"><b><i class="fa fa-gear"></i> Verifications</b></a></li>
                   @endif
                 @endif

            </ul>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="tab-content" id = 'my_acc'>
                    <div id="account_info" class="tab-pane active" role="tabpanel">
                        <div class="table-scroll">
                            <table class="table table-hover  ">
                                <tbody>
                                    <tr>
                                        <td> <h4 style="display: inline-block;">Email</h4></td>
                                        <td><h5 style="display: inline-block;margin-left: 20px;">{{$email}}</h5></td>
                                        <td>
                                            <a  href="{{URL::to('/dashboard/authorization/email/')}}" class="btn btn-primary" data-toggle="modal" data-target="#authorizationPasswordModal" data-dismiss="modal"><i class="fa fa-mail-forward"></i>Change</a>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td><h4 style="display: inline-block;">Password</h4></td>
                                        <td><h5 style="display: inline-block;margin-left: 20px;">***********</h5></td>
                                        <td> <button type="button" onclick="location.href ='{{URL::to('/dashboard/changePassword')}}'" class="btn btn-primary"><i class="fa fa-mail-forward"></i> Change</button></td>

                                    </tr>
                                    <tr>
                                        <td> @if($acc=="personal")<h4 style="display: inline-block;">Mobile Number</h4>
                                            @elseif($acc=="business")
                                            <h4 style="display: inline-block;">Phone/Mobile</h4>
                                            @endif</td>
                                        <td><h5 style="display: inline-block;margin-left: 20px;"><?php if ($mobile != "") { ?> +{{$mobile}}<?php } ?></h5></td>
                                        <td><button type="button" onclick="location.href ='{{URL::to('/dashboard/changePhone')}}'" class="btn btn-primary"><i class="fa fa-mail-forward"></i> Change</button></td>

                                    </tr>
                                    <tr>
                                        <?php
                                        if ($timezone != "") {
                                            $timeZoneData = getTimeZones();
                                            $timeZoneValue = $timeZoneData[$timezone];
                                        }
                                        ?>
                                        <td><h4 style="display: inline-block;">Time zone</h4></td>
                                        <td><h5 style="display: inline-block;margin-left: 20px;">{{$timezone}} {{$timeZoneValue}}</h5></td>
                                        <td><button type="button"onclick="location.href ='{{URL::to('/dashboard/changeTimezone')}}'" class="btn btn-primary"><i class="fa fa-mail-forward"></i> Change</button></td>
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
                        <table class="table table-hover  ">
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
                                    <td><button type="button" data-toggle="modal" data-target="#myModal2" class="btn btn-primary"><i class="fa fa-mail-forward"></i> Change</button> </td>
                                </tr>
                                <tr>
                                    <td> <h4 style="display: inline-block;">Nationality</h4></td>
                                    <td><h5 style="display: inline-block;margin-left: 20px;">{{$nationality}}</h5></td>
                                    <td> <button type="button" data-toggle="modal" data-target="#myModal4"  class="btn btn-primary"><i class="fa fa-mail-forward"></i> Change</button> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="business_info" class="tab-pane" role="tabpanel">
                        <table class="table table-hover  ">
                            <tbody>
                                <tr>
                                    <td> <h4 style="display: inline-block;">Business Name</h4></td>
                                    <td><h5 style="display: inline-block;margin-left: 20px;">{{$bus_name}}</h5></td>
                                    <td><button type="button" data-toggle="modal" data-target="#myModal1" 
                                                class="btn btn-primary"><i class="fa fa-mail-forward"></i> Change</button></td>
                                </tr>
                                <tr>
                                    <td> <h4 style="display: inline-block;">Business Address</h4></td>
                                    <td><h5 style="display: inline-block;margin-left: 20px;">
                                            @if($bus_addresstwo!=""&&$bus_state!=""&&$bus_postal!="")
                                            {{$bus_addressone}},<br>
                                            {{$bus_addresstwo}},<br>
                                            {{$bus_city}},<br>{{$bus_state}},{{$bus_postal}},<br>{{$bus_country}}.

                                            @elseif($bus_addresstwo==""&&$bus_state==""&&$bus_postal=="")
                                            {{$bus_addressone}},<br>
                                            {{$bus_city}},<br>{{$bus_country}}.

                                            @elseif($bus_state==""&&$bus_postal=="")
                                            {{$bus_addressone}},<br>
                                            {{$bus_addresstwo}},<br>
                                            {{$bus_city}},<br>{{$bus_country}}.

                                            @elseif($bus_addresstwo==""&&$bus_state=="")
                                            {{$bus_addressone}},<br>
                                            {{$bus_city}},{{$bus_postal}},<br>{{$bus_country}}.

                                            @elseif($bus_addresstwo==""&&$bus_postal=="")
                                            {{$bus_addressone}},<br>
                                            {{$bus_city}},<br>{{$bus_state}},<br>{{$bus_country}}.

                                            @elseif($bus_addresstwo=="")
                                            {{$bus_addressone}},<br>
                                            {{$bus_city}},<br>{{$bus_state}},{{$bus_postal}},<br>{{$bus_country}}.

                                            @elseif($bus_postal=="")
                                            {{$bus_addressone}},<br>
                                            {{$bus_addresstwo}},<br>
                                            {{$bus_city}},<br>{{$bus_state}},<br>{{$bus_country}}.

                                            @elseif($bus_state=="")
                                            {{$bus_addressone}},<br>
                                            {{$bus_addresstwo}},<br>
                                            {{$bus_city}},{{$bus_postal}},<br>{{$bus_country}}.

                                            @endif
                                        </h5></td>
                                    <td><button type="button" data-toggle="modal" data-target="#myModal2" style="" class="btn btn-primary"><i class="fa fa-mail-forward"></i> Change</button> </td>
                                </tr>
                                <!-- Developer 2 code starts -->
                                @if($acc_verify != 1)
                                    @if($info_saved != 1)
                                    <tr>
                                        <td colspan="3">
                                            <button data-toggle="modal" data-target="#downgradeModal" id="downgradeBnt" class="btn btn-primary">
                                                Downgrade account to personal
                                            </button>
                                        </td>
                                    </tr>
                                    @endif
                                @endif
                                <!-- Developer 2 code end -->
                            </tbody>
                        </table>
                    </div>
                    <div id="personal_verification" class="tab-pane" role="tabpanel">
                        <div class="varification-tab">
                            <a href="{{URL::to('/verifications?type=business')}}">Click Here</a> To verify Your Account
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
                    <h4 id="myModalLabel" class="modal-title">Edit Email Address</h4>
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

    <?php /* personal info */ ?>

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

    <?php /* personal info */ ?>


    <?php /* business info */ ?>
    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Change Business Name</h4>
                </div>
                <div class="modal-body">
                    <p>
                        Contact our Customer Support to change your Business name.
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
                    <h4 class="modal-title" id="myModalLabel">Change Business Address</h4>
                </div>
                <div class="modal-body">
                    <p>
                        Contact our Customer Support to change your Business Address.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php /* business info */ ?>
    <div class="modal fade" id="authorizationPasswordModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content"></div>
        </div>
    </div>

    <!-- Developer 2 code starts -->
    <div class="modal fade" id="downgradeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Are you sure you want to downgrade your account to a personal account?</h4>
                </div>
                <!--<div class="modal-body">
                    <p id="cardtype"></p>
                    <p id="cardnumber"></p>
                </div> -->
                <div class="modal-footer">
                    <a href="{{URL::to('user/my-account/downgrade')}}" id="rlink" class="btn btn-danger">Yes</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Developer 2 code end -->

    @stop