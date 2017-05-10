@extends('layouts.master')
@section('title', 'Developers')
@section('content')
<div class="box box-info" style="margin-top:52px;">
    <div class="container">
        <div class="box-header with-border">
            <h3 class="box-title">{{ getSiteName() }} Developer Documentation</h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="main-sub-section-content">
                    <h4> </h4>
                    <p>
                        {{ getSiteName() }} offers the advantage of its numerous developer tools to build the perfect store
                        with all the features you need, for one flat price. {{ getSiteName() }} has live phone support, offers
                        lower transaction rates for higher-volume merchants, and is easier for basic (non-developer)
                        users to get started with.
                    </p>

                    <p>
                        If you have developing experience and want to build a customized online storefront or an Apple
                        Pay-enabled mobile payment app, {{ getSiteName() }} is the right choice. Keep in mind that you can
                        always add one of these processors as a payment option in addition to your current processor,
                        so as to allow customers to pay with {{ getSiteName() }}. {{ getSiteName() }} actively works to protect
                        your transactions from fraudulent charges and monitors suspicious and unsafe transactions.
                    </p>

                    <p>
                        {{ getSiteName() }} helps platforms offer fully integrated payments with trust, security and safety.
                        We design exclusively for the unique use cases of platforms facilitating commerce between
                        multiple parties. With clean and complete APIs, {{ getSiteName() }}’s thoughtful interfaces and
                        abstractions can handle your company’s needs — from storing cards and processing
                        subscriptions to powering marketplaces and everything in between.
                    </p>
                    <p>
                        API calls are grouped below based on the top 3 elements of the payments user experience that
                        you can create with {{ getSiteName() }}.
                    </p>
                    <ol>
                        <li>
                            <p>
                                <b>Account Creation - </b> Account Creation is where you seamlessly create payment accounts
                                for the merchants on your platform. They can then immediately start accepting
                                payments with little to no friction (depending on the option you choose). The two high
                                level options are:
                            </p>
                            <p>
                                <b>OAuth2 Creation:</b> using an OAuth2 popup, users can simply create a payment account
                                with only four fields.
                            </p>
                            <p>
                                <b>Custom Creation:</b> using the /user/register API calls, you create an account for the
                                merchant literally behind the scenes. Then {{ getSiteName() }} completes account creation
                                later through an email authorization from the merchant but the merchant can get going
                                with accepting payments immediately.
                            </p>
                        </li>

                        <li>
                            <p>
                                <b>Processing Payments - </b> Processing payments entails making API calls that facilitate
                                payments from payers to merchants on your platform. This can be seamlessly done on
                                your platform with two flexible options:
                            </p>
                            <p>
                                <b>With Embedded Checkout, </b> you can minimize PCI compliance responsibilities and collect
                                payment information within a co-branded iframe.
                            </p>
                            <p>
                                <b>With Custom Checkout, </b> your platform collects payment information within your own
                                custom-branded form, and tokenizes credit cards for later use.
                            </p>
                        </li>

                        <li>
                            <p>
                                <b>Facilitating Withdrawals - </b> Facilitating Withdrawals is where you help the merchant
                                provide the required Know Your Customer (KYC) information so that they may receive
                                their money and withdraw their funds collected from payers.
                            </p>
                            <p>
                                <b>Embedded Withdrawal: </b> using an embedded iframe form, collect the required
                                information from the merchant within your user experience
                            </p>
                            <p>
                                <b>Settlement: </b> learn about {{ getSiteName() }} reserve policy and how the flow of funds works.
                            </p>
                        </li>
                    </ol>

                    <p>
                        {{ getSiteName() }} is just as feature-packed a payment platform and also offers developer tools.
                        These APIs (application programming interfaces) allow developers to easily build on the basic
                        {{ getSiteName() }} framework. What’s more in these additional features isn’t part of a separate
                        service and fee scheme; with {{ getSiteName() }}, you pay one flat rate for everything. Your options
                        are only limited by the abilities of your developer.
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>
@stop