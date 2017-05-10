@extends('User.dashboard.layouts.master')
@section('title', 'Affiliates')
@section('content')
<div class="box box-info" <?php if(!isset(Auth::user()->id)) { ?> style="margin-top:52px;" <?php } ?>>
    <div class="container">
        <div class="box-header with-border">
            <h3 class="box-title">Affiliates</h3>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="main-sub-section-content">
                    Coming Soon
                </div>
            </div>
        </div>
        <br />
    </div>
</div>
@stop