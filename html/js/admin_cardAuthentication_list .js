/**
 * script: admin_users_list
 * created Sep 13, 2016
 *
 * @author Naman Attri<naman@it7solutions.com>
 */
$(function () {
    $('#adminIdentityListDT').dataTable({
        "ajax": {
            "url": loadDataSet,
            "data": function (d) {
                console.log(d);
                //alter data before post
                d.length = parseInt($('#entriesSlct').val());   
                //add new field parameters
                d.globalSearchTxt = $('#globalSearchTxt').val().trim();
            }
        },
		"order":[[6,"desc"]],
          "columnDefs": [
            {"name": "count", 'aTargets': [0], 'bSortable': false, "orderable": false},
            {"name": "profile.fname", "targets": [1]},
            {"name": "users.email", "targets": [2]},
            {"name": "profile_country", 'targets': [3]},
            {"name": "Date and time of request", "targets": [4]},
            {"name": "Information and documents", "targets": [5]},
            {"name": "created_at", "targets": [6]}
        ],

//        "aoColumnDefs": [
//            {'bSortable': false, 'aTargets': [0, 1, 2]},
//            {'bSearchable': false, 'aTargets': [0, 1, 2]}
//        ],
        "dom": 'rt<"#entriesLine"><"#pageInfo"><"#paginationLine"p>',
        "drawCallback": function (settings) {
            var pageInfo = this.api().page.info();
            var firstEntry = pageInfo.recordsDisplay > 0 ? pageInfo.start + 1 : pageInfo.start;
            var lastEntry = pageInfo.end;
            var totalEntries = pageInfo.recordsDisplay;
            var entryPlurality = pageInfo.recordsDisplay > 1 ? "entries" : "entry"

            $('#entriesLine').text("Showing " + firstEntry + " to " + lastEntry + " of " + totalEntries + " " + entryPlurality + ".");

            var currentPage = pageInfo.pages > 0 ? pageInfo.page + 1 : 0;
            var pagePlurality = pageInfo.pages > 1 ? "pages" : "page";
            $('#pageInfo').text("Showing page " + currentPage + " of " + pageInfo.pages + " " + pagePlurality + ".");

            $('#quickJumpToPageTxt').val(currentPage);

            $('#checkAll, .users-checked').prop('checked', false);
        },
        "lengthMenu": [100, 150, 200],
        "language": {
            "emptyTable": "No transactions yet!",
            "zeroRecords": "No transactions found!"
        },
        "processing": true,
        "serverSide": true,
        //"stateSave": true,
        "stateSaveParams": function (settings, data) {
            data.length = $('#entriesSlct').val().trim();
        }
    });

    var table = $('#adminIdentityListDT').DataTable();

    $('body').off('change', '#entriesSlct').on('change', '#entriesSlct', function () {
        table.page.len(parseInt($(this).val()));
        table.page(0).draw(false);
    }).off('click', '#applySearchBtn').on('click', '#applySearchBtn', function (event) {
        table.page.len(parseInt($('#entriesSlct').val()));
        table.page(0).draw(false);
    }).off('keydown', '[name="quickJumpToPageTxt"]').on('keydown', '[name="quickJumpToPageTxt"]', function (e) {
        -1 !== $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) || /65|67|86|88/.test(e.keyCode) && (!0 === e.ctrlKey || !0 === e.metaKey) || 35 <= e.keyCode && 40 >= e.keyCode || (e.shiftKey || 48 > e.keyCode || 57 < e.keyCode) && (96 > e.keyCode || 105 < e.keyCode) && e.preventDefault()
    })
            //quick jump to page link
            .off('keyup', '[name="quickJumpToPageTxt"]').on('keyup', '[name="quickJumpToPageTxt"]', function (event) {
        if (event.keyCode == 13) {
            var number = parseInt($(this).val());
            if (typeof number == 'undefined' || number == 0 || number > table.page.info().pages) {
                $.notify("Supply page number within the range(1-" + table.page.info().pages + ")!", "error");
            } else {
                table.page(number - 1).draw(false);
            }
        }
    })
            .off('click', '#goTriggerBtn').on('click', '#goTriggerBtn', function (event) {
        var number = parseInt($('[name="quickJumpToPageTxt"]').val());
        if (isNaN(number) || number == 0 || number > table.page.info().pages) {
            $.notify("Supply page number within the range(1-" + table.page.info().pages + ")!", "error");
        } else {
            table.page(number - 1).draw(false);
        }
    })
            //all filters change event
            .off('change', '#globalSearchTxt').on('keyup', '#globalSearchTxt', function (event) {
        if (event.keyCode == 13) {
            table.page(0).draw(false);
        }
    });

    //load state parameters
    var stateParams = table.state.loaded();
    if (typeof stateParams != undefined && stateParams != null) {
        $('#entriesSlct').val(stateParams.length);
    }

    $('body').on('change', '#checkAll', function (event) {
        $('.users-checked').prop('checked', $(this).prop('checked'));
    }).on('change', '.users-checked', function (event) {
        $('#checkAll').prop('checked', $('.users-checked:checked').length > 0 && $('.users-checked:checked').length == $('.users-checked').length);
    }).off('click', '.delete-accounts').on('click', '.delete-accounts', function (event) {
        if ($('.users-checked:checked').length > 0) {
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure you want to delete selected users?',
                confirmButton: 'Remove',
                cancelButton: 'Cancel',
                confirm: function () {
                    var userIDs = [];
                $('.users-checked:checked').each(function (index, element) {
                    userIDs.push($(element).val());
                });
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    data: {
                        userIDs: userIDs,
                        _token: _token
                    },
                    url: deleteUserAccountURL,
                    success: function (response) {
                        window.location = deleteUserAccountSuccessRedirectURL + "/?count=" + userIDs.length
                    }
                });
                    
                },
                cancel: function () {
                }
            });
        } else {
            $.notify("Please select at least one user!", "error");
        }
    });
});
