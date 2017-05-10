@extends('layouts.master')
@section('content')
<div class="box box-info page-cms">
    <!-- HEADER-->
    <div class="individual_payment_header service">
        <div class="bg-color">
            <div class="section-shadow">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 banner-info text-center">
                            <h2 class="bnr-sub-title">Individual Payment Service</h2>
                            <p class="bnr-para">{{ getSiteName() }} offers individual payments service.
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
                    <div class="text-cms no-margin">
                        <p>
                            With {{ getSiteName() }} individual payment service, individuals can send money both to friends and families as personal payment (e.g. for shared rentals) or send
                            payment for goods or services. Payments can be made with credit/debit cards. U.S. users can send payment with U.S. checking bank account as well.
                        </p>
                        <p>
                            Individuals can send money to each other (an individual's account to another individual's account by using the Send payment page here on {{ getSiteName() }}.
                            You will see the "Send" page only after you are logged in as an account holder) either as personal payment (payment for friends and family, e.g. shared rentals)
                            or for goods or services.
                        </p>
                        <p>
                            With {{ getSiteName() }}, individuals can shop and pay online, or for example you were the one who paid for that office party at that time, your colleagues can send you money through {{ getSiteName() }} individual payment service.
                            Before transferring the money, both of you need to make sure you have a {{ getSiteName() }} account.
                        </p>
                        <p>
                            Simply create an account on {{ getSiteName() }} for free, make sure the receiver has an account here as well. Go to the “Send page”, fill in the shown details like ‘email address of the receiver’ etc. Select the payment type and amount, and you are good to go. Finally click on the “Send” button.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop