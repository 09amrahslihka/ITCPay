<html>    
    <head>
        <title>Test - <?php echo getSiteName(); ?></title>
        <link rel="shortcut icon" href="{{ URL::asset(getFavicon()) }}" type="image/x-icon">
        <link rel="stylesheet" href="{{asset("components/AdminLTE/bootstrap/css/bootstrap.min.css")}}">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <script src="{{URL::asset('components/AdminLTE/plugins/jQuery/jQuery-2.2.0.min.js')}}"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="{{URL::asset('components/AdminLTE/bootstrap/js/bootstrap.min.js')}}"></script>

    </head>

    <body>
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
            Launch demo modal
        </button>

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
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>