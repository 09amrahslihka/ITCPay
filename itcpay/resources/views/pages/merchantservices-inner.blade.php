@extends('layouts.master')
@section('title', 'Merchant Services')
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
                                <h2 class="bnr-sub-title">Merchant Services</h2>
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
                    <p class="text-justify line-hieght">
                        Processing payments is a science we have perfected here with {{ getSiteName() }}. Merchants can now customize the way they can receive payments. We know that your business is everything to you and it should be treated no less. We strive to provide each and every one of the merchants associated with us with easy payment solutions to meet their needs. We offer total commitment towards customer satisfaction and with a veteran team in our offices dedicated towards growing with {{ getSiteName() }}, we ensure that we will provide you with best Merchant Services in the business.
                    </p>
                    <p style = "font-size:18px;"><b>Salient Features of Merchant Services with {{ getSiteName() }}:</b></p>
                    <ol>
                        <li>Merchants can accept not only credit/debit card's payment, but also {{ getSiteName() }} payments in their websites.</li>
                        <li>If you need to invoice your client, we can do it for you. You just need to enter details of your payment request and we will make sure your client gets all the payment information they need to pay you. </li>
                        <li>{{ getSiteName() }} is an all-in-one credit card processing solution which offers flexible budget friendly rates for businesses of every length and scale.  </li>
                        <li>{{ getSiteName() }} provides you with easy-to-do electronic payment transactions for merchants. This constitutes of procuring sales data from the merchant, getting approval for the transaction and gathering funds from the bank of the user and finally sending payment to the merchant.</li>
                        <li>We provide you with 24x7 support from our veteran support staff who are experts in resolving cross-border intricacies related to payments.</li>
                        <li>Lightning fast payment processing such that it reaches you hassle free at the earliest.</li>
                        <li>With 24-hour monitoring of payment transactions, rest assured you are well protected at no extra charge.</li>
                        <li>No hidden costs.</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@stop