$(function() {

$("#go-to-email").click(function(event){
    event.keyCode
});
 function stripTrailingSlash(str) {

        return str;
    }

//    var url = window.location.pathname;
    var url = window.location.href;
    var activePage = stripTrailingSlash(url);

    $('.sidebar-menu li a').each(function () {
        var currentPage = stripTrailingSlash($(this).attr('href'));

        if (activePage == currentPage) {
            $(this).parent().addClass('active');
        }
    });
});