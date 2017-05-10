@extends('layouts.master')
@section('title', 'Support Ticket')
@section('content')

    <div class="box box-info" <?php if(!isset(Auth::user()->id)) { ?> style="margin-top:52px;" <?php } ?>>
        <div class="container">
            <div class="box-header with-border">
                <h3 class="box-title">Submit A Support Ticket</h3>
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
                        <form method="post" action="{{URL::to('pages/submit_ticket')}}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <p><b>
                                    Please fill out the fields below and click on the “Submit Ticket” button. In the “Message” field, kindly define your query in as much detail as possible.
                                </b></p>
                            <div class="form-group has-feedback">
                                <label>First Name:</label>
                                <input type="text"  class="form-control" name="name" placeholder="First Name" required="">
                            </div>
                            <div class="form-group has-feedback">
                                <label>Last Name:</label>
                                <input type="text"  class="form-control" name="lname" placeholder="Last Name" required="">
                            </div>
                            <div class="form-group has-feedback">
                                <label>Email:</label>
                                <input type="email"  class="form-control" name="email" placeholder="Email" required="">
                            </div>
                            <div class="form-group has-feedback">
                                <label>Subject:</label>
                                <input type="text"  class="form-control" name="subject" placeholder="Subject" required="">
                            </div>

                            <div class="form-group has-feedback">
                                <label>Message:</label>
                                <textarea name="message"  class="form-control" required="" placeholder="Message"></textarea>
                            </div>
                            <div class="form-group has-feedback" id="upload">
                                <label>Attachment 1:</label>
                                <span id = 'attachment_count' style = 'display:none;'>1</span>
                                <input class="submit_files" name="submit_files[]" type="file" >   <a href="javascript:void(0);" class="add" >Add More</a>
                                <!-- In this container dynamic fields will display -->
                                <div class="contents"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    {!! captcha_image_html('ExampleCaptcha') !!}
                                    <input type="text" class="form-control" placeholder="Enter captcha code here*" name="captcha" id="captcha">
                                    <input type="submit" name="" value = "Submit Ticket" class="next btn btn-info pull-left btn-primary btn-block btn-flat ">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div class="box-header main_justify">
                            <p>&nbsp;</p>
                            <img src="{{URL::asset('/images/it-support.jpg')}}">
                        </div>
                    </div>
                </div>
                <br />
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var curr_count
              $(".add").click(function() {
                    curr_count = $('#attachment_count').text();
                    curr_count++
                $('<div><label>Attachment&nbsp;'+curr_count+' :&nbsp;</label><input class="submit_files" name="submit_files[]" type="file" ><span class="rem" ><a href="javascript:void(0);" >Remove</span></div>').appendTo(".contents");
                  $('#attachment_count').text(curr_count);
            });
            $('.contents').on('click', '.rem', function() {
                curr_count = $('#attachment_count').text();
                curr_count--
                $(this).parent("div").remove();
                $('#attachment_count').text(curr_count);
            });
        });
    </script>
@stop