@extends('User.dashboard.layouts.master')
@section('title', 'Business Information')
@section('content')

<div class="box box-info">
  <div class="box-header with-border">
                    <h3 class="box-title">Business Information</h3>
                </div>

<div class="container">
    <div class="row">
            <div class="col-md-8">
                @if($msg!='')
                <div class="alert alert-success">
                    <ul>
                        <li>{{ $msg }}</li>           
                    </ul>
                </div>
                @endif

                <div class="row">
                    <table class="table table-hover  ">
                        <tbody>
                        <tr>
                            <td> <h4 style="display: inline-block;">Business Name</h4></td>
                            <td><h5 style="display: inline-block;margin-left: 20px;">{{$name}}</h5></td>
                            <td><button type="button" data-toggle="modal" data-target="#myModal1" style="width: 100%;" class="btn btn-primary">Change</button></td>
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

                                    @endif
                                </h5></td>
                            <td><button type="button" data-toggle="modal" data-target="#myModal2" style="width:100%;" class="btn btn-primary">Change</button> </td>
                        </tr>
                        </tbody>
                    </table>



                </div>
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
            </div>
        </div>
    </div>
</div>
@stop