<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ getSiteName() }}</title>
    <link rel="shortcut icon" href="{{ URL::asset(getFavicon()) }}" type="image/x-icon">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ URL::asset('components/AdminLTE/bootstrap/css/bootstrap.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ URL::asset('components/font-awesome/css/font-awesome.min.css')}}">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700' rel='stylesheet' type='text/css'>
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ URL::asset('components/ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('components/AdminLTE/dist/css/AdminLTE.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ URL::asset('components/AdminLTE/plugins/iCheck/square/blue.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body class="hold-transition login-page">
@include('layouts.header')
<div class="login-box">
    <div class="login-logo">
        <a href="{{URL::to('/')}}"><img src="{{URL::asset(getLogo())}}"/></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (Session::has('errormessage'))
            <div class="alert alert-danger">
                <ul>

                    <li>{{ Session::get('errormessage') }}</li>

                </ul>
            </div>
        @endif

        @if(Session::has('message'))
            <div class="alert alert-success" role="alert">
                {{Session::get('message')}}
            </div>
        @endif

        <p class="login-box-msg">Log in to your account.</p>

        <form action="{{URL::to('/login')}}" method="post" autocomplete="off">

            <div class="row">
                <div class="col-sm-3"><label>Email</label></div>
                <div class="col-sm-9">
                    <div class="form-group has-feedback">
                        <input type="email" name="email" class="form-control" placeholder="Email"
                               @if(isset($_COOKIE['email'])) value="{{$_COOKIE['email']}}" @endif>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-3"><label>Password</label></div>
                <div class="col-sm-9">
                    <div class="form-group has-feedback">
                        <input type="password" id="password" name="password" autocomplete="off" class="form-control"
                               placeholder="Password"
                               @if(isset($_COOKIE['password'])) value="{{$_COOKIE['password']}}" @endif>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-8">
                    <a href="{{URL::to('/login/forget')}}">Forgot Password</a><br>
                    <a href="{{URL::to('/register')}}" class="text-center">Create a new account</a>
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                    <?php if(isset($loginMessage)){ ?>
                    <input type="hidden" name="emailVerificationLogin" value="<?php if(isset($loginMessage)){ echo $loginMessage; } ?> " />
                        <?php  } ?>
                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Log in</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@include('layouts.footer')
<!-- jQuery 2.2.0 -->
<script src="{{ URL::asset('components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ URL::asset('components/AdminLTE/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- iCheck -->
<script src="{{ URL::asset('components/AdminLTE/plugins/iCheck/icheck.min.js')}}"></script>

<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html>
