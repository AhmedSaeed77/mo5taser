/*global $, alert, console */
    $('.countdown').each(function() {
        var content = $(this).html();
        
        var count = $(this).attr('data-count')

        $(this).countdown(count,function(event) {
            $(this).html(event.strftime(content));
        })
    });