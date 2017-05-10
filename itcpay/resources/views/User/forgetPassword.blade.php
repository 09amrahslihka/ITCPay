@extends('layouts.master')
@section('title', 'Forgot Password')
@section('content')
<div class="container-fluid hold-transition register-page">
    <div class="register-box customRegisterBox">
      <div class="register-box-body">
        <p style="font-size: 30px;" class="login-box-msg">Forgot your password?</p>
      
        @if (Session::has('errormessage'))
        <div class="alert alert-danger">
          <ul>
              <li>{{ Session::get('errormessage') }}</li>
          </ul>
        </div>
        @endif 
       <div class="form-group form-section">
            <form method="post" action="{{URL::to('login/forgetPassword')}}">
                 <div class="form-group has-feedback row">
                    <label class="col-sm-3 control-label">Email<sup>*</sup></label>
                    <div class="col-sm-9">                         
                        <input type="text" class="form-control" placeholder="Enter Email Address" name="Email" required="" value="{{ old('Email') }}">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if ($errors->has('Email'))
                        <span class="alert-danger">
                            <strong>{{ $errors->first('Email') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                
                <div class="col-sm-offset-3"><p>Human Verification Challange.</p></div>
                <div class="col-sm-offset-3">
                    <div class="form-group has-feedback captcha" style="text-align: center;">
                        {!! captcha_image_html('ExampleCaptcha') !!}
                    </div>
                </div>
                <div class="form-group has-feedback row">
                  <label class="col-sm-3 control-label padding-left-0"> Enter captcha code here<sup>*</sup></label>
                    <!--<input type="text" class="form-control" placeholder="Enter captcha code here*" name="captcha" /> -->
                   <div class="col-sm-9"> 
                    <input type="text" class="form-control"  name="captcha" id="captcha">
                    @if ($errors->has('captcha'))
                        <span class="alert-danger">
                            <strong>{{ $errors->first('captcha') }}</strong>
                        </span>
                    @endif
                    </div>
                </div>             
                <div class="form-group has-feedback row"> 
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="col-sm-3"></div>
                        <div class="col-sm-3">
                            <button type="button" style="font-weight: 500; font-size: 15px; margin-bottom:15px;"  id='back' href="{{url('login')}}"  class="next btn btn-danger pull-right btn-primary btn-block btn-flat">Back</button>
                        </div>
                        <div class="col-sm-3">
                            <input style="font-weight: 500; font-size: 15px;" type="submit" value="Retrieve Password" class="next btn pull-right btn-primary btn-block btn-flat">
                        </div>

                        

                </form>

            </div>
        </div>
@stop
