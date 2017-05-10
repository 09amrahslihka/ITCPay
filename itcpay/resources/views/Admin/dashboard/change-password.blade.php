@extends('Admin.dashboard.layouts.master')

@section('content')

    <div class="box box-info">

        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-12">
					<div class="change-form-bg clearfix">
						<div class="message-info clearfix">
							<h3 class="box-title">Change admin password</h3>
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

						<form method="post" action="{{URL::to('admin/update-password')}}">
							<div class="row">
								<div class="email-form clearfix">
									<div class="col-md-4">
										<div class="form-group has-feedback">
											<label for="currentpassword">Current Password:</label>
											<input id="currentpassword" class="form-control"
												   title="Your current password"
												   type="password" placeholder="Current Password*" name="currentpassword" required="">
											<span class="glyphicon glyphicon-lock form-control-feedback"></span>
										</div>
									</div>	
									<div class="col-md-4">
										<div class="form-group has-feedback">
											<label for="password">Password:</label>
											<input id="passwordi" class="form-control"
												   title="Your password must contain<br />- At least 8 characters<br />- At least 1 letter<br />- At least 1 number/special character."
												   type="password" placeholder="Password*" name="password" required="">
											<span class="glyphicon glyphicon-lock form-control-feedback"></span>
										</div>
									</div>	
									<div class="col-md-4">
										<div class="form-group has-feedback">
											<label for="passwordAgain">Re-enter Password:</label>
											<input id="confirmpasss" type="password"
												   title="Your password must contain<br />- At least 8 characters<br />- At least 1 letter<br />- At least 1 number/special character."
												   class="form-control" placeholder="Re-enter Password*"
												   data-parsley-equalto="#passwordi"
												   data-parsley-equalto-message="Password does not match" required=""
												   name="passwordAgain">
											<span class="glyphicon glyphicon-log-in form-control-feedback"></span>
										</div>
									 </div>	
								  </div>	
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<div class="">
									<div class="col-md-12">
										<div class="email-btn clearfix">
											<input value="Back" type="button" id='back' class="next btn btn-danger">
											<input type="submit" value="Change Password" class="next btn btn-primary">
										</div>
									</div>	
									
								</div>
							</div>
						</form>
					</div>
                </div>

            </div>
            <br/>
        </div>
    </div>
    <script type="text/javascript">
        function resetValues() {
            var passwordi = document.getElementById("passwordi");
            var confirmpasss = document.getElementById("confirmpasss");
            var currentpassword = document.getElementById("currentpassword");
            passwordi.value = ""; currentpassword.value = "";
            passwordi.value = confirmpasss.value;
        }
        setTimeout(resetValues(), 3000);
        $(document).ready(function () {
            var password = document.getElementById("passwordi")
                    , confirm_password = document.getElementById("confirmpasss");

            function validatePassword() {
                if (password.value != confirm_password.value) {
                    confirm_password.setCustomValidity("Passwords does not match");
                } else {
                    confirm_password.setCustomValidity('');
                }
            }

            password.onchange = validatePassword;
            confirm_password.onkeyup = validatePassword;
        });

    </script>
@stop
