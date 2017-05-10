<!DOCTYPE html>
<html>
    <head>
        <title>Change Password - <?php echo getSiteName() ?></title>
        <link rel="shortcut icon" href="{{ URL::asset(getFavicon()) }}" type="image/x-icon">
        <link rel="stylesheet" href="{{asset("components/AdminLTE/bootstrap/css/bootstrap.min.css")}}">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <style type="text/css">
            body{
                font-family: 'Open Sans', sans-serif;
                margin: 0px;
                padding: 0px;
            }
            .content-wrap{               
                background-size:cover;
                background-repeat: no-repeat;
                background-position: center center;
                min-height: 100vh;
                position: relative;
            }
            .content-overlay{
                display: block;
                /*background: rgba(210, 214, 222, 0.94);*/
                min-height: 100vh;
            }
            .content{
                color: #323232;
                font-size: 30px;
                font-weight: 300;
            }
            .btn-conf a{
                display: inline-block;
                text-decoration: none;
                color: #fff;
                padding: 10px 40px;
                background: rgba(91, 192, 222, 0.94);
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
            #vrfy{
                font-size: 60px;
                color:#66cc9a;
                font-weight: 600;
            }
            .btn-conf a i{
                color:#001f3f;
                margin-left: 10px;
                transition: 300ms ease-in-out;

            }

        </style>
    </head>
    <body>
        <div class="content-wrap">
            <div class="content-overlay">
                <div class="content col-sm-6 col-sm-offset-3 col-xs-12">
                    <div class="logo">
                        <img src="{{asset(getLogo())}}">
                    </div>
                    <p>We have just sent the password recovery email to {{$email}}. 
                        If you can't find our email in your inbox, please check your spam/junk 
                        mail folder also. Or add no-reply@itcpay.com to
                        your address book and resend verification email.</p>                  
                    <div class="btn-conf">
                        <a href="" id='back'>Back<i class="fa fa-sign-in"></i></a>
                    </div>
                </div>
            </div>
        </div>

    </body>
    <script src="{{URL::asset('components/AdminLTE/plugins/jQuery/jQuery-2.2.0.min.js')}}"></script>
        <!-- Bootstrap 3.3.6 -->

        <script>

$(document).ready(function () {
    $('#back').click(function () {
        parent.history.back();
        return false;
    });
});

        </script>
</html>