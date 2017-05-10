<html>
<head>
    <title>Forgot Password - <?php echo getSiteName() ?></title>
    <link rel="shortcut icon" href="{{ URL::asset(getFavicon()) }}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('components/AdminLTE/bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{URL::asset('components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{URL::asset('components/ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('components/AdminLTE/dist/css/AdminLTE.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('components/AdminLTE/plugins/iCheck/square/blue.css')}}">
    {{----------------------------------------------------------------------}}

</head>
<body>
    <div class="container" style="text-align: center;margin-top: 10px;">
        <div class="col-md-6" style="float: none;margin: 0 auto;">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Email *" name="Email" required="">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="col-md-4" style="float: none;margin: 0 auto;">
                <button type="button" class="next btn  pull-right btn-primary btn-block btn-flat">Forgot Password</button>
            </div>
        </div>
    </div>


</body>
</html>