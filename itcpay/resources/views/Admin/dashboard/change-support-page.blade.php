@extends('Admin.dashboard.layouts.master')

@section('content')

<div class="box box-info">
		<div class="col-sm-12">
           <div class="row">
            <div class="col-md-12">
				<div class="change-form-bg clearfix">
					<div class="message-info clearfix">
						<h3 class="box-title">Support page settings</h3>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="email-btn clearfix">
								
								<a href="{{URL::to('/admin/update-callus')}}" class="next btn btn-primary">Change Call Us Settings</a>
								<a href="{{URL::to('/admin/update-supportticket')}}" class="next btn btn-primary">Support ticket settings</a>
								<a href="{{URL::to('/admin/update-supportemail')}}" class="next btn btn-primary">Change support email address</a>
								<a href="{{URL::to('/admin/update-supportphone')}}" class="next btn btn-primary">Change support phone number</a>
							</div>
						</div>
						</div>
					
			</div>		
		</div>
	</div>

</div>
        </div>

@stop
