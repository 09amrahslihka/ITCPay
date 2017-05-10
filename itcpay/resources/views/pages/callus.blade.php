@extends('layouts.master')
@section('title', 'Call Us')
@section('content')

<div class="box box-info" <?php if(!isset(Auth::user()->id)) { ?> style="margin-top:52px;" <?php } ?>>
    <div class="container">
        <div class="box-header with-border">
            <h3 class="box-title">Call Us</h3>
        </div>
        <div class = 'row'>
            <div class="col-md-12">
                <div class="main-sub-section-content">
                <p>You can call us at our 24x7 helpline number +1 {{isSupportphone()}}.</p>
           <div class = 'phone_number'>
               <p>
            <?php if(isset($userdata)) { ?>
                Reference Number: <?php echo $userdata->callus_reference; ?>
            <?php } ?>
               </p>
               </div>
           </div>
            </div>
        </div>
    </div>
</div>
@stop