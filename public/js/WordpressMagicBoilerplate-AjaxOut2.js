var $ = jQuery.noConflict();

$(document).ready(function () {

    $.get(WordpressMagicBoilerplate_AjaxOut2__vars.action_url, function (result) {
        console.log(result);
    });
});