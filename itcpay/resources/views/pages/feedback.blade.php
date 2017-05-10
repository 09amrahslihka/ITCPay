@extends('layouts.master')
@section('title', 'Feedback')
@section('content')
    <div class="box box-info page-cms">
        <div class="container">
            <div class="box-header with-border">
                <h3 class="box-title">Feedback</h3>
            </div>
            <div class="row">
                <div class="main-sub-section-content">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (Session::has('errormessage'))
                        <div class="alert alert-danger">
                            <ul>

                                <li>{{ Session::get('errormessage') }}</li>

                            </ul>
                        </div>
                    @endif

                    @if (Session::has('emessage'))
                        <div class="alert alert-success">
                            <ul>

                                <li>{{ Session::get('emessage') }}</li>

                            </ul>
                        </div>
                    @endif

                    <div class="col-md-6">
                        <form method="post" action="{{URL::to('pages/submit_feedback')}}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="inner-feed-text clearfix">
                                Please take a minute to give us your valuable feedback below.
                            </div>
                            <div class="form-group has-feedback custom-form">
                                <label>Name:</label>
                                <input type="text"  class="form-control" name="name" placeholder="Name" required="">
                            </div>
                            <div class="form-group has-feedback custom-form">
                                <label>Email:</label>
                                <input type="email"  class="form-control" name="email" placeholder="Email" required="">
                            </div>
                            <div class="form-group has-feedback custom-form">
                                <label>Message:</label>
                                <textarea name="message"  class="form-control" required="" placeholder="Message"></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <input type="submit" name="" value = "Send" class="next btn btn-info pull-left btn-primary btn-block btn-flat no-margin">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div class="box-header main_justify feedback_img">

                            <img src="{{URL::asset('/images/feedback-support.jpg')}}">
                        </div>
                    </div>
                </div>
                <br />
            </div>
        </div>
    </div>
@stop