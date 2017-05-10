<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>@hasSection('title') @yield('title') - @endif<?php echo getSiteName() ?></title>
        <link rel="shortcut icon" href="{{ URL::asset(getFavicon()) }}" type="image/x-icon">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="{{ URL::asset('components/AdminLTE/bootstrap/css/bootstrap.css') }}">
        <!-- Font Awesome -->

        <link rel="stylesheet" href="{{ URL::asset('components/font-awesome/css/font-awesome.min.css')}}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{ URL::asset('components/Ionicons/css/ionicons.min.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ URL::asset('components/AdminLTE/dist/css/AdminLTE.min.css') }}">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{ URL::asset('components/AdminLTE/plugins/iCheck/square/blue.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
		<link rel="stylesheet" href="{{ URL::asset('css/pages.css') }}">
        <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
        <!--Captcha -->
        <link href="{{ captcha_layout_stylesheet_url() }}" type="text/css" rel="stylesheet">
	<!-- jQuery 2.2.0 -->
	<script src="{{asset("/components/jquery/dist/jquery.js")}}"></script>
	<script src="{{asset("components/AdminLTE/plugins/jQuery/jQuery-2.2.0.min.js")}}"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
        <header>
            @include('layouts.header')
        </header>
        <div class="body-content">
            <div class="content-wrapper" style="overflow: hidden;">
                <section class="content">
            @yield('content')
                    </section>
                </div>
        </div>
        <!--  <footer> -->
        @include('layouts.footer') 
        <!--  </footer> -->
        <!-- jQuery 2.2.0 -->
        <!--<script src="{{URL::asset('components/AdminLTE/plugins/jQuery/jQuery-2.2.0.min.js')}}"></script>-->
        <!-- Bootstrap 3.3.6 -->
        <script src="{{URL::asset('components/AdminLTE/bootstrap/js/bootstrap.min.js')}}"></script>
        <!-- iCheck -->
        <script src="{{URL::asset('components/AdminLTE/plugins/iCheck/icheck.min.js')}}"></script>
        <script src="{{URL::asset('components/parsleyjs/dist/parsley.min.js')}}"></script>
        <!-- InputMask -->
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

        <script src="{{ URL::asset('components/AdminLTE/plugins/input-mask/jquery.inputmask.js') }}"></script>
        <script src="{{ URL::asset('components/AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
        <script src="{{ URL::asset('components/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>



        <script src="{{ asset('js/registration.js') }}"></script>
        <script>
			$(document).ready(function(){

                $(".BDC_CaptchaImageDiv>a").html("Paymets Hub");
                $(".BDC_CaptchaImageDiv>a").attr("href","{{URL::to("")}}");
                $(".BDC_CaptchaImageDiv>a").attr("title","Paymets hub");
                $(".BDC_CaptchaImageDiv>a").css('cssText', 'display: none !important');
                
				$('#back').click(function(){
					parent.history.back();
					return false;
				});
				$( document ).tooltip({html: true});
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
            
   
@yield('scripts')
  
    </body>
</html>
