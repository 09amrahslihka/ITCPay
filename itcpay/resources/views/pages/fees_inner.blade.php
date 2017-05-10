@extends('User.dashboard.layouts.master')
@section('title', 'Fees')
@section('content')
    <div class="box box-info" <?php if(!isset(Auth::user()->id)) { ?> style="margin-top:52px;" <?php } ?>>
        <div class="container">
            <div class="box-header with-border">
                <h3 class="box-title">Fees</h3>
            </div>
            <div class="row">
                <div class = "col-md-12">
                    <div class = "fee_section">
                       <!--  <h3 class = 'main_heading'>Fair fees for you</h3> -->
                       <!--  <h3 class = 'sub_hedaing'>With {{ getSiteName() }} you can buy for free. No per month fees for cancellation when you sell with us. Pay us when you make a sale.</h3> -->
                        <h2 style="text-transform:initial">1) Fees for sending money:</h2>
                        <!-- <p>a) Payments for goods or services:</p> -->
                        <ul>
                            <li>Domestic payments</li>
                            <li style="margin-left: 40px;">With account balance: No fee</li>
                            <li style="margin-left: 40px;">With debit/credit card: 3%+$0.30</li>
                           
                        </ul>
                       
                        <ul>
                            <li>International payment:</li>
                            <li style="margin-left: 40px;">With account balance: 2%</li>
                            <li style="margin-left: 40px;">With debit credit card: 2%+3%</li>
                        </ul>
                    </div>
                </div>
                 <div class = "col-md-12">
                    <div class = "fee_section">
                        <!-- <h3 class = 'main_heading'>Fees for receiving money</h3> -->
                        <h2 style="text-transform:initial">2) Fees for receiving money</h2>
                        <ul>
                            <li>Personal payment (payment for friends and family): No fee</li>
                            <li>Payment for goods or service: 3%+$0.30</li>
                        </ul>
                       
                        
                    </div>
                </div>
                <div class = "col-md-12">
                    <div class = "fee_section">
                        <!-- <h3 class = 'main_heading'>Payments made simpler</h3> -->
                        <!-- <h3 class = 'sub_hedaing'>We have the most competitive rates in the business and most importantly we don’t charge any hidden fees. We work with complete transparency with our users. With {{ getSiteName() }} you don’t have to pay anything till you sell anything. </h3> -->
                        <br />
                        <h2 style="text-transform:initial">3) Withdrawal fee</h2>
                        <ul class="withdrawallist">
                            <li>Withdraw to bank account:</li>
                            <li style="margin-left: 40px;">US, Canada, UK, SEPA countries, Australia, New Zeland: Free</li>
                            <li style="margin-left: 40px;">India, Philippines, Mexico, Japan, Malaysia: $1.50</li>
                            <li style="margin-left: 40px;">Other countries: $4.50</li>
                            <li style="margin-top: 10px;margin-left: 40px;" >Withdraw to card: $4.00</li>
                            
                        </ul>
                    </div>
                </div>


                

                <div class = "col-md-12">
                    <div class = "fee_section">
                        <h2 style="text-transform:initial">4) Currency conversion fee</h2>
                        <p>For all transactions involving currency conversion, we charge a fee of 2.50%. </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop