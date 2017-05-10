<!DOCTYPE html>
<html>
    <head>
        <title>Verify Logged in User - <?php echo getSiteName(); ?></title>
        <link rel="shortcut icon" href="{{ URL::asset(getFavicon()) }}" type="image/x-icon">
        <link rel="stylesheet" href="{{asset("components/AdminLTE/bootstrap/css/bootstrap.min.css")}}">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

        <!-- jQuery 2.2.0 -->
        <script src="{{asset("/components/jquery/dist/jquery.js")}}"></script>
        <script src="{{asset("components/AdminLTE/plugins/jQuery/jQuery-2.2.0.min.js")}}"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="{{asset("components/AdminLTE/bootstrap/js/bootstrap.min.js")}}"></script>
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
			<nav class="navbar navbar-static-top" role="navigation">
				<div class="navbar-custom-menu" style="float:right; margin:15px;">
					<ul class="nav navbar-nav">
					  <!-- Messages: style can be found in dropdown.less-->
					 
					  <!-- User Account Menu -->
					  <li class="dropdown user user-menu">
						<!-- Menu Toggle Button -->
						  <!-- The user image in the navbar-->
						  <!-- hidden-xs hides the username on small devices so only the image appears. -->
						  <span class="hidden-xs">{{$profile}} &nbsp;&nbsp;<a href="{{URL::to('user/signout')}}" class="btn btn-default btn-flat">Sign out</a></span>
						  
						</li>
					</ul>
				</div>
			</nav>
                <div class="content col-sm-6 col-sm-offset-3 col-xs-12">
                    <div class="logo">
                        <img src="{{asset(getLogo())}}">
                    </div>
                    <p>An email with a verification link was previously sent to {{$email}}. 
                        Please open the link to <span id="vrfy">activate</span> your account.</p>
                    <p>If you can't find our email in your inbox, please check your spam/junk 
                        mail folder also. Or add no-reply@itcpay.com to
                        your address book and resend verification email.</p>                  
                    <div class="btn-conf">
                        <a href="{{URL::to('/register/resend')}}/{{$email}}">Resend Verification Email<i class="fa fa-sign-in"></i></a>
                    </div>
                    <div class="btn-conf">
                        <a href="{{URL::to('/register/change')}}/{{$email}}">Change Email Address<i class="fa fa-sign-in"></i></a>
                    </div>
                    <div class="btn-conf">
                        <a href="#" data-toggle="modal" data-target="#myModal">Still1 Haven't recieved Email?<i class="fa fa-sign-in"></i></a>
                    </div>
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Help! I still haven't received the verification email</h4>
                                </div>
                                <div class="modal-body">
                                    <p>
                                        * It is possible that your email provider may be having technical difficulties preventing you from receiving emails. This is especially true if you have a self hosted email address like yourname@yourdomain.com. In this case <a href="{{URL::to('/register/change')}}/{{$email}}">Change your email address</a> and verify your new email address.
                                    </p>
                                    <p>
                                        You may have made a typo in the mail provided. Check to ensure the email address is spelled correctly. If your email address is incorrect, you can <a href="{{URL::to('/register/change')}}/{{$email}}">Change your email address</a>.
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <!--button type="button" class="btn btn-primary">Save changes</button-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>