@extends('User.dashboard.layouts.master')
@section('title', 'Account Information')
@section('content')

<div class="box box-info">
  <div class="box-header with-border">
                    <h3 class="box-title">Account Information</h3>
                </div>

<div class="container">
    <div class="row">
            <div class="col-md-8">
               
                @if (Session::has('message'))
                <div class="alert alert-success">
                    <ul>
                        <li>{{  Session::get('message') }}</li>           
                    </ul>
                </div>
                @endif
                <div class="row">
                    <table class="table table-hover  ">
                        <tbody>
                        <tr>
                            <td> <h4 style="display: inline-block;">Email</h4></td>
                            <td><h5 style="display: inline-block;margin-left: 20px;">{{$email}}</h5></td>
                            <td> <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-primary" style="width: 100%;">Change</button></td>
                        </tr>
                        <tr>
                            <td><h4 style="display: inline-block;">Password</h4></td>
                            <td><h5 style="display: inline-block;margin-left: 20px;">***********</h5></td>
                            <td> <button type="button" onclick="location.href ='{{URL::to('/dashboard/changePassword')}}'" class="btn btn-primary"style="width: 100%;">Change</button></td>

                        </tr>
                        <tr>
                            <td> @if($acc=="personal")<h4 style="display: inline-block;">Mobile Number</h4>
                                @elseif($acc=="business")
                                    <h4 style="display: inline-block;">Phone/Mobile</h4>
                                @endif</td>
                            <td><h5 style="display: inline-block;margin-left: 20px;">{{$mobile}}</h5></td>
                            <td><button type="button" onclick="location.href ='{{URL::to('/dashboard/changePhone')}}'" class="btn btn-primary"style="width: 100%;">Change</button></td>

                        </tr>
                        <tr>
                            <td><h4 style="display: inline-block;">Time zone</h4></td>
                            <td><h5 style="display: inline-block;margin-left: 20px;">{{$timezone}}</h5></td>
                            <td><button type="button"onclick="location.href ='{{URL::to('/dashboard/changeTimezone')}}'" class="btn btn-primary" style="width: 100%;">Change</button></td>
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
@stop