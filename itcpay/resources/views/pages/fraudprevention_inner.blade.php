@extends('User.dashboard.layouts.master')
@section('title', 'Fraud Prevention')
@section('content')
    <div class="box box-info" <?php if(!isset(Auth::user()->id)) { ?> style="margin-top:52px;" <?php } ?>>
        <div class="container">
            <div class="box-header with-border">
                <h3 class="box-title">Fraud Prevention</h3>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="main-sub-section-content">
                        <p>Payment Hub covers its basics and is very strict on covering as much ground as possible for securing safe thorough-way of its financial transactions. We keep an overview on every transaction that goes through us round the clock. We have our own department constituting a strong team of veteran IT professionals who make sure payment transactions are as safe and secure as they can get.</p>
                        <p>Preventing frauds is a process distributed in three areas:</p>
                        <p><b style="font-size: 18px;">Fraud Preventive Security features: </b></p>
                        <ol>
                            <li><b>Account Verification - </b>We have a strict KYC (know your customer) policy. This ensures our users account security. We have steps in place to always verify new members their banking information and their identity. </li>
                            <li><b>128-bit SSL Encryption – </b>We have secure socket layer encryption (SSL) of 128 bits in place making sure that your financial and personal data is secure.</li>
                        </ol>
                        <p><b style="font-size: 18px;">Password Protection :</b> Make sure you have a strong password in place such that it cannot be easily cracked by hackers or any other miscreants. Here are characteristics of a strong password:</p>
                        <ol>
                            <li><b>Password Length – </b> At least 8 characters, the longer it is the better.</li>
                            <li><b>Density –  </b> Use alpha-numeric, special characters and lower-upper case constituted password to make it less prone to hacks.</li>
                            <li><b>Variety – </b>Use a different set of passwords for every account that you have online. This will ensure cracking of one doesn’t makes other ones vulnerable.</li>
                            <li><b>Change - </b>Keep changing your password regularly, this will help in keeping your personal information secure even if your password is discovered at some point.</li>
                        </ol>
                        <p><b style="font-size: 18px;">Reporting: </b></p>
                        <p>Make sure you report any suspicious seeming attempt on your account security which makes you feel that your account might be compromised even slightly.</p>
                        <p>There can be a number of reasons which will make your account seem vulnerable to you. Here are some of them:</p>
                        <ol>
                            <li>Receiving a suspicious email from {{ getSiteName() }} asking for your email password or prompting you to click on a suspicious looking link. We will never ask for your personal information like this.</li>
                            <li>If you ever find a classified ad requesting you to pay through by {{ getSiteName() }}.</li>
                            <li>If you find a website claiming to offer you some Payment Hub reduction in charges offers or passwords.</li>
                            <li>If you think you need immediate assistance and have spotted a viable threat to your account security in the slightest possible manner (unwanted access or transaction placed from your account etc.) you can contact our customer support.</li>
                        </ol>
                    </div>
                </div>
            </div>
            <br />
        </div>
    </div>
@stop