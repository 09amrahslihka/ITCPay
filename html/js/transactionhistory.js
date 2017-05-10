$(function () {
    $('body').on('hidden.bs.modal', "#myModal", function () {
        $(this).removeData('bs.modal');
    });

    var dateFormat = "dd-mm-yy",
            from = $("#fromDateTxt")
            .datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 1,
                dateFormat: "dd-mm-yy"
            })
            .on("change", function () {
                to.datepicker("option", "minDate", getDate(this));
            }),
            to = $("#toDateTxt").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        dateFormat: "dd-mm-yy"
    })
            .on("change", function () {
                from.datepicker("option", "maxDate", getDate(this));
            });

    function getDate(element) {
        var date;
        try {
            date = $.datepicker.parseDate(dateFormat, element.value);
        } catch (error) {
            date = null;
        }

        return date;
    }

    //$.fn.DataTable.ext.pager.numbers_length = 6; //will show only 5 quick page number links
    $('#transactionsHistoryPageDT').dataTable({
        "ajax": {
            "url": loadDataSet,
            "data": function (d) {
                //alter data before post
                d.length = parseInt($('#entriesSlct').val());
                //add new field parameters
                d.globalSearchTxt = $('#globalSearchTxt').val().trim();
                d.searchKeywordTxt = $('#searchKeywordTxt').val().trim();
                d.transactionTypeSlct = $('#transactionTypeSlct').val().trim();
                d.transactionStatusSlct = $('#transactionStatusSlct').val().trim();
                d.dateRangeSlct = $('#dateRangeSlct').val().trim();
                d.fromDateTxt = $('#fromDateTxt').val().trim();
                d.toDateTxt = $('#toDateTxt').val().trim();
                d.pageType = "transaction_history";
            }
        },
        "order": [[0, "desc"]],
//        "aoColumnDefs": [
//            { 'bSortable': false, 'aTargets': [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ] },
//            { 'bSearchable': false, 'aTargets': [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ] }
//         ],
        "columnDefs": [
            {"name": "created_at", "targets": [0]},
            {"name": "", 'aTargets': [1], 'bSortable': false, "orderable": false},
            {"name": "name", "targets": [2]},
            {"name": "status", 'targets': [3]},
            {"name": "", 'aTargets': [4], 'bSortable': false, "orderable": false},
            {"name": "gross", 'targets': [5]},
            {"name": "fee", 'targets': [6]},
            {"name": "net_amount", 'aTargets': [7], 'bSortable': false, "orderable": false},
            {"name": "balance", 'targets': [8]},
        ],
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
 if(firstEntry==0){ $('#tragobtn').css("display",'none')}
            $('#quickJumpToPageTxt').val(currentPage);
        },
        "lengthMenu": [10, 15, 20, 25, 50, 100],
        "language": {
            "emptyTable": "No transactions yet!",
            "zeroRecords": "No transactions found!"
        },
        "pageLength": defaultLength,
        "processing": true,
        "serverSide": true,
        //"stateSave": true,
        "stateSaveParams": function (settings, data) {
            data.length = $('#entriesSlct').val().trim();
        }
    });

    var table = $('#transactionsHistoryPageDT').DataTable();

    //load state parameters
    var stateParams = table.state.loaded();
    if (typeof stateParams != undefined && stateParams != null) {
        $('#entriesSlct').val(stateParams.length);
    }


    $('body').off('keydown', '[name="quickJumpToPageTxt"]').on('keydown', '[name="quickJumpToPageTxt"]', function (e) {
        -1 !== $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) || /65|67|86|88/.test(e.keyCode) && (!0 === e.ctrlKey || !0 === e.metaKey) || 35 <= e.keyCode && 40 >= e.keyCode || (e.shiftKey || 48 > e.keyCode || 57 < e.keyCode) && (96 > e.keyCode || 105 < e.keyCode) && e.preventDefault()
    })
            //quick jump to page link
            .off('keyup', '[name="quickJumpToPageTxt"]').on('keyup', '[name="quickJumpToPageTxt"]', function (event) {
        if (event.keyCode == 13) {
            var number = parseInt($(this).val());
            if (number == 0 || number > table.page.info().pages) {
                $.notify("Supply page number within the range(1-" + table.page.info().pages + ")!", "error");
            } else {
                table.page(number - 1).draw(false);
            }
        }
    })
            //all filters change event        
            .off('change', '#globalSearchTxt').on('keyup', '#globalSearchTxt', function (event) {
        if (event.keyCode == 13) {
            table.page(0).draw(false);
        }
    })
            .off('change', '#entriesSlct').on('change', '#entriesSlct', function () {
        table.page.len(parseInt($(this).val()));
        table.page(0).draw(false);
    })
            //show hide advanced search fields
            .off('click', '#advancedSearchOptionsLnk').on('click', '#advancedSearchOptionsLnk', function (event) {
        if ($('#advancedSearchFieldsDiv').is(':visible')) {
            $('#clearSearchButton').trigger('click');
            $('#advancedSearchFieldsDiv').slideUp();
            $('#globalSearchTxt').val("");
            $('#globalSearchTxt').prop("readonly", false);
        } else {
            $('#clearSearchButton').trigger('click');
            $('#advancedSearchFieldsDiv').slideDown();
            $('#globalSearchTxt').val("");
            $('#globalSearchTxt').prop("readonly", true);
        }
    })
            //show hide custom date range fields
            .off('change', '#dateRangeSlct').on('change', '#dateRangeSlct', function (event) {
        if ($(this).val() === "range") {
            $('#customDateRangeFields').show();
        } else {
            $('#customDateRangeFields').hide();
        }
        $('.date-range-fields').val("");
    })
            //reset button click
            .off('click', '#resetLnk').on('click', '#resetLnk', function (event) {
        $('#advancedSearchFieldsDiv').slideUp();
        resetDataTable();
    })
            .off('click', '#advancedSearchButton').on('click', '#advancedSearchButton', function (event) {
        displayAdvancedSearchInfo();
        table.page(0).draw(false);
    })
            .off('click', '#clearSearchButton').on('click', '#clearSearchButton', function (event) {
        $('#transactionTypeSlct, #searchKeywordTxt, #dateRangeSlct, #fromDateTxt, #toDateTxt, #transactionStatusSlct').val("");
        $('#dateRangeSlct').trigger("change");
        displayAdvancedSearchInfo();
        table.page(0).draw(false);
    })
            .off('click', '#closeAdvancedSearchButton').on('click', '#closeAdvancedSearchButton', function (event) {
        $('#advancedSearchOptionsLnk').trigger('click');
    })
            .off('click', '#downloadPDFLnk').on('click', '#downloadPDFLnk', function () {
        if ($.active == 0) {
            if (typeof table == 'undefined')
                var table = $('#transactionsHistoryPageDT').DataTable();

            var rawDTData = table.rows().data().toArray();

            var dtData = [];
            $.each(rawDTData, function (index, rowArr) {
                var correctedRow = $.extend(true, {}, rowArr);
                delete correctedRow[4];
                dtData.push(correctedRow);
            });

            var pageInfo = table.page.info();

            $.post({
                url: exportToPdf,
                data: {data: dtData, pages: pageInfo, _token: _token},
                success: function (data) {
                    var result = $.parseJSON(data);
                    if (result.url) {
                        //window.location = result.url;
                        var win = window.open(result.url, '_blank');
                    } else {
                        alert('Unable to download the file, please try after some time.');
                    }
                },
                error: function () {
                    alert('Unknown error, please try after some time.')
                }
            });

        }
        //$('div.dt-buttons > a.buttons-pdf').trigger('click');
    })
            .off('click', '#printLnk').on('click', '#printLnk', function (event) {
        if ($.active == 0) {
            if (typeof table == 'undefined')
                var table = $('#transactionsHistoryPageDT').DataTable();

            var rawDTData = table.rows().data().toArray();

            var dtData = [];
            $.each(rawDTData, function (index, rowArr) {
                var correctedRow = $.extend(true, {}, rowArr);
                delete correctedRow[4];
                dtData.push(correctedRow);
            });

            var pageInfo = table.page.info();

            $.post({
                url: exportToHtml,
                data: {data: dtData, pages: pageInfo, _token: _token},
                success: function (data) {
                    var result = $.parseJSON(data);
                    if (result.url) {
                        var win = window.open(result.url, '_blank');
                    } else {
                        alert('Unable to download the file, please try after some time.');
                    }
                },
                error: function () {
                    alert('Unknown error, please try after some time.')
                }
            });

        }
        //$('div.dt-buttons > a.buttons-print').trigger('click');
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
    });
});

/**
 * resetDataTable
 * 
 * @returns {undefined}
 */
function resetDataTable() {
    $('#globalSearchTxt, #transactionTypeSlct, #searchKeywordTxt, #dateRangeSlct, #fromDateTxt, #toDateTxt, #transactionStatusSlct').val("");
    $('#entriesSlct').val("10");
    $('#dateRangeSlct').trigger("change");
    var table = $('#transactionsHistoryPageDT').DataTable();
    table.page(0).draw(false);
}

/**
 * displayAdvancedSearchInfo
 */
function displayAdvancedSearchInfo() {
    var searchKeywordTxt = $('#searchKeywordTxt').val().trim();
    var transactionTypeSlct = $('#transactionTypeSlct').val().trim();
    var dateRangeSlct = $('#dateRangeSlct').val().trim();
    var fromDateTxt = $('#fromDateTxt').val().trim();
    var toDateTxt = $('#toDateTxt').val().trim();


    $('#additionalSearchKeywordInfo').text("");
    if (searchKeywordTxt != "") {
        $('#additionalSearchKeywordInfo').text("Searching for: \"" + searchKeywordTxt + "\"");
    }

    var text = "";
    $('#advancedSearchInfo').text("");
    if (transactionTypeSlct != "") {
        text += $('#transactionTypeSlct option[value="' + transactionTypeSlct + '"]').text();
    }

    if (dateRangeSlct != "") {
        switch (dateRangeSlct) {
            case "range":
                text += (text != "" ? " " : "All Transactions ") + "from " + fromDateTxt + " to " + toDateTxt + ".";
                break;
            case "this_week":
                text += (text != "" ? " " : "All Transactions ") + "from this week.";
                break;
            case "last_week":
                text += (text != "" ? " " : "All Transactions ") + "from last week.";
                break;
            case "this_month":
                text += (text != "" ? " " : "All Transactions ") + "from this month.";
                break;
            case "last_month":
                text += (text != "" ? " " : "All Transactions ") + "from last month.";
                break;
            case "last_3_months":
        }
    } else {
        if (text != "") {
            text = "Showing All Transactions for \"" + text + "\".";
        } else {
            text = "Showing All Transactions.";
        }
    }
    $('#advancedSearchInfo').text(text);
}
