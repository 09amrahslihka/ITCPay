@extends('layouts.master')
@section('title', 'Merchant Services')
@section('content')
<div class="box box-info page-cms">
    <!--HEADER-->
    <div class="header">
        <div class="bg-color">
            <div class="section-shadow">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 banner-info text-center">
                            <h2 class="bnr-sub-title">Merchant Services</h2>
                            <p class="bnr-para">{{ getSiteName() }} offers a smooth and streamlined payment processing service. </p>
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
                            Any of you merchants out there have the ability to integrate with {{ getSiteName() }} API with your website, then you will be able to accept either credit card payments or {{ getSiteName() }} payments in your website.
                            This means the buyer can either pay with credit cards (if he doesn't have {{ getSiteName() }} account) or he can pay with his {{ getSiteName() }} account by entering {{ getSiteName() }} email and password.
                        </p>
                        <p>
                            Processing payments is a science we have perfected here with {{ getSiteName() }}.
                            We strive to provide each and every one of the merchants associated with us with easy payment solutions to meet their needs.
                            {{ getSiteName() }} offers its total commitment towards customer satisfaction and with a veteran team in our offices dedicated towards growing with {{ getSiteName() }}, we ensure that we will provide you with the best Merchant Services in the business.
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="text-cms no-margin">
                                <p class="about-head">Some significant features of our merchant service:</p>
                                <ol>
                                    <li>Online sellers with {{ getSiteName() }} will be able to accept either credit card payments or {{ getSiteName() }} payments done through {{ getSiteName() }} accounts after integrating with our Payments API on their website.</li>
                                    <li>{{ getSiteName() }} is an all-in-one credit card processing solution which offers flexible budget friendly rates for businesses of every length and scale.  </li>
                                    <li>{{ getSiteName() }} also provides you with easy-to-do electronic payment transactions for merchants. This constitutes of procuring sales data from the merchant, getting approval for the transaction and gathering funds from the bank of the user and finally sending payment to the merchant.</li>
                                    <li>We provide you with 24x7 support from our veteran support staff who are experts in resolving cross-border intricacies related to payments.</li>
                                    <li>Lightning fast payment processing such that it reaches you hassle free at the earliest.</li>
                                    <li>With 24-hour monitoring of payment transactions, rest assured you are well protected at no extra charge.</li>
                                    <li>No hidden costs.</li>
                                </ol>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="img-object clearfix align-benefits">
                                <img src = "{{ URL::asset('images/merchant-service.jpg') }}">
                            </div>
                        </div>
                    </div>
				</div>
            </div>
        </div>
    </div>
</div>
@stop