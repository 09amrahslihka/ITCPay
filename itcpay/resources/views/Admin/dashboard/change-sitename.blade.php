@extends('Admin.dashboard.layouts.master')

@section('content')

<div class="box box-info">
		<div class="col-sm-12">
           <div class="row">
            <div class="col-md-12">
				<div class="change-form-bg clearfix">
					<div class="message-info clearfix">
						<h3 class="box-title">Change Site Name</h3>
					</div>
					
					@if (count($errors) > 0)
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
							@endforeach               
						</ul>
					</div>
					@endif

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
					<form method="post" action="{{URL::to('/admin/update-sitename')}}" enctype="multipart/form-data">
						<div class="row">
							<div class="email-form clearfix">
								<div class="col-md-4">
									<div class="form-group has-feedback">
										<label for="siteName">Site Name:</label>
										<input id="siteName" class="form-control" title="Please enter site Name" type="text" placeholder="Site Name*" name="siteName" value="{{ $siteName }}" required="">
									</div>
								</div>
							</div>
						</div>	
						<div class="row">
							<div class="email-form clearfix">
								<div class="col-md-4">
									<div class="form-group has-feedback">
										<label for="logo">Logo:</label>
										<input type="file" name="logo" id="logo" >
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="email-form clearfix">
								<div class="col-md-4">
									<div class="form-group has-feedback">
										<label for="favicon">Favicon:</label>
										<input type="file" name="favicon" id="favicon" >
									</div>
								</div>
							</div>
						</div>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="row">
							<div class="col-md-12">
								<div class="email-btn clearfix">
									<input value="Back" type="button"  id='back' class="next btn btn-danger">
									<input type="submit" value="Change Site Name" class="next btn btn-primary">
								</div>
							</div>
						</div>
					</form>
			</div>		
		</div>
	</div>

</div>
        </div>
@stop
