@extends('layouts.master')
@section('title', 'FAQs')
@section('content')
    <div class="box box-info" <?php if(!isset(Auth::user()->id)) { ?> style="margin-top:52px;" <?php } ?>>
        <div class="container">
            <div class="box-header with-border">
                <h3 class="box-title">FAQs</h3>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                    <?php $counter=1; ?>
                                        Q{{$counter}}. What is {{ getSiteName() }}?
                                        <i class="indicator glyphicon glyphicon-minus  pull-right"></i>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse">
                                <div class="panel-body">
                                    {{ getSiteName() }} is a precision tool made for payment operations in global commerce which connects businesses, countries and professionals with their respective currencies. **(Currently, all transactions are being dealt with in USD and we are planning to make a push for other currencies in future).** With ITCPay, you can get paid and can pay more easily.
                                </div>
                            </div>
                        </div>
                        <?php $counter++; ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                        Q{{$counter}}. What is a Personal Account?
                                        <i class="indicator glyphicon glyphicon-plus  pull-right"></i></a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse">
                                <div class="panel-body">
                                    Personal accounts are for individuals who want to pay and spend online.
                                </div>
                            </div>
                        </div>
                        <?php $counter++; ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                        Q{{$counter}}. What is a business account?
                                        <i class="indicator glyphicon glyphicon-plus pull-right"></i>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse">
                                <div class="panel-body">
                                    This account type is for merchants using a company or group name to buy or sell online.
                                </div>
                            </div>
                        </div>
                        <?php $counter++; ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                                        Q{{$counter}}. How can I keep track of my transactions and what is the level of security you can provide?
                                        <i class="indicator glyphicon glyphicon-plus pull-right"></i> </a>
                                </h4>
                            </div>
                            <div id="collapseFour" class="panel-collapse collapse">
                                <div class="panel-body">
                                    We provide a broad range of built-in security features covering all your transactions and personal data details. With your personal dashboard, which you will see after you log-in to your account, you will be fully apprised about your recent transactions, Cards, Bank Accounts, Send Payment, Withdraw money and will be able to see all of your transaction history. We are always up-to-date with our protective measures and we keep improving them on a daily basis, rest assured, you are in the safest hands possible when you are with us.
                                </div>
                            </div>

                        </div>
                        <?php $counter++; ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
                                        Q{{$counter}}. How quickly is the money transferred through {{ getSiteName() }}?
                                        <i class="indicator glyphicon glyphicon-plus pull-right"></i> </a>
                                </h4>
                            </div>
                            <div id="collapseFive" class="panel-collapse collapse">
                                <div class="panel-body">
                                    Our send payment section is an instant real-time electronic funds transfer service which makes sure the recipient gets it as soon as it is sent.
                                    All you need to do as the sender is to enter details and click “Submit”. Voila!
                                </div>
                            </div>
                        </div>
                        <?php $counter++; ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseSix">
                                        Q{{$counter}}. How do I sign up?
                                        <i class="indicator glyphicon glyphicon-plus pull-right"></i> </a>
                                </h4>
                            </div>
                            <div id="collapseSix" class="panel-collapse collapse">
                                <div class="panel-body">
                                    Just click on the Sign Up option which is at the right hand side top of the page on our website home page. You will be prompted to select an account type between Personal and Business and immediately after that a sign up form will appear. Fill out your details including your mobile number, address, name etc. and click on the “Sign-Up button”. You will receive an email from us asking you to verify your email. Go to your inbox, click on the email from us and follow instructions.
                                </div>
                            </div>
                        </div>
                          <?php $counter++; ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven">
                                        Q{{$counter}}. How can I add a card with my {{ getSiteName() }} account?
                                        <i class="indicator glyphicon glyphicon-plus pull-right"></i> </a>
                                </h4>
                            </div>
                            <div id="collapseSeven" class="panel-collapse collapse">
                                <div class="panel-body">
                                    You can add a card by going to the "Cards" page and click on the "Add a Card" button.
                                    After adding a card, a new "Authenticate card" link appears in "Cards" page. You have to visit "Authenticate card" page and submit documents to authenticate the card.
                                </div>
                            </div>
                        </div>
                        <?php $counter++; ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseEight">
                                        Q{{$counter}}. How can I upgrade my account?
                                        <i class="indicator glyphicon glyphicon-plus pull-right"></i> </a>
                                </h4>
                            </div>
                            <div id="collapseEight" class="panel-collapse collapse">
                                <div class="panel-body">
                                    You can see an “Upgrade account” link at the home page. Just click on that link submit your business name and address (Only for personal accounts to be converted to business accounts).
                                </div>
                            </div>
                        </div>
                          <?php $counter++; ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse13">
                                        Q{{$counter}}. How can I downgrade my account?
                                        <i class="indicator glyphicon glyphicon-plus pull-right"></i> </a>
                                </h4>
                            </div>
                            <div id="collapse13" class="panel-collapse collapse">
                                <div class="panel-body">
                                     If you want to downgrade your business account to personal account you can always do it by following some simple steps. Log in to you account. In home page you will find "Downgrade link". Click on  "Downgrade link". Click on yes on confirmation box. You are done.
                                    Second way is, click on "My Account" you will get "Business Information" page if you are a business account holder. Now click on "Downgrade Account". click on yes. A success message will appear. 
                                </div>
                            </div>
                        </div>
                        @if($verification[0]->value==1)
                          <?php $counter++; ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseNine">
                                        Q{{$counter}}. How can I verify my account?
                                        <i class="indicator  glyphicon glyphicon-plus pull-right"></i> </a>
                                </h4>
                            </div>
                            <div id="collapseNine" class="panel-collapse collapse">
                                <div class="panel-body">
                                    Every account starts with an "Unverified" status. You can click on "Get verified" link from Home page in order to get this account verified. You will have two options for account verification. Either "Add a card to your account" or "Submit ID verification documents" to get your account verified.
                                    <br />
                                    <br />
                                    Furthermore, you can either add a card and submit card photo and photo ID or submit identity verification documents. You can block out 1st 12 digits of card number and CVV in the card photo. About identity verification process, personal accountholders can submit “Photo ID” and “Address proof” document.
                                    <br />
                                    <br />
                                    Business accountholders needs to submit “Business registration proof” , “Business address proof”  document, “shareholders details” document in addition to the accountholder's “photo ID” and “personal address proof”  document for identity verification.
                                </div>
                            </div>
                        </div>
                        @endif
                          <?php $counter++; ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTen">
                                        Q{{$counter}}. How do I update my account information?
                                        <i class="indicator glyphicon glyphicon-plus pull-right"></i> </a>
                                </h4>
                            </div>
                            <div id="collapseTen" class="panel-collapse collapse">
                                <div class="panel-body">
                                    The user can change password, mobile number, time zone  from "My Account" section. You have to contact our “Support Team” for updating any email address, name and address and other personal details.
                                </div>
                            </div>
                        </div>

                          <?php $counter++; ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseEleven">
                                        Q{{$counter}}. How can I withdraw my money?
                                        <i class="indicator  glyphicon glyphicon-plus pull-right"></i> </a>
                                </h4>
                            </div>
                            <div id="collapseEleven" class="panel-collapse collapse">
                                <div class="panel-body">
                                    You can withdraw your money to bank account as well as to card*. First you have to add your bank account details or card details. You can do this by clicking "Bank accounts" Menu and then click on "Add Bank Account". For cards you can click on "Cards" and then "Add a card". After adding Card or Bank account you can go to "Withdraw Money" to transfer your money.  
                                <br/>
                                <br/>
                                *Note:Only US users can not withdraw money to card.
                                </div>
                            </div>
                        </div>


                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse12">
                                        Q{{$counter}}. How can I pay with my Bank Account ?
                                        <i class="indicator glyphicon glyphicon-plus pull-right"></i> </a>
                                </h4>
                            </div>
                            <div id="collapse12" class="panel-collapse collapse">
                                <div class="panel-body">
                                    In order to pay with a bank account, you need to add an US checking bank account, verify the bank account by entering online banking login credentials and verify yours (accountholder's) identity by providing SSN and Driver's License number. Only US accountholders can pay with bank account and not accountholders from other countries.
                                </div>
                            </div>
                        </div>


                        {{-- <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse13">
                                        Q13. Some things we would like to say
                                        <i class="indicator glyphicon glyphicon-plus pull-right"></i> </a>
                                </h4>
                            </div>
                            <div id="collapse13" class="panel-collapse collapse">
                                <div class="panel-body">
                                    We would love to hear from you even if it’s a query or you just want to give us a pat on our back for great services rendered. You can get in touch with us through submitting a ticket or calling us at our Support center number mentioned on our “Support” page.
                                </div>
                            </div>
                        </div> --}}

                        

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleChevron(e) {
            $(e.target)
                    .prev('.panel-heading')
                    .find("i.indicator")
                    .toggleClass('glyphicon glyphicon-plus glyphicon glyphicon-minus');
        }
        $('#accordion').on('hidden.bs.collapse', toggleChevron);
        $('#accordion').on('shown.bs.collapse', toggleChevron);
    </script>
@stop