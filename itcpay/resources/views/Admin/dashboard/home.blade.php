@extends('Admin.dashboard.layouts.master')

@section('content')
    <div class="col-md-12">

        <div class="">
            <div class="box no-border">
                @if(Session::has('message'))
                    <div class="alert alert-success" role="alert">
                        {{Session::get('message')}}
                    </div>
                @endif

                @if(Session::has('emessage'))
                    <div class="alert alert-danger" role="alert">
                        {{Session::get('emessage')}}
                    </div>
                @endif
                <!-- /.box-header -->
                <div class="box-heading clearfix">
                    <h2>Hello {{$user->fname}} {{$user->lname}}</h2>
                    <!-- /.box-body -->
                </div>
				
				<div class="row">
					<div class="col-lg-4">
						<div class="box-block clearfix">
							<div class="inner-section clearfix">
								<div class="col-sm-8">
									<div class="views">
										<strong>Welcome to {{ getSiteName() }}</strong>
										<span>Number of Views</span>
									</div>
								</div>
								<div class="col-sm-4">
								    <div class="number-view clearfix">
										<strong>102</strong>
									</div>		
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="box-block clearfix">
							<div class="inner-section clearfix">
								<div class="col-sm-8">
									<div class="views">
										<strong>Active</strong>
										<span>Email / Contacts</span>
									</div>
								</div>
								<div class="col-sm-4">
								    <div class="number-view clearfix">
										<strong>90</strong>
									</div>		
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="box-block clearfix">
							<div class="inner-section clearfix">
								<div class="col-sm-8">
									<div class="views">
										<strong>Inactive</strong>
										<span>Email / Contacts</span>
									</div>
								</div>
								<div class="col-sm-4">
								    <div class="number-view clearfix">
										<strong>60</strong>
									</div>		
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-3">
						<div class="box-block clearfix">
							<div class="inner-section clearfix">
								<div class="col-sm-8">
									<div class="views">
										<strong>$66,122</strong>
										<span>Account Balance</span>
									</div>
								</div>
								<div class="col-sm-4">
								    <div class="number-view clearfix">
										<strong class="icons-align"><i class="fa fa-dollar fa-2x"></i></strong>
									</div>		
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="box-block clearfix">
							<div class="inner-section clearfix">
								<div class="col-sm-8">
									<div class="views">
										<strong>$600.00</strong>
										<span>Available Balance</span>
									</div>
								</div>
								<div class="col-sm-4">
								    <div class="number-view clearfix">
										<strong class="icons-align"><i class="fa fa-dollar fa-2x"></i></strong>
									</div>		
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="box-block clearfix">
							<div class="inner-section clearfix">
								<div class="col-sm-8">
									<div class="views">
										<strong>Business</strong>
										<span>Account Type</span>
									</div>
								</div>
								<div class="col-sm-4">
								    <div class="number-view clearfix">
										<strong class="icons-align"><i class="fa fa-suitcase fa-2x"></i></strong>
									</div>		
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="box-block clearfix">
							<div class="inner-section clearfix">
								<div class="col-sm-8">
									<div class="views">
										<strong>Unverified</strong>
										<span>Account Status</span>
									</div>
								</div>
								<div class="col-sm-4">
								    <div class="number-view clearfix">
										<strong class="icons-align"><i class="fa fa-check-square-o fa-2x"></i></strong>
									</div>		
								</div>
							</div>
						</div>
					</div>
				</div>
                <div class="listing-tables">
					<table class="table table-striped table-bordered table-vcenter">
					    <thead>		
							<tr>
								<th>Date & Time</th>
								<th>Transaction type</th>
								<th>Name</th>
								<th>Transaction status</th>
								<th>Details</th>
								<th>Gross</th>
								<th>Fee</th>
								<th>Net amount</th>
								<th>Balance</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>20-09-2016</td>
								<td>Lorem Ipsum</td>
								<td>Jaishon</td>
								<td>Confirmed</td>
								<td>Lorem Ipsum is simply dummy text of the printing</td>
								<td>$22.00</td>
								<td>$32.00</td>
								<td>$20.00</td>
								<td>$30.00</td>
							</tr>
							<tr>
								<td>20-09-2016</td>
								<td>Lorem Ipsum</td>
								<td>Jaishon</td>
								<td>Confirmed</td>
								<td>Lorem Ipsum is simply dummy text of the printing</td>
								<td>$22.00</td>
								<td>$32.00</td>
								<td>$20.00</td>
								<td>$30.00</td>
							</tr>
							<tr>
								<td>20-09-2016</td>
								<td>Lorem Ipsum</td>
								<td>Jaishon</td>
								<td>Confirmed</td>
								<td>Lorem Ipsum is simply dummy text of the printing</td>
								<td>$22.00</td>
								<td>$32.00</td>
								<td>$20.00</td>
								<td>$30.00</td>
							</tr>
							<tr>
								<td>20-09-2016</td>
								<td>Lorem Ipsum</td>
								<td>Jaishon</td>
								<td>Confirmed</td>
								<td>Lorem Ipsum is simply dummy text of the printing</td>
								<td>$22.00</td>
								<td>$32.00</td>
								<td>$20.00</td>
								<td>$30.00</td>
							</tr>
							<tr>
								<td>20-09-2016</td>
								<td>Lorem Ipsum</td>
								<td>Jaishon</td>
								<td>Confirmed</td>
								<td>Lorem Ipsum is simply dummy text of the printing</td>
								<td>$22.00</td>
								<td>$32.00</td>
								<td>$20.00</td>
								<td>$30.00</td>
							</tr>
						</tbody>
					</table>
				</div>				
			</div>
        </div>

    </div>
@stop