@extends('User.dashboard.layouts.master')
@section('title', 'Avoiding Chargebacks')
@section('content')
<div class="box box-info" <?php if(!isset(Auth::user()->id)) { ?> style="margin-top:52px;" <?php } ?>>
    <div class="container">
        <div class="box-header with-border">
            <h3 class="box-title">Avoiding Chargebacks</h3>
        </div>
        <div class = 'row'>
            <div class="col-md-12">
                <div class="main-sub-section-content about_us_content">
                    <p>Return of funds to a consumer is known as a Chargeback. It comes into play when a consumer requests issuing bank to make a payment reversal. How to avoid it? Our specialized team at {{ getSiteName() }} is here to help you resolve unwanted chargebacks and ensures seller protection against chargebacks for eligible payments.</p>
                    <p><b style="font-size:18px;">Why it happens:</b></p>
                    <ol class="order_item">
                        <li>Customer claiming that they never received the goods as promised by seller.</li>
                        <li>Item description was wrong or damaged product was received.</li>
                        <li>Customer claims for ID theft.</li>
                    </ol>
                    <p><b style="font-size:18px;">Here’s how we do things:</b></p>
                    <ol class="order_item">
                      <li> First and foremost you will be notified about a chargeback and we will team up with your to resolve things out. Funds will be frozen till complete resolution of the chargeback with you.</li>
					  <li> We will make a case on your behalf to the credit card company. On your part, you have to submit supporting documentation and evidence required to build your case.</li>
                      <li> We will unfreeze amount only if it satisfies seller protection.</li>
					</ol>
                    <p><b style="font-size:18px;">General Chargeback Prevention Measures You Should Take</b></p>
                    <ol class="order_item">
                        <li>Makes sure you provide your complete contact information such that buyers are able to communicate with you before they take some drastic step.</li>
                        <li>Be quick and steadfast in responding to buyer queries and answering questions. If the buyers feel that you are ignoring them than that can lead to a dispute or a chargeback as well.</li>
                        <li>Make sure you have exhausted all options on your own to resolve the dispute with the buyer before the buyer transfers it to {{ getSiteName() }} and the credit card company.</li>
                        <li>Make sure your website states crystal clear refund and return policies.</li>
                        <li>Item details should be exact such as to minimize future returns and chargebacks.</li>
                        <li>Any refunds should be issued through us. Any sort of outside settlement won’t come under our policies and we are not responsible in any way for the consequences for the same.</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@stop