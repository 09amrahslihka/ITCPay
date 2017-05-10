@extends('layouts.master')
@section('title', 'Change Email Address')
@section('content')
            <div class="col-md-6 col-md-offset-3" style="float: none;margin-top: 52px;">
                <div class="login-box-body clearfix">
                <h4><b>Change Email Address</b></h4>
                <form method="post" action="{{action('Registration\RegisterController@updateEmail')}}">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder=" Enter a new Email Address" name="Email" required="">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <input type="hidden" name="oldemail" value="{{$email}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                       <div class = "row">
                           <div class="col-md-4">
                               <button type="button" id='back' class="next btn btn-danger pull-right btn-primary btn-block btn-flat">Back</button>
                           </div>
                            <div class="col-md-4">
                                <input type="submit" value = "Change Email" name="Change" class="next btn btn-info pull-right btn-primary btn-block btn-flat">
                            </div>
                        </div>
                </form>
               </div>
            </div>
    <script src="{{URL::asset('components/AdminLTE/plugins/jQuery/jQuery-2.2.0.min.js')}}"></script>   <!-- Bootstrap 3.3.6 -->
    <script>
$(document).ready(function () {
    $('#back').click(function () {
        parent.history.back();
        return false;
    });
});
    </script>
@stop
