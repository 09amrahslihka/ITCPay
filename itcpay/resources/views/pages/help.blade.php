@extends('layouts.master')
@section('title', 'Help')
@section('content')

<div class="box box-info" <?php if(!isset(Auth::user()->id)) { ?> style="margin-top:52px;" <?php } ?>>
  <div class="box-header with-border">
                    <h3 class="box-title">FAQ</h3>
                </div>

<div class="container">
    <div class="row">
            <div class="col-md-12">
           
<div class="kbarticlecontainer">


				<div class="kbarticle"><a class="itemheader">How can i add money to my account?</a></div>
				<div class="kbarticletext"><span class="smalltext">learn demo text learn demo text learn demo text learn demo text learn demo text learn demo text </span></div>
				</div>



            </div>
    </div>
    <br />.

</div>
</div>

@stop