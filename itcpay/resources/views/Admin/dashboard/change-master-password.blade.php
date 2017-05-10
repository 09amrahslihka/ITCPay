@extends('Admin.dashboard.layouts.master')

@section('content')

    <div class="box box-info">

        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-12">
					<div class="change-form-bg clearfix">
						<div class="message-info clearfix">
							<h3 class="box-title">Change master password</h3>
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

						<form method="post" action="{{URL::to('admin/update-master-password')}}">
					        <div class="row">
								<div class="email-form clearfix">
									<div class="col-md-4">
										<div class="form-group has-feedback">
											<label for="emailtoupdate">Master password:</label>
											<input id="passwordi" class="form-control"
												   title="Master password must contain<br />- At least 8 characters<br />- At least 1 letter<br />- At least 1 number/special character."
												   type="password" placeholder="Master password*" name="password" onmouseover="javascript:mouseOverPass()" onmouseout="javascript:mouseOutPass()">
											<span class="glyphicon glyphicon-lock form-control-feedback"></span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group has-feedback">
											<label for="emailtoupdate">Re-enter master password:</label>
											<input id="confirmpass" type="password"
												   title="Re-enter master password"
												   class="form-control" placeholder="Re-enter master password*"
												   data-parsley-equalto="#passwordi"
												   data-parsley-equalto-message="Master password does not match" required=""
												   name="passwordAgain">
											<span class="glyphicon glyphicon-log-in form-control-feedback"></span>
										</div>
									</div>
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<div class="col-md-12">
										<div class="email-btn clearfix">
											<input value="Back" type="button" id='back' class="next btn btn-danger">
										    <input type="submit" value="Change master password" class="next btn btn-primary">
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
            var pass = document.getElementById("passwordi");
            var confirmpass = document.getElementById("confirmpass");
            confirmpass.value = ""; pass.value = "";
        }
        setTimeout(resetValues(), 3000);
        $(document).ready(function () {
            var password = document.getElementById("passwordi")
                    , confirm_password = document.getElementById("confirmpass");

            function validatePassword() {
                if (password.value != confirm_password.value) {
                    confirm_password.setCustomValidity("Master passwords does not match");
                } else {
                    confirm_password.setCustomValidity('');
                }
            }

            password.onchange = validatePassword;
            confirm_password.onkeyup = validatePassword;
        });
        function mouseOverPass(obj) {
            var obj = document.getElementById('passwordi');
            obj.type = "text";
        }
        function mouseOutPass(obj) {
            var obj = document.getElementById('passwordi');
            obj.type = "password";
        }

    </script>
@stop
