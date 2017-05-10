@extends('User.dashboard.layouts.master')
@section('title', 'Feedback')
@section('content')
    <div class="box box-info" <?php if(!isset(Auth::user()->id)) { ?> style="margin-top:52px;" <?php } ?>>
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

                    <div class="col-md-6 right-border">
                        <form method="post" action="{{URL::to('pages/submit_feedback')}}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <p><b>
                                    Please take a minute to give us your valuable feedback below.
                                </b></p>
                            <div class="form-group has-feedback">
                                <label>Message:</label>
                                <textarea name="message"  class="form-control" required="" placeholder="Message"></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-10">
                                    <input type="submit" name="" value = "Send" class="next btn btn-info pull-left btn-primary btn-block btn-flat ">
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