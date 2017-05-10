@extends('layouts.master')
@section('title', 'About Us')
@section('content')

<div class="box box-info page-cms" <?php if(!isset(Auth::user()->id)) { ?>  <?php } ?>>
	<div class="page-banner">
		<div class="section-shadow">
			<div class="inner-heading">
				About Us
			</div>
		</div>
	</div>
    <div class="container">
 	<div class="row">
            <div class="col-md-12">
                <div class="main-sub-section-content about_us_content">
					<div class="row">
						<div class="col-sm-8">
							<div class="text-cms">
								<p class="about-head">Objective</p>
								<p>
									{{ getSiteName() }} is an US based global online payment processing company. We provide our users with extremely efficient ways to move their money by simultaneously offering them options
									and flexibility to choose the best way for them to get paid, pay or simply to send money.
								</p>
								<p class="about-head">Innovative, Fast and Convenient</p>
								<p>
									Making payments is a walk in the park now with {{ getSiteName() }}. We at {{ getSiteName() }} like to place ease of use and customer convenience first and foremost. As you can see from our website design and its navigation as well,
									we have made it such so payment transfers are a breeze with it. We have continued on our path of excellence to be at the forefront of today’s digital world facilitating payments beyond borders. With our ultra-fast
									and affordable solutions, both professionals and businesses can now pay and get paid easily.
								</p>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="img-object clearfix">
								<img src = "{{ URL::asset('images/objective.jpg') }}">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<div class="img-object clearfix">
								<img src = "{{ URL::asset('images/what.jpg') }}">
							</div>
						</div>
						<div class="col-sm-8">
							<div class="text-cms">
							   <p class="about-head">What you get with us.</p>
								<p>
									{{ getSiteName() }} is providing you with complete end-to-end payment security solutions, whether you are depositing funds, buying online or sending money to family and friends. {{ getSiteName() }} includes a
									pre-integrated payments gateway. Our value-added services assist users in managing their businesses and protecting them from fraud.  We provide you with 24x7 support from our veteran support staff
									who are experts in resolving cross-border intricacies related to payments. With cutting edge, best in the industry technology at our disposal {{ getSiteName() }} is your one stop shop for payments transfer
									while being courteous and approachable at the same time.
								</p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-8">
							<div class="text-cms">
								<p class="about-head">Services We Provide</p>
								<p>
									<strong class="about-sub-head">Merchant service:</strong> {{ getSiteName() }} provides you with easy-to-do electronic payment transactions for merchants. This constitutes of procuring sales data from the merchant, getting approval
									for the transaction and gathering funds from the bank of the user and finally sending payment to the merchant.
								</p>
								<p>
									<strong class="about-sub-head">Mass payment service:</strong> With {{ getSiteName() }} mass payment service you can send multiple in a single batch. All you need to do is to get permission from {{ getSiteName() }} to use Mass payments.
									You just have to submit the payment information with {{ getSiteName() }} in the form of a Payment File and {{ getSiteName() }} will process each payment and will notify you when it is complete.
								</p>
								<p>
									<strong class="about-sub-head">Individual payment service:</strong> Now you can send a payment request to your buyers by sending them an email for services rendered. Simply enter an email address and the amount, add details which explain
									the payment request. Your account will be automatically updated as soon as the payment is done and the amount will be transferred to your local bank account on regular intervals as per {{ getSiteName() }} policies.
								</p>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="img-object clearfix">
								<img src = "{{ URL::asset('images/service.jpg') }}">
							</div>
						</div>
					</div>

				</div>
            </div>
    </div>
</div>
</div>

@stop