<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<table style = 'background-color:#fff;text-align:center;border:solid 1px #000'>
    <tr><td style = 'background-color: rgb(212, 212, 212);'>
            <img src="{{URL::asset(getLogo())}}">
        </td></tr>
    <tr><td>
            <hr style = 'border:solid 1px #000'></hr>
            <table style = 'width:100%;background-color:#fff;text-align:left;'><tr><td style = 'text-align:center' colspan = '2'>
                <tr><td colspan = '2'>
                    </td></tr>
                <tr><td colspan = '2' style = 'text-align:center;'>
                        <img src = "{{URL::asset('/images/signup-verification.png')}}">
                        <br />
                        <br />
                    </td>
                </tr>
                <tr><td colspan = '2'>
						  <b style = 'text-transform: capitalize;'>Hi {{$profile}},</b>
						<br />
                        <br />
                        Congratulations, you have successfully signed up with {{ getSiteName() }}.
                        You just need to click on the SignUp Verification button below to verify your email account with us.
                        <br />
                        <br />
                    </td>
                </tr>
                <tr><td colspan = '2' style = 'text-align:center;'>
                        <a href="{{url('/cards/authenticate-card/'.$data->confirmation_code)}}" style = 'background-color:#0762b9;color:#fff;padding: 10px 20px;text-decoration:none; font-size:1.2em;'>Verify Email</a>
                        <br />
                        <br />
                    </td>
                </tr>
                <tr><td colspan = '2'>
                        Button not working? No worries, please copy and paste the below link in your browser&#39;s address bar.
                        <br />
                        <br />
                        {{url('/cards/authenticate-card/'.$data->confirmation_code)}}
                        <br />
                        <br />
                    </td></tr>
                <tr><td colspan = '2'>
                    </td></tr>
                <tr><td colspan='2' style='padding:5px 0px 5px 5px;'>Yours sincerely,</td></tr>
                <tr><td colspan='2' style='padding:5px 0px 5px 5px;'>{{ getSiteName() }}</td></tr>
				<tr><td colspan='2' style='padding:5px 0px 5px 5px;'>Please do not reply to this email. Replies sent to this email address can't be answered. To get in touch, go to {{ getSiteName() }} website and click <a href="http://payments-hub.com/pages/Support" target="_blank">Support</a>.</td></tr>
                <tr><td colspan='2' style='padding:5px 0px 5px 5px;'>Copyright &copy; {{date("Y")}} {{ getSiteName() }}. All rights reserved.</tr>
                </td></tr>
            </table>
        </td></tr>
</table>
</body>
</html>