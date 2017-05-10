<html>
<head>
    <title>Not Found - <?php echo getSiteName() ?></title>
    <link rel="shortcut icon" href="{{ URL::asset(getFavicon()) }}" type="image/x-icon">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="{{ URL::asset('components/AdminLTE/bootstrap/css/bootstrap.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700' rel='stylesheet' type='text/css'>
    <style type="text/css">
        body{
            font-family: 'Consolas', cursive;}
        body{background: #ffffff;}
        a:focus{outline: none;}
        .wrap{
            margin:0 auto;
            width:1000px;
        }
        .logo
        {
            text-align:center;
            padding-top:78px;
        }
        .logo h1{
            font-size:200px;
            color: #000000;
            text-align:center;
            margin-bottom:1px;
            text-shadow:1px 1px 6px #464646;
        }
        .logo img
        {
            text-align:center;
            display: inline-block;
        }
        .logo p{
            color: #7e7e7e;
            font-size:30px;
            margin-top:1px;
            text-align:center;}
        .content-404 .p1
        {
        color: #51809d;
        font-family: roboto;
        font-size: 35px;
        font-weight: 400;
            margin:0px;
        }
        .content-404 .p2
        {
            color: #51809d;
            font-family: roboto;
            font-size: 35px;
            font-weight: 400;
            margin:0px;
           }
        .content-404 .p3
        {
            color: #51809d;
            font-family: roboto;
            font-size: 20px;
            font-weight: 400;
            margin: 25px 0;
        }
        .go_back a
        {
            background-color: #065aae;
            border-radius: 4px;
            color: #fff;
            display: inline-block;
            font-family: roboto;
            font-size: 28px;
            padding: 8px 33px;
        }
        .go_back a:hover {
        text-decoration:none;
            background:#004895;
        }
        .inner-logo{text-align: center;
            padding:4px 0px 4px 0px;
            background-color: rgba(255, 255, 255, 0.9);
            z-index: 9;
            -webkit-box-shadow:1px 1px 3px rgba(0, 0, 0, 0.8);
            -moz-box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.8);
            box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.8);
        }
        img{max-width:100%;}
    </style>
</head>
<body>
<div class="inner-logo"><a href = "{{ URL::asset('/') }}"><img src = "{{ URL::asset(getLogo()) }}"></a></div>
<div class="wrap">
    <div class="logo">
      <img src = "{{ URL::asset('images/not-found.png') }}">
        <div class = 'content-404'>
            <p class = 'p1'>Internal mechanism catastrophe, kindly operate with care! </p>
            <p class = 'p2'>.........also check if you can type.</p>
            <p class = 'p3'>On the other hand, the page you were looking for might not exist anymore, is deleted or has been moved.</p>
        </div>
        <div class = 'go_back'>
            <a href = "{{ URL::asset('/') }}">Go BACK HOME</a>
        </div>
    </div>
</div>
<!---728x90--->



</body>
</html>