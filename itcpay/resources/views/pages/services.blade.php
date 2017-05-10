@extends('layouts.master')
@section('content')
<div class="box box-info" style="margin-top:52px;">
    <div class="container">
        <div class="box-header with-border">
<!--            <h3 class="box-title">Merchant Services</h3>-->
        </div>
        <!--HEADER-->
        <div class="header">
            <div class="bg-color">
                <div class="wrapper">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 banner-info text-center">
                                <h2 class="bnr-sub-title">Services</h2>
                                <p class="bnr-para">{{ getSiteName() }} offers a ton of services, but the main one is its payment processing service. </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ HEADER-->
        <div class="row">
            <div class="col-md-12">
                <div class="main-sub-section-content">
                    <h4> </h4>
                    <p class="text-justify line-hieght">
                        {{ getSiteName() }} offers a ton of services, but the main one is its payment processing service,
                        which allows merchants to accept funds online. Customers do not have to have a Payments
                        Hub account to send you funds through {{ getSiteName() }}; they can pay you with their credit card
                        if they prefer.
                    </p>

                    The three main types of accounts {{ getSiteName() }} offers:
                    <ol>
                        <li>Merchant Services</li>
                        <li>Mass Payment Service</li>
                        <li>Individual Payment Services</li>
                    </ol>

                    <p class="text-justify line-hieght">
                        <b>Merchant Service - </b> Payment Hubs enables a business to accept a transaction payment through
                        a secure (encrypted) channel using the customer's credit card. Customers can purchase items
                        from websites either with credit card or with their {{ getSiteName() }} account.
                        {{ getSiteName() }} is an all-in-one credit card processing solution that offers flexible, low rates for
                        small businesses, startups and high-volume businesses as well. The service includes a merchant
                        account and a wide range of credit card processing options, including in-person, online and
                        mobile credit card processing. Whether you make sales in person, online, on the go or all of the
                        above, {{ getSiteName() }} has a credit card processing solution for you.
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>
@stop