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
                <tr><td colspan = '2'>&nbsp;</td></tr>
                <tr><td colspan = '2'>Dear  Admin,</td></tr>
				<tr><td colspan = '2'>&nbsp;</td></tr>
	     		<tr><td colspan = '2'>The user has submitted the feedback with the following details.</td></tr>
				<tr><td colspan = '2'>&nbsp;</td></tr>
                <tr><td><b>Name :</b></td><td>{{$contactus->name}}</td></tr>
                <tr><td><b>Email :</b></td><td>{{$contactus->email}}</td></tr>
                <tr><td><b>Message:</b></td><td>{{$contactus->message}}</td></tr>
				<tr><td colspan='2'>&nbsp;</tr>
                <tr><td colspan='2'>Thank You.</td></tr>
                <tr><td colspan='2'>&nbsp;</tr>
            </table>
        </td></tr>
</table>
</body>
</html>