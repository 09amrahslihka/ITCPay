@extends('layouts.master')
@section('title', 'Terms of Service')
@section('content')

<div class="box box-info" <?php if(!isset(Auth::user()->id)) { ?> style="margin-top:52px;" <?php } ?>>
<div class="container">
    <div class="box-header with-border">
    <h3 class="box-title">Terms of Service</h3>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="main-sub-section-content term_service">
            <h5><b>
                    Limitations of Liability. IN NO EVENT SHALL WE,  OUR PARENT, SUBSIDIARIES AND AFFILIATES, OUR OFFICERS, DIRECTORS, AGENTS, JOINT VENTURES, EMPLOYEES OR SUPPLIERS BE LIABLE FOR LOST PROFITS OR ANY SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES (INCLUDING WITHOUT LIMITATION DAMAGES FOR LOSS OF DATA OR LOSS OF BUSINESS) ARISING OUT OF OR IN CONNECTION WITH OUR WEBSITE, THE “{{ getSiteName() }}” SERVICES, OR THIS AGREEMENT (HOWEVER ARISING, INCLUDING NEGLIGENCE) UNLESS AND TO THE EXTENT PROHIBITED BY LAW OUR LIABILITY, AND THE LIABILITY OF  OUR PARENT, SUBSIDIARIES AND AFFILIATES, OUR OFFICERS, DIRECTORS, AGENTS, JOINT VENTURES, EMPLOYEES AND SUPPLIERS, TO YOU OR ANY THIRD PARTIES IN ANY CIRCUMSTANCE IS LIMITED TO THE ACTUAL AMOUNT OF DIRECT DAMAGES.
                </b>
            </h5>
            <h5><b>The Terms and conditions mentioned herein applies to “{{ getSiteName() }}” also referred herein as “we”, “us” or “our”, its officers, agents, directors, joint ventures, employees and suppliers and customer, user, member are referred to as “you”, “your”.
                {{ getSiteName() }} is not a banking institution but rather provides payment processing services. {{ getSiteName() }} is not acting as an escrow or trustee with respect to your funds but is acting only as an agent and custodian. {{ getSiteName() }} does not have any liability for the product and services paid through {{ getSiteName() }} services. Most importantly, we don’t guarantee or validate user identity or ensure that a seller or a buyer will complete the transaction.
                  </b></h5>
                <p class = 'heading'><b>1.) Eligibility:</b></p>
                <p>
                    If you want to use our service, you have to register through our website for a Personal or Business account.
                    Both sellers and buyers of products and services can use this service.
                    Exceptions will be of course stated separately wherever necessary as per the discretion of {{ getSiteName() }}.
                    Also, you have to agree that any information you give to us “User information” provided will stay in our records unless otherwise agreed upon.
                </p>

                <p class = 'heading'><b>
                2.) No Warranty:
                    </b></p>
                <p>{{ getSiteName() }} and its services are “As Is” and they don’t under any circumstances or situation are representation of warranty whether express, implied or statutory. “We” specifically disclaim any sort of warranties (Title, Merchantability and Non-Infringement).

                {{ getSiteName() }} have no control whatsoever over the services or products paid for by using {{ getSiteName() }} services. “We” also don’t guarantee/warranty that any or all users, buyers or sellers will have continuous, secure and uninterrupted access to any part of Payment Hub services.
                </p>
                <p><b>
                    By visiting and registering with our website you automatically declare that you agree with our Terms and conditions which includes you agreeing to defend and not to hold {{ getSiteName() }}, its workers, officers, affiliates, management and directors responsible for any sort of loss (whether financial or mental). You also agree that {{ getSiteName() }}, its workers, officers, affiliates, management and directors will not be in any circumstances or situations will be liable to pay any sort of compensation by using {{ getSiteName() }}.
                    </b>
                </p>
                <p class = 'heading'><b>
                3.) Liability:
                </b></p>
                <p>
                In case you don’t report any unauthorized transactions in your {{ getSiteName() }} account, you yourself are liable for any consequences (damages, fines) occurring thereafter. Rest assured, we will do our best to rectify the situation but in any circumstance if we are unable to do just that, you will be the one to assume total responsibility for the loss occurred.
                </p>
                <p class = 'heading'><b>
                4.) Intellectual Property:
                    </b></p>
                <p>
                All identification and brand identity marks including URL’s, Logos and trademarks related to {{ getSiteName() }} and {{ getSiteName() }} services are either trademarks or registered trademarks of {{ getSiteName() }} or its licensors and are not to be used, copied or imitated in any way without {{ getSiteName() }}’s written consent. In addition to this, same is applicable to all page headers, custom graphics, buttons, icons, scripts, service marks etc. You will not in any way copy, imitate or use them in any way prior a written consent given {{ getSiteName() }}.
                </p>
                <p class = 'heading'><b>
                5.) Contacting you:
                    </b></p>
                <p>
                By providing us with a contact number (mobile, office or landline), you agree to receive phone calls from our representatives including pre-recorded messages sent to you from {{ getSiteName() }} to your number. In case we detect that a contact number that you provided to us is a mobile number, we may categorize it as such in our systems and in your account profile. Also, you agree to receive text messages from us about your use of {{ getSiteName() }}s services at that number.
                </p>
                <p class = 'heading'><b>
                6.) Security related to passwords:
                    </b></p>
                <p>
                Maintaining discretion related to your password, user ID’s, PIN’s and not revealing it to anybody is totally your responsibility. This includes any security codes which you use to access {{ getSiteName() }}.
                </p><p class = 'heading'><b>
                7.) Marketing:
                    </b></p>
                <p>
                If you ever receive information from {{ getSiteName() }} about any other user, you are to keep that information under discretion and should use it only in relation with {{ getSiteName() }} services. You cannot display or reveal or distribute information about other users to a Third Party or for any marketing purposes whatsoever unless you have the direct consent of the User to do so.
                </p><p class = 'heading'><b>
                  8.) No assignment of agreement rights:
                    </b></p>
                <p>
                Under this agreement, you can’t transfer or assign rights or obligations that you might have without “our” prior consent. “We” exclusively reserve the authority to transfer or assign rights or obligations.
                </p><p class = 'heading'><b>
                9.) Delay in action against breaches:
                    </b></p>
                <p>
                If for any reason action taken by us against any breach of our agreement or terms and conditions mentioned is delayed from our side, it doesn’t waives our right to act upon such breaches or similar breaches.
                </p><p class = 'heading'><b>
                 10.) Taxability and taxes:
                    </b></p>
                <p>
                It is solely your responsibility what taxes apply to your payments or transactions that you made or receive and it’s your responsibility to collect, report or remit and submit tax as per the law to the proper tax authority.
                </p>
            </div>

        </div>
    </div>
</div>
</div>
@stop