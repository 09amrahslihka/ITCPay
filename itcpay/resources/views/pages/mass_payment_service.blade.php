@extends('layouts.master')
@section('content')
<div class="box box-info page-cms">
    <!-- HEADER-->
    <div class="mass_payment_header">
        <div class="section-shadow">
            <div class="wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 banner-info text-center">
                            <h2 class="bnr-sub-title">Mass Payment Service</h2>
                            <p class="bnr-para">{{ getSiteName() }} offers a mass payment service for big organizations.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ HEADER-->
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="main-sub-section-content">
                    <div class="text-cms">
                        <p>
                            With {{ getSiteName() }} mass payment service, you can send multiple payments in a single batch.
                            All you need to do is to get permission from {{ getSiteName() }} to use Mass payments.
                            You just have to submit the payment information with {{ getSiteName() }} in the form of a Payment File and {{ getSiteName() }} will process each payment and will notify you when it is complete.
                            {{ getSiteName() }} offers a mass payment service for big organizations.
                            With our Mass payment service, companies can pay thousands of their employees, contractors regularly.
                        </p>
                        <p>
                            Faster and easier than check runs, our online mass payment solution enables you to make payments to anyone with an email address in minutes.
                            Your recipients can set up a {{ getSiteName() }} account (free of charge), and you can deposit money into it.
                            If you have a business account, depending on the turnover of your business, we can give you special offer packages, once the site is connected; contact support/customer service and give us information about your current and expected turnover in the near future.
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="text-cms no-margin">
                                <p class="about-head">Key Benefits of Mass Payment Service</p>
                                <ol>
                                    <li>The age of paper payment is over, you can just send a Mass payment to multiple people at once.</li>
                                    <li>Payments can be sent to several countries.</li>
                                    <li>Faster than any other payment processing method.</li>
                                    <li>Payment is delivered lightning fast to recipient online.</li>
                                    <li>Fees is applicable only when you send a payment.</li>
                                    <li>{{ getSiteName() }} service is free for recipients. 	</li>
                                    <li>Charges or fees applicable is very much affordable and rest assured will be easy on your pocket.</li>
                                    <li>Convenient, cost effective and flexible for users, what more could anybody want from a Payments transfer service.</li>

                                </ol>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="img-object clearfix align-benefits">
                                <img src = "{{ URL::asset('images/benefits.jpg') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop