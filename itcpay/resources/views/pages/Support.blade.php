
@extends('layouts.master')
@section('title', 'Support')
@section('content')
    <div class="box box-info" <?php if(!isset(Auth::user()->id)) { ?> style="margin-top:52px;" <?php } ?>>
        <div class="container">
            <div class="box-header with-border">
                <h3 class="box-title">Support</h3>
            </div>
            <div class = 'row'>
                <div class="main-sub-section-content">
                    <div class="col-md-12">
                        <p>{{ getSiteName() }} provides you with a variety of support measures based on your individual needs and nature of the query at hand. </p>
                    </div>
                </div>
            </div>
            <div class = 'row'>
                <div class="main-sub-section-content clearfix">
                    <div class="col-md-4">
                        <div class = 'support_call_content clearfix'>
                            <div class = 'col-md-12 text-center'>
                                <div class = 'img_box'>
                                    <a href="{{URL::to('pages/faqs')}}">
                                        <img src="{{URL::asset('/images/support-faq.png')}}">
                                    </a>
                                </div>
                                <div class="box-header with-border support">
                                    <h3 class="box-title">Search our FAQs </h3>
                                </div>
                                <p>
                                    Need a quick resolution to your query? Just go through with our vast collection of FAQs by clicking on the “FAQs” icon above and we assure you that you will find answers to a majority of critical as well as general queries among them.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class = 'support_call_content clearfix'>
                            <div class = 'col-md-12 text-center'>
                                <div class = 'img_box'>
                                    
                                        <img src="{{URL::asset('/images/email-us.png')}}">
                                    
                                </div>
                                <div class="box-header with-border support">
                                    <h3 class="box-title">Email Us </h3>
                                </div>
                                <p>
                                   If you have any query please email us to {{ isSupportemail()}}.
                                </p>
                            </div>
                        </div>
                    </div>
                     @if (isSupportTicketEnabled()) 
                    <div class="col-md-4">
                        <div class = 'support_call_content clearfix'>
                            <div class = 'col-md-12 text-center'>
                                <div class = 'img_box'>
                                    <a href="{{URL::to('pages/support-ticket')}}">
                                        <img src="{{URL::asset('/images/support-ticket.png')}}">
                                    </a>
                                </div>
                                <div class="box-header with-border support">
                                    <h3 class="box-title">Submit Ticket</h3>
                                </div>
                                <p>
                                    Still can’t find answer to your queries? No worries, just click on the “Submit a Ticket” icon above, follow instructions shown and our highly effective customer support team will get in touch with you.
                                </p>
                            </div>
                        </div>
                    </div>
                     @endif 

                    @if (isCallUsEnabled())
                    <div class="col-md-4">
                        <div class = 'support_call_content clearfix'>
                            <div class = 'col-md-12 text-center'>
                                <div class = 'img_box'>
                                    <a href="{{URL::to('pages/call-us')}}">
                                        <img src="{{URL::asset('/images/call-us.png')}}">
                                    </a>
                                </div>
                                <div class="box-header with-border support">
                                    <h3 class="box-title">Call Us</h3>
                                </div>
                                <p>
                                    Need immediate assist for a unique query? We would love to hear from you personally. Just click on the “Call Us” icon above and follow instructions shown.
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop