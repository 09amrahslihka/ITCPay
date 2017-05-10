@extends('User.dashboard.layouts.master')
@section('title', 'Call Us')
@section('content')
    <div class="box box-info" style="margin-top:52px;">
        <div class="container">
            <div class="box-header with-border">
                <h3 class="box-title">Call Us</h3>
            </div>
            <div class = 'row'>
                <div class="col-md-12">
                    <p>
                        You can call us at our 24x7 helpline number +1 {{isSupportphone()}}. Kindly mention to our support represntative
                        the reference number mentioned below when asked. The reference number provided will be valid for one
                        hour only.
                    </p>
                    <div class = 'phone_number'>
                        <p>
                            <?php if(isset($userdata)) { ?>
                            Reference Number : <?php echo $userdata->callus_reference; ?>
                            <?php } ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop