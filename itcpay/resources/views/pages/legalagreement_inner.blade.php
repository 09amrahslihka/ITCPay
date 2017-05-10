@extends('User.dashboard.layouts.master')
@section('title', 'Legal Agreement')
@section('content')
    <div class="box box-info"  style="margin-top:52px;">
        <div class="container">
            <div class="box-header with-border">
                <h3 class="box-title">Legal Agreement</h3>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="main-sub-section-content about_us_content">
                        <p><b style="font-size:18px;">Welcome to {{ getSiteName() }}!</b></p>
                        <p>
                            This is a legal contract between you and {{ getSiteName() }} which governs your use of {{ getSiteName() }} and its services. Using {{ getSiteName() }} and its services means that you accept all of its Terms and Conditions contained in this Agreement.  You should read all of these terms carefully.
                        </p>
                        <p>
                            We may change the agreement at any time and post a revised version as per our discretion. The same updated revision will be effective as soon as it gets posted on {{ getSiteName() }} website. If the revised version includes a substantial amount of change then you will be provided with a 30 days’ notice. All future changes that will be made in this “Legal Agreement” section of {{ getSiteName() }} website from the time you register are automatically stated as “accepted by the customer/user”.
                        </p>
                        <p>
                            <b>This is an important document which you must consider carefully when choosing whether to use the {{ getSiteName() }} Services. Please note the following risks of using the {{ getSiteName() }} Services:</b>
                        </p>
                        <p>
                            <b>Payments received in your Account may be reversed at a later time, for example, if a payment is subject to a Chargeback, Reversal, Claim or is otherwise invalidated. This means that a payment may be reversed from your Account after you have provided the sender the goods or services that were purchased.</b>
                        </p>
                        <p>
                            <b>We may close, suspend, or limit your access to your Account or the {{ getSiteName() }} Services, and/or limit access to your funds if you violate this Agreement, or any other agreement you enter into with {{ getSiteName() }}.</b>
                        </p>
                        <p>
                            <b>You are solely responsible for understanding and complying with any and all laws, rules and regulations of your specific jurisdiction that may be applicable to you in connection with your use of the {{ getSiteName() }} Services, including but not limited to, those related to export or import activity, taxes or foreign currency transactions.</b>
                        </p>
                        <p>
                            <b>This Agreement is not a solicitation of the {{ getSiteName() }} Services and {{ getSiteName() }} is not targeting any country or market through this Agreement.</b>
                        </p>
                        <p><b style="font-size:18px;">1. Eligibility</b></p>
                        <ol class = 'oder_item'>
                            <li>You must be at least 18 years and older for being eligible to avail {{ getSiteName() }} services. </li>
                            <li>{{ getSiteName() }} is a payment service provider and it acts as such by creating, hosting, maintaining and providing our {{ getSiteName() }} services to you through the Internet. Our services allow you to send payments to anyone with a {{ getSiteName() }} Account, and, where available, to receive payments. </li>
                            <li>Our main service is payment processing. As part of our Service, we will store information that you give us, including your Payment Instrument. We will use this information to process your payment through the appropriate Card network or bank. You may use our Service to purchase goods or services from Sellers. {{ getSiteName() }} provides payment processing and payment transaction settlement services to you, as the Buyer, and to the Seller. {{ getSiteName() }} does not provide you with credit. We are not a depository institution. </li>
                            <li>{{ getSiteName() }} is not a party to your purchase of any product or service from the Seller. {{ getSiteName() }} is not a Buyer or a Seller under your transaction with the Seller. {{ getSiteName() }} is an independent contractor between you and the Seller. {{ getSiteName() }} cannot control the goods or services provided by the Seller. {{ getSiteName() }} does not assume liability over the goods or services sold to you by the Seller.</li>
                            <li>You agree that there will be no fees or surcharges imposed by you for accepting {{ getSiteName() }} as your payment service. </li>
                            <li>We may conduct fraud and other background checks. We may delay the processing of Payment Transactions that appear suspicious or involve fraud or other misconduct. We may also delay the processing of Payment Transactions that are illegal or violate the Payment Terms or other {{ getSiteName() }} policies.</li>
                        </ol>
                        <p><b style="font-size:18px;"> 2.) Required Information:</b></p>
                        <p>
                            Opening an account is simple with us, you just need to provide us with your latest updated information. Below is a description for the same:
                        </p>
                        <p>
                            <b>Verify your Identity - </b>{{ getSiteName() }} may ask you for documentation for verifying your identification and you have to submit a SSN or National identification number for the same. {{ getSiteName() }} may require you to take steps to verify your email with us, ordering a credit report and we might verify your email against third party databases or through our own sources. You basically authorize {{ getSiteName() }} to make any inquiries considered necessary by us to validate your identity.
                        </p>
                        <p>
                            <b>Contact Information – </b> Make sure your primary email address is a valid email address and is in working condition. {{ getSiteName() }} will not be responsible if we send you and electronic communication and you didn’t received it because of an incorrect, unverified, blocked or dormant or you use a spam filter which marks our email as spam, primary email address as mentioned in your file. {{ getSiteName() }} in any of these cases will be deemed to have provided the communication to you effectively.
                        </p>

                        <p><b style="font-size:18px;">3.) Payments:</b></p>
                        <p>
                            <b>Refunds - </b> Sending a payment from your side doesn’t means that the recipient is bound to accept it. If payment is refused or denied from the recipient it will be refunded back to your balance. Any payments which are not claimed will be returned to you in 30 days as well.
                        </p>
                        <p>
                            <b>Preferred payment method -</b> You have the option to select a preferred payment method each time you make a payment.
                        </p>
                        <p>
                            <b>Processing delay from merchant side –</b> Sending a payment to a merchant means that you are asking the merchant to approve of your payment and process it to complete the transaction. All payments which are not processed or approved by the merchant will be declared as pending. The processing time may vary from merchant to merchant. The authorization request for payment that you sent to the merchant will remain active till 30 days of its creation. If there is a currency conversion matter, the exchange rate will be evaluated when the merchant will process your payment and complete the transaction.
                        </p>
                        <p>
                            <b>Payment service for individuals from US:</b> If you have entered the country in the personal address section in “Sign up” page while creating the {{ getSiteName() }} account is United States (whether for personal or business account), the account will be considered as an US {{ getSiteName() }} account.
                        </p>
                        <p>
                            In order to add an US bank account to an US {{ getSiteName() }} account, the user will need to enter not only the routing number and account number of his checking bank account, but also the user ID and password of his online banking account. We only accept US checking bank accounts and not savings bank accounts. After the US user adds a checking bank account to his {{ getSiteName() }} account, he will be able to withdraw money to his checking bank account.
                        </p>
                        <p>
                            US users can also send money directly with their checking bank account.
                        </p>
                        <p>
                            Please note that we also use country specific validation program for bank account details. For example, we only accept 9 digit numeric routing number and 3-17 digit numeric bank account number for US bank accounts.
                        </p>
                        <p><b style="font-size:18px;">4.) Money in user accounts:</b></p>
                        <p>
                            {{ getSiteName() }} holds your funds separately and stores it separately from its own operating or expense funds. We will never of our own accord in any case give access to your funds to creditors in case of bankruptcy. As we are not a bank we will not provide you with any sort of interests or earnings on your balance amount on {{ getSiteName() }}. Although {{ getSiteName() }} may receive interest on amounts that Payment Hub holds on your behalf. You acknowledge, agree and assign your rights to {{ getSiteName() }} for any interest derived from your funds.
                        </p>
                        <p>
                            <b>Due amounts –</b> If you have any due amounts to {{ getSiteName() }} or its affiliate, we may debit your account balance to pay any amounts which are past their due dates but not before 180 days have gone by without the payment.
                        </p>
                        <p>
                            <b>Negative Balances – </b>If your account has a negative balance, {{ getSiteName() }} may compensate for the negative balance with the amount you add later into your Payment hub account.
                        </p>
                        <p><b style="font-size:18px;">5.) Money withdrawal:</b></p>
                        <p>
                            You are able to make withdrawals to your bank account with {{ getSiteName() }}. Any user can withdraw money from his {{ getSiteName() }} account to his bank account by
                        </p>
                        <ol type="a">
                            <li>
                                Electronically transferring to your local account
                            </li>
                            <li>
                                Through your {{ getSiteName() }} initiated automatic transfer
                            </li>
                        </ol>
                        <p><b>Fees charged for withdrawal – </b>A certain withdrawal fees will be charged to you as mentioned on the Fees page on our website.</p>
                        <p><b>Limits to withdrawal – </b>Based upon the amount of verification being done by you for your account, for security purposes, we may limit your account money withdrawal ability. </p>
                        <p>**You can view your withdrawal limit by logging into your account**.</p>
                        <p>Also, big withdrawal requests might get delayed due to risk evaluation performed by us.</p>


                        <p><b style="font-size:18px;"> 6.) Deactivation/Account closure –</b></p>
                        <p>
                            {{ getSiteName() }} gives you the freedom to close your account anytime you want. You just have to contact our Support team and we can take it from there.
                        </p>
                        <p>
                            Pending transactions will be cancelled automatically and will not go through after you cancel your account and you will be denied access to any balances that you might have. It is highly recommended that you withdraw all your balance before you close your account.
                        </p>
                        <p>
                            Although you can close your account but if you are under any pending investigation from us, we have the right to freeze your account until the matter is resolved. You are liable to your account until the investigation or investigations are over even after you have closed your account.
                        </p>

                        <p><b style="font-size:18px;"> 7.) {{ getSiteName() }} Buyer Protection: </b></p>
                        <p>{{ getSiteName() }} secures all of its buyers interests. It resolves the following problems – </p>
                        <p>As a buyer when you haven’t received the exact item you paid for with {{ getSiteName() }}.  </p>
                        <p>When the item is not as was originally described:</p>
                        <ul>
                            <li>You received a completely different item.</li>
                            <li>The item was damaged. </li>
                            <li>Item was not authentic but was advertised as authentic.</li>
                            <li>Item was materially different from what was stated in item description. </li>
                            <li>Item is missing some of its parts.</li>
                            <li>You received less than the original item quantity you ordered.</li>
                            <li>Item damaged during shipping.</li>
                        </ul>
                        <p>Exceptions to above item not as originally described:</p>
                        <ul>
                            <li>Item received was the same as described by the seller but you didn’t wanted it anymore.</li>
                            <li>The item wasn’t as you originally anticipated it to be.</li>
                            <li>The item has minor tints and scratches.</li>
                            <li>The item defects were the same as described by the seller.</li>
                        </ul>
                        <p><b style="font-size:18px;">{{ getSiteName() }} buyer protection eligibility</b></p>
                        <ul>
                            <li>You have already stated your query to the seller and filed a ticket/dispute resolution with {{ getSiteName() }}. </li>
                            <li>Also the dispute must be filed in a 180 days’ timeframe from the day payment was done.</li>
                            <li>You haven’t received any response from the seller regarding your dispute resolution.</li>
                        </ul>
                        <p><b style="font-size:18px;">Payments for items not eligible for buyer protection</b></p>
                        <ul>
                            <li>Businesses of any sort.</li>
                            <li>Vehicles or aircrafts of any sort.</li>
                            <li>Gambling or gaming related. </li>
                            <li>Personal payments.</li>
                            <li>Payments on crowdfunding platforms.</li>
                            <li>Donations of any sort.</li>
                            <li>Gift cards etc.</li>
                        </ul>
                        <p><b style="font-size:18px;">8.) {{ getSiteName() }} seller protection:</b></p>
                        <p>Sellers are as secured as buyers on {{ getSiteName() }}. We deal in a fair policy with both. {{ getSiteName() }} provide protection to sellers from:</p>
                        <ol type="a">
                            <li>Non-valid Chargebacks</li>
                            <li>False buyer Claims</li>
                            <li>Money reversal</li>
                        </ol>
                        <p><b>Eligibility</b></p>
                        <p>Eligibility for seller protection includes – </p>
                        <ul>
                            <li>The address to which the product is sent should be as stated in the transaction details.</li>
                            <li>The item/product in question should be a physical good.</li>
                            <li>You must send any documents to {{ getSiteName() }} when asked for the same.</li>
                            <li>You must have a proof of delivery and you must send us the same in case of a dispute.</li>
                            <li>Make sure you have shipped the item in time originally stated by you.</li>
                        </ul>
                        <p><b>Items not eligible for Seller protection</b></p>
                        <ul>
                            <li>Products you have delivered personally to the buyer.</li>
                            <li>Any online service which you have provided which doesn’t includes any tangible items or products.</li>
                            <li>Any gift cards, vouchers etc. are not eligible.</li>
                            <li>Items which never got delivered to the buyer and got delivered to a different address due to any number of reasons.</li>
                        </ul>
                        <p><b style="font-size:18px;">9.) Restrictions we impose on both Buyers and Sellers:</b></p>
                        <p>When using {{ getSiteName() }}, interacting with its affiliates or users, you have to act, interact and agree in accordance to the points mentioned below.</p>
                        <p>Any violation from you side of terms and conditions or any other policies stated by {{ getSiteName() }} will result in strict legal action and cancellation of your account with us.</p>
                        <ul>
                            <li>You can’t perform any actions which can compromise our relationship with our affiliates, other users, business partners or ISP.</li>
                            <li>You cannot refuse co-operating with {{ getSiteName() }} when you are under investigation or during resolution of a dispute.</li>
                            <li>You cannot provide {{ getSiteName() }} with any false information.</li>
                            <li>You are not allowed to have a negative account balance.</li>
                            <li>You can’t perform any action which can be a threat to {{ getSiteName() }} security like hacking.</li>
                            <li>You are not allowed to have a credit score with a substantial risk factor associated with it.</li>
                            <li>You can’t disclose other users personal information to a third party without their consent.</li>
                            <li>You are not to sell any stolen or imitation products.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop