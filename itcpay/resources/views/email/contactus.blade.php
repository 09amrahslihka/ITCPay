<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<table style = 'background-color:#fff;text-align:center;'>
    <tr><td>
            <img src="{{URL::asset(getLogo())}}">
        </td></tr>
    <tr><td>
            <hr style = 'border:solid 1px #000'></hr>
            <table style = 'width:100%;background-color:#fff;text-align:left;'><tr><td style = 'text-align:center' colspan = '2'>
                <tr><td colspan = '2'>
                    </td></tr>
                <tr><td colspan = '2'>
                        Dear  Admin<br><br>The user has submitted the ticket with the following details.
                    </td></tr><tr><td colspan = '2'>
                    </td></tr>
                <tr><td><b>Message:</b></td><td>{{$contactus->message}}</td></tr>
				<tr><td colspan='2'>&nbsp;</tr>
                <tr><td colspan='2'>Thank You.</td></tr>
                <tr><td colspan='2'>&nbsp;</tr>
            </table>
        </td></tr>
</table>
</body>
</html>