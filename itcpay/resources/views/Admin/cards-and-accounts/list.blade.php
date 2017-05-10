@extends('Admin.dashboard.layouts.master')

@section('content')
    <link rel="stylesheet" href="{{asset('js/jquery-ui-1.12.0.custom/jquery-ui.css')}}">
    <script src="{{ asset("js/jquery-ui-1.12.0.custom/jquery-ui.js") }}"></script>
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
        var loadDataSet = "{{ route('admin_cards_and_accounts_list_dataset') }}";
        var deleteCardOrAccountURL = "{{ route('admin_cards_and_accounts_delete') }}";
        var deleteCardOrAccountSuccessRedirectURL = "{{ route('admin_cards_and_accounts_success_redirect') }}";
        var _token = "{{csrf_token()}}";

        function editModal(i)
        {
            var url = "{{URL::to('/admin/commands/edit-command')}}" + "/" + i;
            var edit = $('#edit-command-link');
            $('#editCommandModal').modal('toggle');

            edit.attr("data-url", url);
            edit.attr("data-id", i);
        }


        $(function()
        {
            $('#edit-command-link').on('click', function()
            {
                var newCommandNumber = $('#newCommandNumber').val();
                var edit             = $('#edit-command-link');

                if (newCommandNumber.length)
                {
                    var url = edit.data('url');
                    var id = edit.data('id');

                    $.post(url, {id: id, number: newCommandNumber, _token: _token}, function(data)
                    {
                        if (data.status == 'ok')
                            $('#adminCardsAndAccountsListDT').find("[data-id='" + id + "']").text(data.number)
                        else
                            alert('error');

                        $('#editCommandModal').modal('toggle');
                    })
                }
            })
        })

    </script>
    <script src="{{ asset("js/admin_cards_and_accounts_list.js") }}"></script>

    <div class="modal fade" id="editCommandModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Input new command number</h4>
                </div>
                <div class="modal-body">
                    <input type="number" id="newCommandNumber">
                </div>
                <div class="modal-footer">
                    <button type="button"  id="edit-command-link" class="btn btn-danger">change</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>


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
                    <h3 class = "box-title">Cards And US Bank Accounts</h3>
                </div>
      	<div class="row">
                <div class="col-md-12 add-btns">
                    <a  href="javascript:void(0);" class="btn btn-block btn-primary btn-danger delete-accounts btn-radius">Delete cards/accounts</a>
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
                            <table id="adminCardsAndAccountsListDT" class="table table-striped table-bordered table-vcenter">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="checkAll" id="checkAll" /></th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Info</th>
                                        <th>Country</th>
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
                        <a  href="javascript:void(0);" class="btn btn-block btn-primary btn-danger delete-accounts btn-radius">Delete cards/accounts</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop
