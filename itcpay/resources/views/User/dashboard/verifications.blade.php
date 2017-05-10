@extends('User.dashboard.layouts.master')
@section('title', 'Verifications')
@section('content')

    <script>
        $(function() {
            $('.submit-blocker').on('click', function(event) {
                event.preventDefault();
                alert("Submit your personal verification information and documents");
            });
            $('.submit-blocker2').on('click', function(event) {
                event.preventDefault();
                alert("Please submit your personal and business verification information and documents");
            });
        });
    </script>
    <div class="box box-info" <?php if(!isset(Auth::user()->id)) { ?> style="margin-top:52px;" <?php } ?>>
        @if(Session::has('message'))
            <div class="alert alert-success" role="alert">
                {{Session::get('message')}}
            </div>
        @endif
        <div class="container">
            <div class="box-header dashboard-header">
                <h3 class="box-title dashboard-heading">Verifications</h3>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @if($accountType=="personal")

                        @if(auth()->user()->verify)
                            <div class="varification-text clearfix">
                                <p>Your identity is verified.</p>
                            </div>
                        @elseif(isset($personalInformation) && $personalInformation->is_saved==1 && $personalInformation->is_rejected!=1)

                            <div class="varification-text clearfix">
                                <p>Your information and documents have been submitted and will be reviewed by our verification department for verification.</p>
                            </div>
                        @else
                            <div class="varification-text clearfix">
                                <h5>Kindly follow the below mentioned steps in order to verify your account</h5>
                                <strong class="steps-varification">What You Need To Do:</strong>
                            </div>
                            <div class="main-sub-section-content business clearfix">
                                <div class="col-md-12">
                                    <div class="bg-varification clearfix">
                                        <img src="{{URL::asset('/images/doc.png')}}"> <span>1. Upload personal verification information and documents.</span> <a href = "{{URL::to('verify/personal-verification')}}">Upload</a>
                                    </div>
                                </div>
                            </div>
                            <div class="document-verify clearfix">
                                <!-- <img src="{{URL::asset('/images/req_doc.png')}}"> -->
                                <div class="document-container">
                                    <!-- <p>
                                        If you have provided us with all your personal information and documents we asked from you, we will add you to the documents verification queue.
                                        As soon as we are through with checking authencity of your documents and details and if everything is good to go, we will send you an email
                                        regarding your account approval. You will also be able to view your account status changed to verified.
                                    </p> -->
                                    <!-- <form method = 'post' action="{{ url('verifications') }}" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{$accountType}}" name="type" />
                                        @if(isset($personalInformation))
                                            <input type = "submit" class="submit-varification" value = "Submit verification information and documents">
                                        @else
                                            <input type = "submit" class="submit-varification submit-blocker" value ="Submit verification information and documents" />
                                        @endif

                                    </form> -->
                                </div>
                            </div>
                        @endif
                    @elseif($accountType=="business")

                        @if(auth()->user()->verify)
                            <div class="varification-text clearfix">
                                <p>Your identity is verified.</p>
                            </div>
                        @elseif(isset($businessInformation) && $businessInformation->is_saved==1 && isset($personalInformation) && $personalInformation->is_saved==1 && $personalInformation->is_rejected!=1 && $businessInformation->is_rejected!=1)
                            <div class="varification-text clearfix">
                                <p>Your information and documents have been submitted and will be reviewed by our verification department for verification</p>
                            </div>
                        @else
                            <div class="varification-text clearfix">
                                <h5>Kindly follow the below mentioned steps in order to verify your account</h5>
                                <strong class="steps-varification">What You Need To Do:</strong>
                            </div>
                            <div class="main-sub-section-content personal clearfix">
                                <div class="col-md-12">
                                    <div class="bg-varification clearfix">
                                        <img src="{{URL::asset('/images/doc.png')}}"> <span>1. Upload personal verification information and documents.</span> 
                                        @if(isset($personalInformation) && $personalInformation->is_saved==1 && $personalInformation->is_rejected!=1)
                                            <a disabled="disabled" href = "javascript:void(0)">Submitted</a>
                                        @else
                                        <a  href = "{{URL::to('verify/personal-verification')}}">Upload</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="bg-varification clearfix">
                                        <img src="{{URL::asset('/images/doc.png')}}"> <span>2. Upload business verification information and documents.</span> 
                                        @if(isset($businessInformation) && $businessInformation->is_saved==1 && $businessInformation->is_rejected!=1)
                                        <a href="javascript:void(0)" >Submitted</a>
                                        @else
                                        <a href="{{URL::to('verify/business-verification')}}" >Upload</a>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="document-verify clearfix">
                                <!-- <img src="{{URL::asset('/images/req_doc.png')}}"> -->
                                <div class="document-container">
                                    <p><!-- 
                                        If you have provided us with all your personal information and documents we asked from you, we will add you to the documents verification queue.
                                        As soon as we are through with checking authencity of your documents and details and if everything is good to go, we will send you an email
                                        regarding your account approval. You will also be able to view your account status changed to verified.
                                    </p> -->
                                    <!-- <form method ='post' action="{{ url('verifications') }}" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{$accountType}}" name="type" />
                                        @if(isset($personalInformation) && isset($businessInformation))
                                            <input type = "submit" class="submit-varification" value = "Submit verification information and documents">
                                        @else
                                            <input type = "submit" class="submit-varification submit-blocker2" value ="Submit verification information and documents" />
                                        @endif
                                    </form> -->
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop