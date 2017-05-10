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
                        <h3 class = 'main_heading'>Fair fees for you</h3>
                        <h3 class = 'sub_hedaing'>With {{ getSiteName() }} you can buy for free. No per month fees for cancellation when you sell with us. Pay us when you make a sale.</h3>
                        <h2>1) Fees for sending money:</h2>
                        <p>a) Payments for goods or services:</p>
                        <ul>
                            <li>Domestic payments</li>
                            <li>With account balance: No fee</li>
                            <li>International payments</li>
                            <li>With account balance: 2%</li>
                        </ul>
                        <p>b) Personal payments (payments to friends and family)</p>
                        <ul>
                            <li>Domestic payments</li>
                            <li>With account balance: No fee</li>
                            <li>International payments</li>
                            <li>With account balance: 2%</li>
                        </ul>
                    </div>
                </div>
                <div class = "col-md-12">
                    <div class = "fee_section">
                        <h3 class = 'main_heading'>Payments made simpler</h3>
                        <h3 class = 'sub_hedaing'>We have the most competitive rates in the business and most importantly we don’t charge any hidden fees. We work with complete transparency with our users. With {{ getSiteName() }} you don’t have to pay anything till you sell anything. </h3>
                        <br />
                        <h2>2) Withdrawal fees</h2>
                        <ul>
                            <li>Withdraw to bank account:</li>
                            <li>US, Canada, UK, SEPA countries, Australia, New Zeland: Free</li>
                            <li>India, Philippines, Mexico, Japan, Malaysia: $1.50</li>
                            <li>Other countries: $4.50</li>

                            <li style="margin-top: 10px;">Withdraw to card:</li>
                            <li>$4.00</li>
                        </ul>
                    </div>
                </div>


                <div class = "col-md-12">
                    <div class = "fee_section">
                        <h2>3) Fees for receiving money</h2>
                        <ul>
                            <li>Domestic payments</li>
                            <li>With account balance: No fee</li>
                        </ul>
                    </div>
                </div>

                <div class = "col-md-12">
                    <div class = "fee_section">
                        <h2>4) Currency Conversion Fee</h2>
                        <p>For all transactions involving currency conversion, we charge a fee of 2.50%. What we at {{ getSiteName() }} do is we make it a point to keep you notified about exchange rate, which includes this fee before adding it to your total purchase amount.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop