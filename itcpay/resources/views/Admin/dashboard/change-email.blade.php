@extends('Admin.dashboard.layouts.master')

@section('content')

<div class="box box-info">
		<div class="col-sm-12">
           <div class="row">
            <div class="col-md-12">
				<div class="change-form-bg clearfix">
					<div class="message-info clearfix">
						<h3 class="box-title">Change email address</h3>
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
					<form method="post" action="{{URL::to('/admin/update-email')}}">
						<div class="row">
							<div class="email-form clearfix">
								<div class="col-md-4">
									<div class="form-group has-feedback">
										<label for="emailtoupdate">Email:</label>
										<input id="emailtoupdate" class="form-control" title="Please enter new email" type="text" placeholder="Email*" name="emailtoupdate" required="">
										<span class="glyphicon glyphicon-lock form-control-feedback"></span>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group has-feedback">
										<label for="emailtoupdate">Re-enter email:</label>
										<input id="confirmemail" type="text" title="Please re-enter your new email" class="form-control" placeholder="Re-enter email*" data-parsley-equalto="#emailtoupdate" data-parsley-equalto-message="Email does not match" name="confirmemail" >
										<span class="glyphicon glyphicon-log-in form-control-feedback"></span>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group has-feedback">
										<label for="emailtoupdate">Current Password:</label>
										<input id="passwordi" class="form-control parsley-required" title="Your current password required to update the email" type="password" placeholder="Current Password*" name="password" required="">
										<span class="glyphicon glyphicon-lock form-control-feedback"></span>
									</div>
								</div>
							</div>
						</div>	
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="row">
							<div class="col-md-12">
								<div class="email-btn clearfix">	
									<input value="Back" type="button"  id='back' class="next btn btn-danger">
									<input type="submit" value="Change Email" class="next btn btn-primary">
								</div>
							</div>
						</div>
					</form>
			</div>		
		</div>
	</div>

</div>
        </div>
<script type="text/javascript">
function resetValues()
{ 
	var emailtoupdate = document.getElementById("emailtoupdate");
	var confirmemail = document.getElementById("confirmemail");
	emailtoupdate.value = "";
	emailtoupdate.value = confirmemail.value;
}
function isValidEmailAddress(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
};

setTimeout(resetValues(), 3000);
$(document).ready(function () {
	var email_to_update = document.getElementById("emailtoupdate")
	  , confirm_email = document.getElementById("confirmemail");

	function validateEmail(){

        if( !isValidEmailAddress( email_to_update.value ) ) {
            email_to_update.setCustomValidity("Invalid email");
            return false;
        }

		if(email_to_update.value != confirm_email.value) {
			confirm_email.setCustomValidity("Email does not match");
		} else {
			confirm_email.setCustomValidity('');
		}
	}

    email_to_update.onchange = validateEmail;
	confirm_email.onkeyup = validateEmail;
});

</script>
@stop
