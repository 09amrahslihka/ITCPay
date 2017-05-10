@extends('landing-page-layouts.master')
@section('title', 'Home')
@section('content')
    <!-- Carousel
        ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
            <li data-target="#myCarousel" data-slide-to="3"></li>
            <li data-target="#myCarousel" data-slide-to="4"></li>

            <!-- <li data-target="#myCarousel" data-slide-to="2"></li> -->
        </ol>
        <div class="carousel-inner" role="listbox">
            <!-- <div class="item active">
                <img class="first-slide" src="{{URL::asset('/landing/images/slider.jpg')}}" alt="Paymentshub">
                <div class="container">
                    <div class="carousel-caption">
                        <div class="col-sm-8 col-sm-offset-3">
                            <h1>Fastest, Simplest And The  Securest Way   Of   Making   Payments.</h1>
                            <div class="crousel-signup">
                                <a href="{{URL::to('/register')}}">Sign Up Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="item active">
                <img class="first-slide" src="{{URL::asset('/landing/images/slider1.jpg')}}" alt="Paymentshub">
                <div class="container">
                    <div class="carousel-caption">
                        <div class="col-sm-8 col-sm-offset-3">
                            <h1>Fastest, Simplest And The  Securest Way   Of   Making   Payments.</h1>
                            <div class="crousel-signup">
                                <a href="{{URL::to('/register')}}">Sign Up Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <img class="first-slide" src="{{URL::asset('/landing/images/slider2.jpg')}}" alt="Paymentshub">
                <div class="container">
                    <div class="carousel-caption">
                        <div class="col-sm-8 col-sm-offset-3">
                            <h1>Fastest, Simplest And The  Securest Way   Of   Making   Payments.</h1>
                            <div class="crousel-signup">
                                <a href="{{URL::to('/register')}}">Sign Up Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="item">
                <img class="first-slide" src="{{URL::asset('/landing/images/slider3.jpg')}}" alt="Paymentshub">
                <div class="container">
                    <div class="carousel-caption">
                        <div class="col-sm-8 col-sm-offset-3">
                            <h1>Fastest, Simplest And The  Securest Way   Of   Making   Payments.</h1>
                            <div class="crousel-signup">
                                <a href="{{URL::to('/register')}}">Sign Up Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="item">
                <img class="first-slide" src="{{URL::asset('/landing/images/slider4.jpg')}}" alt="Paymentshub">
                <div class="container">
                    <div class="carousel-caption">
                        <div class="col-sm-8 col-sm-offset-3">
                            <h1>Fastest, Simplest And The  Securest Way   Of   Making   Payments.</h1>
                            <div class="crousel-signup">
                                <a href="{{URL::to('/register')}}">Sign Up Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="item">
                <img class="first-slide" src="{{URL::asset('/landing/images/slider5.jpg')}}" alt="Paymentshub">
                <div class="container">
                    <div class="carousel-caption">
                        <div class="col-sm-8 col-sm-offset-3">
                            <h1>Fastest, Simplest And The  Securest Way   Of   Making   Payments.</h1>
                            <div class="crousel-signup">
                                <a href="{{URL::to('/register')}}">Sign Up Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span aria-hidden="true"><img src="{{URL::asset('/landing/images/left-arrow.png')}}"/></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span  aria-hidden="true"><img src="{{URL::asset('/landing/images/right-arrow.png')}}"/></span>
            <span class="sr-only">Next</span>
        </a>
    </div><!-- /.carousel -->

    <!-- Description Text-->
    <section class="description-area  ">
        <div class="container">

            <div class="heading text-center animated slideOutDown">
                <h1 class="">WHY SHOULD YOU USE {{ strtoupper(getSiteName()) }}?</h1>
                <span></span>
            </div>
            <div class="row">
                <div class="col-sm-4 padding-right-5">
                    <div class="bg-desc clearfix">
                        <ul>
                            <li><img src="{{URL::asset('/landing/images/m-payments.png')}}"/> Mass Payment Service</li>
                            <p>
                                With {{ getSiteName() }} mass payment service, you can send multiple payments in a single batch. All you need to do is to get permission from {{ getSiteName() }}
                                to use Mass payments. You just have to submit the payment information with {{ getSiteName() }} in the form of a Payment File and {{ getSiteName() }} will process each payment and will notify you when it is complete. With our Mass payment service, companies can pay thousands 
								of their employees, contractors regularly.	
                            </p>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4 padding-right-5">
                    <div class="bg-desc clearfix">
                        <ul>
                            <li><img src="{{URL::asset('/landing/images/i-payments.png')}}"/> Individual Payment Service</li>
                            <p>
                                Individuals can send money from their account to another individual’s account using the "Send Payment" page) either as personal payment 
								(payment for friends and family, e.g. shared rentals) or for goods or services. Just Log into your {{ getSiteName() }} account, go to “Send Payment” page and enter receiver’s
								email address, amount, payment type. Your account will be automatically updated as soon as the payment is done and the same will be updated on the receiver’s end as well.
                            </p>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4 padding-right-5">
                    <div class="bg-desc clearfix">
                        <ul>
                            <li><img src="{{URL::asset('/landing/images/m-service.png')}}"/> Merchant Services</li>
                            <p>
                                {{ getSiteName() }} provides you with easy-to-do electronic payment transactions for merchants. If an online seller integrates {{ getSiteName() }} ‘Payment API’ in their website,
								they will be able to accept either credit card or {{ getSiteName() }} payments in their website. This means the buyer can either pay with a credit card
								(if he doesn't have a {{ getSiteName() }} account) or he can pay with his {{ getSiteName() }} account by entering {{ getSiteName() }} email and password.
							</p>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="clearfix mar_top3"></div>
            <div class="row">
                <div class="col-sm-4 padding-right-5">
                    <div class="bg-desc clearfix bg-desc-bottom">
                        <ul>
                            <li><img src="{{URL::asset('/landing/images/c-card.png')}}"/> Link Credit/Debit Card</li>
                            <p>
                               Link your Credit/Debit Card with your {{ getSiteName() }} account. Once that is done, you will be able to send payments easily while having seamless experience at the same time.
                            </p>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4 padding-right-5">
                    <div class="bg-desc clearfix bg-desc-bottom">
                        <ul>
                            <li><img src="{{URL::asset('/landing/images/bank-accounts.png')}}"/> Link Bank Account</li>
                            <p>
                                Link your bank account using your local bank account details. Once that is done, you will be able to send and receive payments. {{ getSiteName() }}
                                is designed to provide the best possible payment transaction experience for our users with real challenges of multi-payments in mind.
                            </p>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4 padding-right-5">
                    <div class="bg-desc clearfix bg-desc-bottom">
                        <ul>
                            <li><img src="{{URL::asset('/landing/images/s-security.png')}}"/> State-Of-The-Art Security</li>
                            <p>
                                {{ getSiteName() }} covers its basics and is very strict on covering as much ground as possible for securing safe thorough-way of its financial transactions. 
								We provide you with round the clock security giving you options like Account verification, 128 Bit SSL encryption, Password Protection, 
								and Reporting/Notifications features. 
                            </p>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Description Text End -->
    <div class="devider-area clearfix"><img src="{{URL::asset('/landing/images/devider.png')}}"/></div>
    <section class="section-grey">
        <div class="no-parallax clearfix">
            <div class="left-bg">
                <div class="dash-image">
                   <!--  <img src="{{URL::asset('/landing/images/dash.png')}}"/> -->
                </div>
            </div>
            <div class="bg-right">
                <div class="right-texts clearfix">
                    <h2>How are We different?</h2>
                    <p>
                        {{ getSiteName() }} is providing you with complete end-to-end payment security solutions, whether you are depositing funds, buying online or sending money to family
                        and friends. {{ getSiteName() }} includes a pre-integrated payments gateway. Our value-added services assist users in managing their businesses and protecting them from
                        fraud. We provide you with 24x7 support from our veteran support staff who are experts in resolving cross-border intricacies related to payments. With cutting
                        edge, best in the industry technology at our disposal {{ getSiteName() }} is your one stop shop for payments transfer while being courteous and approachable at the
                        same time.
                    </p>
                    <div class="read-more clearfix">
                        <a href="{{URL::to('/pages/aboutus')}}">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="crousel-container">
        <ul class = "bxslider-crausal">
            <li><img src="{{URL::asset('/landing/images/m-card.png')}}"/></li>
            <li><img src="{{URL::asset('/landing/images/visa.png')}}"/></li>
            <li><img src="{{URL::asset('/landing/images/american-express.png')}}"/></li>
            <li><img src="{{URL::asset('/landing/images/discover.png')}}"/></li>
            <li><img src="{{URL::asset('/landing/images/d-club.png')}}"/></li>
            <li><img src="{{URL::asset('/landing/images/jcb.png')}}"/></li>
        </ul>
    </section>
    <section class="section-hidden">
        <div class="clearfix">
            <div class="clearfix">
                <div class="col-sm-4 padding-left-0 padding-right-0">
                    <div class="hideden-section">
                        <div class="text-flow">
                            <h4>No Hidden Fees</h4>
                            <p>
                                We have the most competitive rates in the business and most importantly we don’t charge any hidden fees. We work with complete transparency with our
                                users. With {{ getSiteName() }} you don’t have to pay anything till you sell anything. No per month fees for cancellation when you sell with us. Pay us
                                when you make a sale. For buyers, with {{ getSiteName() }} you can buy for free. </p>
                            <a href="{{URL::to('/pages/fees')}}">Learn More</a>
                        </div>
                        <div class="setting-img">
                            <img src="{{URL::asset('/landing/images/cog.png')}}"/>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 padding-left-0 padding-right-0">
                    <div class="easy-use">
                        <div class="easy-flow">
                            <h4>Easy-To-Use</h4>
                            <p>
                                We at {{ getSiteName() }} like to place ease of use and customer convenience first and foremost. As you can see from our website design and
                                its navigation as well, we have made it such so payment transfers are a breeze with it. We have continued on our path of excellence
                                to be at the forefront of today’s digital world facilitating payments beyond borders.
                            </p>
                            <a href="{{URL::to('/pages/aboutus')}}">Learn More</a>
                        </div>
                        <div class="setting-img">
                            <img src="{{URL::asset('/landing/images/easy.png')}}"/>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 padding-left-0 padding-right-0">
                    <div class="immediate-section">
                        <div class="fee-flow">
                            <h4>Immediate Assistance</h4>
                            <p>
                                Need a quick resolution to your query? Just go through with our vast collection of FAQs or submit a support ticket
                                @if($is_call_enable)
                                    or simply get in touch
                                    with our customer support for quick resolution by calling us
                                @endif
                            .</p>
                            <a href="{{URL::to('/pages/Support')}}">Learn More</a>
                        </div>
                        <div class="setting-img">
                            <img src="{{URL::asset('/landing/images/immediate.png')}}"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="payment-feed-main">
        <div class="container">
            <div class="twitter-feeds">
                <strong>{{ getSiteName() }}</strong>: We provide our users with extremely efficient ways to move their money and offer them the best way to get paid, pay or simply send money.
            </div>
        </div>
    </div>
    <div class="wave_graphs "></div>

    <script src="{{URL::asset('/landing/bxslider/jquery.bxslider.js')}}"></script>
    <!-- bxSlider CSS file -->
    <link href="{{URL::asset('/landing/bxslider/jquery.bxslider.css')}}" rel="stylesheet" />
    <script>
        $(document).ready(function(jQuery){
            jQuery('.bxslider-crausal').bxSlider({
                minSlides: 2,
                maxSlides: 6,
                slideWidth: 130,
                slideMargin: 50,
                auto:true,
                pager:false
            });
        });
    </script>
@stop
