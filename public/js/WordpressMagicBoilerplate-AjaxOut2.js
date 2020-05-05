var $ = jQuery.noConflict();

$(document).ready(function () {

    $.get(WordpressMagicBoilerplate_AjaxOut2__vars.ajaxUrlAction, function (result) {
        console.log(result);
    });
});