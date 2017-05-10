@extends('Admin.dashboard.layouts.master')

@section('content')
    <link rel="stylesheet" href="{{asset('js/jquery-ui-1.12.0.custom/jquery-ui.css')}}">
    <script src="{{ asset("js/jquery-ui-1.12.0.custom/jquery-ui.js") }}"></script>
   
    <script>
    var deleteUserAccountID = "{{ '/admin/users/deleteUserAccountID'}}";
     var changeUserAccountStatus = "{{ '/admin/users/changeUserAccountStatus'}}";
    
    var deleteUserAccountSuccessRedirectURLSingle = "{{ route('admin_users_delete_user_account_success_redirect') }}";
     var statusUserAccountSuccessRedirectURLSingle = "{{ route('admin_users_status_user_account_success_redirect') }}";
        function DeleteAccount(c, i)
        {
            // alert(i);
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure you want to delete selected users?',
                confirmButton: 'Remove',
                cancelButton: 'Cancel',
                confirm: function () {
                    var userIDs =i;
                    //console.log(userIDs);
                    $.ajax({
                        type: 'post',
                        dataType: 'json',
                        data: {
                            userIDs: userIDs,
                            _token: _token
                        },
                        url: deleteUserAccountID,
                        success: function (response)
                        {
                          // window.location.href =window.location.href;
                          window.location = deleteUserAccountSuccessRedirectURLSingle + "/?count=" + 1;
                        }
                    });

                },
                cancel: function () {
                }
            });
            //var url = "{{URL::to('/admin/user/deleteUserAccountID')}}" + "/" + i;
            /*$('#cardtype').text(c.getAttribute("data-cardtype"));
            $('#cardnumber').text(c.getAttribute("data-cardnumber"));
            $('#removeModal').modal('toggle');
            $('#rlink').attr("href", url);*/
        }
        
        function ChangeAccountStatus(c, user_id,status)
        {
            //alert(status);
           
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure you want to change user status?',
                confirmButton: 'Ok' ,
                cancelButton: 'Cancel',
                confirm: function () {
                    var userIDs =user_id;
                    //console.log(userIDs);
                    $.ajax({
                        type: 'post',
                        dataType: 'json',
                        data: {
                            userIDs: userIDs,
                            status: status,
                            _token: _token
                        },
                        url: changeUserAccountStatus,
                        success: function (response)
                        {
                          // window.location.href =window.location.href;
                          window.location = statusUserAccountSuccessRedirectURLSingle + "/?count=" + 1;
                        }
                    });

                },
                cancel: function () {
                }
            });
            //var url = "{{URL::to('/admin/user/deleteUserAccountID')}}" + "/" + i;
            /*$('#cardtype').text(c.getAttribute("data-cardtype"));
            $('#cardnumber').text(c.getAttribute("data-cardnumber"));
            $('#removeModal').modal('toggle');
            $('#rlink').attr("href", url);*/
        }

       
    </script>
    <style>
        #entriesLine{
            width:auto;
            float:left;
            padding:8px 0px 0px 0px;
        }
        #paginationLine {
            width:100%;
            float:left;
            padding:8px 0px 0px 0px;
        }
        #pageInfo{float:right; padding:8px 0px 0px 0px;}
        #paginationLine div {
            float:left !important;
        }

        #quickJumpToPageTxt {
            width:30px;
        }

        .paginate_button {
            border: 1px solid #cacaca !important;
        }

        div.dt-buttons > a.dt-button { visibility: hidden;}
        #paginationLine div {
            float: right !important;
        }
    </style>
     <script>
        var loadDataSet = "{{ route('admin_users_list_dataset') }}";
        var deleteUserAccountURL = "{{ route('admin_users_delete_user_account') }}";
        var deleteUserAccountSuccessRedirectURL = "{{ route('admin_users_delete_user_account_success_redirect') }}";
        var _token = "{{csrf_token()}}";
    </script>
    <script src="{{ asset("js/admin_users_list.js") }}"></script>
    <div class = "box box-info">
        <div class="col-sm-12">
            <div class="change-form-bg clearfix">
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
                <div class = "message-info clearfix">
                    <h3 class = "box-title">Accounts</h3>
                </div>
                <div class="row">
                    <div class="col-md-12 add-btns">
                        <a href="javascript:void(0 );" class="btn btn-block btn-primary btn-danger delete-accounts btn-radius">Delete accounts</a>
                        <a href="javascript:void(0);" class="btn btn-block btn-primary btn-radius btn-apply" id="applySearchBtn">Apply</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 ">
                        <div class="links-line clearfix">
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="section-search clearfix">
                                    <span class="pull-left">
                                        Show
                                        <select name="entriesSlct" id="entriesSlct" style="width:50px;">
                                           <option value="100">100</option>
                                            <option value="50">50</option>
                                            <option value="25">25</option>
                                            <option value="20">20</option>
                                            <option value="15">15</option>
                                            <option value="10">10</option>
                                        </select>
                                        Entries
                                    </span>
                                    <span class="pull-right">
                                        Search: <input class="info-personal" type="text" name="globalSearchTxt" id="globalSearchTxt"  maxlength="100" placeholder="Name or Email"/>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="table-scroll">
                            <table id="adminUsersListDT" class="table table-striped table-bordered table-vcenter">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="checkAll" id="checkAll" /></th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Country</th>
                                        <th>Number of cards</th>
                                        <th>Number of US bank accounts</th>
                                        <th>Creation date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="page-num">
                            Go to page: <input type="text" name="quickJumpToPageTxt" id="quickJumpToPageTxt" /><a href="javascript:void(0);" id="goTriggerBtn" class="btn btn-primary btn-go">Go</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 add-btns">
                        <a  href="javascript:void(0);" class="btn btn-block btn-primary btn-danger delete-accounts btn-radius">Delete accounts</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
