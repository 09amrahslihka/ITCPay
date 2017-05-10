@extends('layouts.master')
@section('title', 'Our Services')
@section('content')
    <div class="box box-info" <?php if(!isset(Auth::user()->id)) { ?> style="margin-top:52px;" <?php } ?>>
        <div class="container">
            <div class="box-header with-border">
                <h3 class="box-title">Our Services</h3>
            </div>
            <div class = 'row'>
                <div class="main-sub-section-content">
                    <div class="col-md-12">
                        <div class = "our_service_1">
                            <p><b style="font-size:20px;">Mass Payment Service : </b> With {{ getSiteName() }} mass payment service you can send multiple in a single batch.
                            All you need to do is to get permission from {{ getSiteName() }} to use Mass payments. You just have to submit the payment information with {{ getSiteName() }} in the form of a Payment File and {{ getSiteName() }} will process each payment and will notify you when it is complete.</p>
                        </div>
                          <div class = "our_service_2">
                            <p>
                                <b style="font-size:20px;">Individual Payment Service: </b> With {{ getSiteName() }} individual payment service, individuals can send money both to friends and families as personal payment (e.g. for shared rentals) or send payment for goods or services.
                                Payments can be made with credit/debit cards. U.S. users can send payment with U.S. checking bank account as well.
                            </p>
                            <p class="text-justify line-hieght">
                                Just go to the "Send Page" and simply enter an email address of the recipient, the amount to be sent and also add details which will explain the payment request type.
                                Your account will be automatically updated as soon as the payment is done and the amount will be transferred to your local bank account on regular intervals as per {{ getSiteName() }} policies.
                                {{ getSiteName() }} has therefore, streamlined the entire process for you for getting payments easily.
                            </p>
                          </div>
                        <div class = "our_service_3">
                            <p class="text-justify line-hieght">
                                <b style="font-size:20px;">Merchant Services: </b> Processing payments is a science we have perfected here with {{ getSiteName() }}. Merchants can now customize the way they can receive payments. We know that your business is everything to you and it should be treated no less. We strive to provide each and every one of the merchants associated with us with easy payment solutions to meet their needs. We offer total commitment towards customer satisfaction and with a veteran team in our offices dedicated towards growing with {{ getSiteName() }}, we ensure that we will provide you with best Merchant Services in the business.
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
    </div>
@stop