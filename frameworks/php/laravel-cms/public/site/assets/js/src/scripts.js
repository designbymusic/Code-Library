$(function() {
    $("form[data-confirm]").submit(function() {
        if ( ! confirm($(this).attr("data-confirm"))) {
            return false;
        }
    });
});