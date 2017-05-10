@extends('layouts.master')
@section('title', 'Sign up')
@section('content')
    <style>
            .btn-conf a{
                display: inline-block;
                text-decoration: none;
                color: #fff;
                padding: 10px 40px;
                background: rgba(113, 220, 167, 0.94);
                font-size: 20pt;
                text-transform: uppercase;
                letter-spacing: 2px;
                box-shadow: 1px 3px 5px #001F3F;
                transition: 300ms ease-in-out;
            }
            .btn-conf a:hover{
                color:#001f3f;
                background-color: #fff;
            }
            .btn-conf a:hover i{
                margin-left: 30px;
            }

            body {
                font-family: 'Roboto', sans-serif;
                font-size: 16px;
                font-weight: 300;
                color: #888;
                line-height: 30px;
                text-align: center;
            }

            strong { font-weight: 500; }


            h1, h2 {
                margin-top: 10px;
                font-size: 38px;
                font-weight: 100;
                color: #333;
                line-height: 50px;
            }

            h3 {
                font-size: 22px;
                font-weight: 300;
                color: #999;
                line-height: 30px;
            }

            img { max-width: 100%; }

            ::-moz-selection { background: #19b9e7; color: #fff; text-shadow: none; }
            ::selection { background: #19b9e7; color: #fff; text-shadow: none; }



            .top-content .text {
                color: #fff;
            }

            .top-content .text h1 { color: #fff; }

            .top-content .description {
                margin: 20px 0 10px 0;
            }

            .top-content .description p { opacity: 0.8; }

            .top-content .description a {
                color: #fff;
            }
            .top-content .description a:hover,
            .top-content .description a:focus { border-bottom: 1px dotted #fff; }

            .form-box {
                margin-top: 36px;
            }

            .form-top {
            padding: 0 15px 15px 15px;
            text-align: left;
            border:7px solid #757379;
			min-height:186px;
			position:relative;
			}

            .form-top-left {
                float: left;
                width: 100%;
                padding-top:18px;
            }

            .form-top-left h3 { margin-top: 0; }

            .form-top-right {
                background: #ecf0f5;
				color: #0762b9;
				float: left;
				font-size: 68px;
				line-height: 68px;
				padding-top: 5px;
				position: absolute;
				right: 0;
				text-align: center;
				top: -47px;
				width: 83px;
				z-index: 90;
            }

            .form-bottom {
                padding: 25px 0px 30px 0px;
                background: #eee;
                -moz-border-radius: 0 0 4px 4px; -webkit-border-radius: 0 0 4px 4px; border-radius: 0 0 4px 4px;
                text-align: left;
            }
			.form-bottom a{background:#0762b9 !important; font-size: 26px; font-weight: 300; padding: 4px 0;}

            .form-bottom form textarea {
                height: 100px;
            }


            .middle-border {
                min-height: 300px;
                margin-top: 170px;
           }


            /***** Media queries *****/

            @media (min-width: 992px) and (max-width: 1199px) {}

            @media (min-width: 768px) and (max-width: 991px) {}

            @media (max-width: 767px) {

                .middle-border { min-height: auto; margin: 65px 30px 0 30px; border-right: 0;
                    border-top: 1px solid #fff; border-top: 1px solid rgba(255, 255, 255, 0.6); }

            }

            @media (max-width: 415px) {

                h1, h2 { font-size: 32px; }

            }


        </style>
<div class="container-fluid hold-transition register-page">
		<div class="box-register">
			<div class="container-fluid txt" style="">
				<h1>{{ getSiteName() }} is an easy and a secure solution for all your financial transactions Sign up, it's Free</h1>
				<div class="row" style="text-align:center">
				<div class="col-sm-11" style="float: none; margin: 0 auto;">

					<div class="col-sm-5">

						<div class="form-box">
							<div class="form-top">
								<div class="form-top-left">
									<h2 style="color: #999999;">Personal Account</h2>
									<p>For individuals who pay and spend online.</p>
									<br>
								</div>
								<div class="form-top-right">
									<i class="fa fa-user"></i>
								</div>
							</div>
							<div class="form-bottom">
								<form role="form" action="" class="login-form">
									<a class="btn btn-info" style="background-color: #0099cc; width: 100%;" href="{{URL::to('/register/personal')}}">Sign up</a>
								</form>
							</div>
						</div>

					</div>
					<div class="col-sm-2 middle-border"></div>
					<div class="col-sm-5">

						<div class="form-box">
							<div class="form-top">
								<div class="form-top-left">
									<h2 style="color: #999999;">Business Account</h2>
									<p>For merchants who use a company or group name and buy and sell online.</p>
								</div>
								<div class="form-top-right">
									<i class="fa fa-briefcase"></i>
								</div>
							</div>
							<div class="form-bottom" >
								

								<a class="btn btn-info" style="background-color: #0099cc; width: 100%;height: 100%;" href="{{URL::to('/register/business')}}">Sign up</a>

								
							</div>
						</div>


					</div>
				</div>


			</div>
			</div>
		</div>	
</div>
<script type="text/javascript">
$('.radio-signup').click(function(){
    if($(this).data('value') =="business"){
        $('#signupType').val('business')
        $('#personal').find('i.fa-circle').css('color','#ccc');
    }else{
        $('#signupType').val('personal')
        $('#business').find('i.fa-circle').css('color','#ccc');
    }
    $(this).find('i.fa-circle').css('color','#0762b9');

})
// $('.radio-signup').focusout(function(){
//     alert('ddd')
//     $(this).find('i.fa-circle').css('color','#ccc');
// })

function redirctToSignup () {
    window.location = window.location.href+"/"+$('#signupType').val();    // body...
}

</script>
@stop