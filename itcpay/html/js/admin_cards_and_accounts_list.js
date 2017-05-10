$(function ()
{
    $('#adminCardsAndAccountsListDT').dataTable({
        "ajax": {
            "url": loadDataSet,
            "data": function (d)
            {
                //alter data before post
                d.length = parseInt($('#entriesSlct').val());
                //add new field parameters
                d.globalSearchTxt = $('#globalSearchTxt').val().trim();
            }
        },
        "columnDefs": [
            {"name": "", "targets": [0], 'aTargets': [0], 'bSortable': false, "orderable": false},
            {"name": "name", "targets": [1], 'aTargets': [0]},
            {"name": "email", "targets": [2], 'aTargets': [0]},
            {"name": "", 'aTargets': [3, 0], 'bSortable': false, "orderable": false},
            {"name": "country", "targets": [4], 'aTargets': [0]}
        ],
//        "order": [[1, "asc"]],
        "dom": 'rt<"#entriesLine"><"#pageInfo"><"#paginationLine"p>',
        "drawCallback": function (settings)
        {
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

            $('#checkAll, .cards-and-accounts-checked').prop('checked', false);
        },
        "lengthMenu": [100, 150, 200],
        "language": {
            "emptyTable": "No cards or accounts found",
            "zeroRecords": "No cards or accounts found"
        },
        "processing": true,
        "serverSide": true,
        //"stateSave": true,
        "stateSaveParams": function (settings, data)
        {
            data.length = $('#entriesSlct').val().trim();
        }
    });

    var table = $('#adminCardsAndAccountsListDT').DataTable();

    $('body').off('change', '#entriesSlct').on('change', '#entriesSlct', function ()
    {
        table.page.len(parseInt($(this).val()));
        table.page(0).draw(false);
    }).off('click', '#applySearchBtn').on('click', '#applySearchBtn', function (event)
    {
        table.page.len(parseInt($('#entriesSlct').val()));
        table.page(0).draw(false);
    }).off('keydown', '[name="quickJumpToPageTxt"]').on('keydown', '[name="quickJumpToPageTxt"]', function (e)
    {
        -1 !== $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) || /65|67|86|88/.test(e.keyCode) && (!0 === e.ctrlKey || !0 === e.metaKey) || 35 <= e.keyCode && 40 >= e.keyCode || (e.shiftKey || 48 > e.keyCode || 57 < e.keyCode) && (96 > e.keyCode || 105 < e.keyCode) && e.preventDefault()
    })
            //quick jump to page link
            .off('keyup', '[name="quickJumpToPageTxt"]').on('keyup', '[name="quickJumpToPageTxt"]', function (event)
    {
        if (event.keyCode == 13)
        {
            var number = parseInt($(this).val());
            if (typeof number == 'undefined' || number == 0 || number > table.page.info().pages)
            {
                $.notify("Supply page number within the range(1-" + table.page.info().pages + ")!", "error");
            } else
            {
                table.page(number - 1).draw(false);
            }
        }
    }).off('click', '#goTriggerBtn').on('click', '#goTriggerBtn', function (event)
    {
        var number = parseInt($('[name="quickJumpToPageTxt"]').val());
        if (isNaN(number) || number == 0 || number > table.page.info().pages)
        {
            $.notify("Supply page number within the range(1-" + table.page.info().pages + ")!", "error");
        } else
        {
            table.page(number - 1).draw(false);
        }
    })
            //all filters change event
            .off('change', '#globalSearchTxt').on('keyup', '#globalSearchTxt', function (event)
    {
        if (event.keyCode == 13)
        {
            table.page(0).draw(false);
        }
    });

    //load state parameters
    var stateParams = table.state.loaded();
    if (typeof stateParams != undefined && stateParams != null)
    {
        $('#entriesSlct').val(stateParams.length);
    }

    $('body').on('change', '#checkAll', function (event)
    {
        $('.cards-and-accounts-checked').prop('checked', $(this).prop('checked'));
    }).on('change', '.cards-and-accounts-checked', function (event)
    {
        $('#checkAll').prop('checked', $('.cards-and-accounts-checked:checked').length > 0 && $('.cards-and-accounts-checked:checked').length == $('.cards-and-accounts-checked').length);
    }).off('click', '.delete-accounts').on('click', '.delete-accounts', function (event)
    {
        if ($('.cards-and-accounts-checked:checked').length > 0)
        {

            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure you want to delete selected users?',
                confirmButton: 'Remove',
                cancelButton: 'Cancel',
                confirm: function () {
                    var userIDs = [];
                    $('.cards-and-accounts-checked:checked').each(function (index, element)
                    {
                        userIDs.push($(element).val());
                    });
                    console.log(userIDs);

                    $.ajax({
                        type: 'post',
                        dataType: 'json',
                        data: {
                            userIDs: userIDs,
                            _token: _token
                        },
                        url: deleteCardOrAccountURL,
                        success: function (response)
                        {
                            window.location = deleteCardOrAccountSuccessRedirectURL + "/?count=" + userIDs.length
                        }
                    });

                },
                cancel: function () {
                }
            });
        } else
        {
            $.notify("Please select at least one user!", "error");
        }
    });
});
