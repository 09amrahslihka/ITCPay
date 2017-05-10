@extends('layouts.master')
@section('content')
<div class="box box-info" <?php if(!isset(Auth::user()->id)) { ?> style="margin-top:52px;" <?php } ?>>
    <div class="container">
        <div class="box-header with-border">
            <h3 class="box-title">Bank Account Instant Verification User Terms</h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="main-sub-section-content term_service">
                    <p>
                        The Bank Account Instant Verification Service seeks to verify that you own the bank account that you have registered with {{ getSiteName() }} Inc. and its affiliates. Your use of the Bank Account Instant Verification Service is subject to the {{ getSiteName() }} Inc. and its affiliates Terms of Service and these Bank Account Instant Verification User Terms.
                    </p>
                    <p>
                        By using the Bank Account Instant Verification Service, you authorize {{ getSiteName() }} Inc. and its affiliates and its supplier Yodlee, Inc. ("Yodlee") to access third party web sites designated by you, on your behalf, to retrieve information requested by you, or as required by {{ getSiteName() }}, to verify the bank account that you have registered with us. Such account verification may be used by {{ getSiteName() }} Inc. or its affiliates for risk and fraud purposes. You may use the Instant Account Verification Service (including the results) solely for your personal use in verifying your bank account and using {{ getSiteName() }} Inc. services.
                    </p>
                    <p>
                        YOU AGREE THAT THE INFORMATION YOU PROVIDE IS TRUE, ACCURATE, CURRENT AND COMPLETE INFORMATION ABOUT YOURSELF AND YOUR ACCOUNTS AND YOU AGREE NOT TO MISREPRESENT YOUR IDENTITY OR YOUR ACCOUNT INFORMATION.
                    </p>
                    <p>
                        YOU AGREE THAT NEITHER {{ strtoupper(getSiteName()) }}., YODLEE, THEIR SERVICE PROVIDERS OR ANY OF THE RESPECTIVE AFFILIATES OF THESE ENTITIES WILL BE LIABLE FOR ANY INDIRECT, INCIDENTAL, SPECIAL, CONSEQUENTIAL OR EXEMPLARY DAMAGES, INCLUDING, BUT NOT LIMITED TO, DAMAGES FOR LOSS OF PROFITS, GOODWILL, USE, DATA OR OTHER INTANGIBLE LOSSES, EVEN IF {{ strtoupper(getSiteName()) }}., YODLEE, OR THEIR SERVICE PROVIDERS HAVE BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES, RESULTING FROM THE USE OR THE INABILITY TO USE THE BANK ACCOUNT INSTANT VERIFICATION SERVICE OR ANY OTHER MATTER RELATING TO THE BANK ACCOUNT INSTANT VERIFICATION SERVICE.
                    </p>
                    <p>
                        You agree that Yodlee is a third-party beneficiary of these Bank Account Instant Verification User Terms, with all rights to enforce such provisions as if Yodlee were a party to these User Terms.
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>
@stop