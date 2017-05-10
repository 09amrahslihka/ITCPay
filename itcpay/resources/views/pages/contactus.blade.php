@extends('layouts.master')
@section('title', 'Contact Us')
@section('content')

<div class="box box-info" <?php if(!isset(Auth::user()->id)) { ?> style="margin-top:52px;" <?php } ?>>
  <div class="box-header with-border">
                    <h3 class="box-title">Contact Us</h3>
                </div>

<div class="container">
    <div class="row">
            <div class="col-md-6">

            	  <div class="box-header with-border">
                    <h3 class="box-title">Submit Your Ticket</h3>
                </div>
                       
<p style="color:green;">If you are reporting a problem, please remember to provide as much information that is relevant to the issue as possible.</p>

 <form method="post" action="{{URL::to('pages/submit_ticket')}}" enctype="multipart/form-data">
{{ csrf_field() }}
     <div class="form-group has-feedback">
        <label>First and Last Name:</label>
        <input type="text"  class="form-control" name="name" placeholder="First and Last Name" required="">
      </div>

     <div class="form-group has-feedback">
        <label>Email:</label>
        <input type="text"  class="form-control" name="email" placeholder="Email" required="">
      </div>

     <div class="form-group has-feedback">
        <label>Date of Birth:</label>
        <input type="text"  class="form-control" name="dob" placeholder="DOB" required="">
        <p>Enter your date of birth in the format YYYY-MM-DD</p>
      </div>


     <div class="form-group has-feedback">
        <label>Internet Service Provider:</label>
        <input type="text"  class="form-control" name="service_provider" placeholder="Internet Service Provider" required="">
      </div>

     <div class="form-group has-feedback">
        <label>Subject:</label>
        <input type="text"  class="form-control" name="subject" placeholder="Subject" required="">
      </div>

     <div class="form-group has-feedback">
        <label>Message:</label>
        <textarea name="message"  class="form-control" required="" placeholder="message"></textarea>
      </div>

 <div class="row" style="float: none;margin: 0 auto;">
   <div class="col-md-10" style="float: right; padding-right: 0px;">
       <input type="submit" name="" class="next btn btn-info pull-right btn-primary btn-block btn-flat ">
   </div>
</div>


</form>

            </div>
             <div class="col-md-1" style=" border-right: 1px solid #ccc; min-height: 500px;">&nbsp;</div>
            <div class="col-md-5">
  <div class="box-header with-border">
                    <h3 class="box-title">Call Us</h3>
                </div>
<p>
phone number: +18058643424
</p>
<?php if(isset($userdata)) { ?>
<p>
reference number: <?php echo $userdata->callus_reference; ?>
</p>
<?php } ?>
            </div>	
    </div>
    <br />
</div>
</div>

@stop