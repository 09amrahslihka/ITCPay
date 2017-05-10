@extends('User.dashboard.layouts.master')
@section('title', 'Avoiding Phishing Emails')
@section('content')
<div class="box box-info" <?php if(!isset(Auth::user()->id)) { ?> style="margin-top:52px;" <?php } ?>>
    <div class="container">
        <div class="box-header with-border">
               <h3 class="box-title">Avoiding Phishing Emails</h3>
        </div>
        <div class = 'row'>
            <div class="col-md-12">
                <div class="main-sub-section-content about_us_content">
                    <p>Anything online carries with itself some sort of vulnerability which sooner or later will be exploited by hackers and cybercriminals and you can’t just have enough of preventive measures in place. Phishing is one of the most common threat. </p>
                    <p>Phishing makes it very difficult for users to know whether an email that you received is actually from a legal source or a hacker trying to get your personal information or data. The emails will look as genuine as they come. The best thing to do in such a case when you receive an unwanted email is to make sure you don’t click on any of the links or attachments. Mark it spam.</p>
                    <p>1.) For doubtful websites, make sure there is “https” mentioned preceding any URL. The “s” stands for secure.</p>
                    <p>2.) For suspicious emails never click on any link or change in password option. Just mark it as spam.</p>
                    <p><b style="font-size:18px;">Some extra tips:</b></p>
                    <ol class = 'order_item'>
                        <li>Make sure you setup an exclusive email account for your sales and customer service.</li>
                        <li>No personal details whatsoever should be mentioned in the background of pictures related to products.</li>
                        <li>Backup your mobile device for saving important information time after time.</li>
                        <li>When prompted or choosing to install new apps, check its rating and credibility. Malicious apps installation is a data theft nightmare.</li>
                        <li>Keep a PIN or a lock function activated on your mobile device.</li>
                        <li>Read articles online for more information and details regarding how to spot phishing emails and know its telltale signs.</li>
                        <li>{{ getSiteName() }} will never ask for your following information in its emails.
                            <ul class = 'order_item'>
                                <li>Credit and debit card numbers</li>
                                <li>Bank account numbers</li>
                                <li>Driving license numbers</li>
                                <li>Email addresses</li>
                                <li>Passwords</li>
                                <li>Your full name</li>
                            </ul>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@stop