<!DOCTYPE html>
<html>
    <head>
        <title>Reset Password - <?php echo getSiteName() ?></title>
        <link rel="shortcut icon" href="{{ URL::asset(getFavicon()) }}" type="image/x-icon">
        <link rel="stylesheet" href="{{asset("components/AdminLTE/bootstrap/css/bootstrap.min.css")}}">
        <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
        <style type="text/css">
            body{
                font-family: 'Open Sans', sans-serif;
                margin: 0px;
                padding: 0px;
            }

        </style>
    </head>
    <body>
        <div class="container" style="text-align: center;margin-top: 10px;">
            <div class="col-md-6" style="float: none;margin: 0 auto;">
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach               
                    </ul>
                </div>
                @endif
                <h1>Reset Password</h1>
                <form class="register-box customRegisterBox demo-form" id="resetPassword" name="resetPassword" method="post" action="{{URL::to('/resetPassword/')}}/{{$tmp_password}}">
                    <div class="form-group has-feedback row">
                        <label class="col-sm-4 control-label">Password<sup>*</sup> </label>
                        <div class="col-sm-8"><input type="password" readonly     onfocus="this.removeAttribute('readonly');"  class="form-control readonly-password"  title="<h1>Your password must contain</h1><ul><li>At least 8 characters</li><li>At least 1 letter</li><li> At least 1 number/special character.</li></ul>"  placeholder="Enter new password" name="password" id="password" required="" >
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span></div>
                    </div>
					<div class="form-group has-feedback row">
                        <label class="col-sm-4 control-label">Re-enter password<sup>*</sup> </label>
                        <div class="col-sm-8"><input type="password" class="form-control"  title="<h1>Your password must contain</h1><ul><li>At least 8 characters</li><li>At least 1 letter</li><li> At least 1 number/special character.</li></ul>"  placeholder="Re-enter new password" name="passwordAgain" id="passwordAgain">
                        <span class="glyphicon glyphicon-log-in form-control-feedback"></span></div>
                       
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                     <div class="row" style="float: none;margin: 0 auto;">
                        <div class="col-md-5" style="float: left; padding-left: 0px;">
                            <button type="button" id='back' class="next btn btn-danger pull-right btn-primary btn-block btn-flat">Back</button>
                        </div>
                        <div class="col-md-5" style="float: right; padding-left: 0px;">
                            <input type="submit" value="Change Password" class="next btn  pull-right btn-primary btn-block btn-flat">
                        </div>
                     </div>
                </form>
            </div>
        </div>
    </body>
    <script src="{{URL::asset('components/AdminLTE/plugins/jQuery/jQuery-2.2.0.min.js')}}"></script>
    <!-- Bootstrap 3.3.6 -->
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <script>

$(document).ready(function () {
    $('#back').click(function () {
        parent.history.back();
        return false;
    });

$( document ).tooltip({html: true });
	var password = document.getElementById("password")
	  , confirm_password = document.getElementById("passwordAgain");

	function validatePassword(){
		
		if(password.value != confirm_password.value) {
			confirm_password.setCustomValidity("Passwords does not match");
		} else {
			confirm_password.setCustomValidity('');
		}
		/*
		//if(password.value.match(/^(?=.*\d)$/)){
		if(!/\d/.test(password.value)){
			password.setCustomValidity('Password must contain at least One Digit!');			
		} else { password.setCustomValidity(''); }
		
		if(password.value.match(/^(?=.*[a-z])$/)){
			password.setCustomValidity('Password must contain at least One Lower case character!');
		} else { password.setCustomValidity(''); }
		
		if(password.value.match(/^(?=.*[A-Z])$/)){
			password.setCustomValidity('Password must contain at least One Upper Case character!');
		} else { password.setCustomValidity(''); }
		
		if(password.value.match(/^[0-9a-zA-Z]{8,}$/)){
			password.setCustomValidity('Password must contain at least six characters!');
		} else { password.setCustomValidity(''); }
		*/
	}

	password.onchange = validatePassword;
	confirm_password.onkeyup = validatePassword;
});
$.widget("ui.tooltip", $.ui.tooltip, {
    options: {
        content: function () {
            return $(this).prop('title');
		},
		position: { my: "left+20 center", at: "right center" }
    }
});

    </script>
</html>
