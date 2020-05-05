<?php


namespace WordpressMagicBoilerplate\Classes;


use WordpressMagicBoilerplate\Utils\Ajax;

class AjaxOut3 extends Ajax
{
    public $js = true;

    public function callback($request)
    {
        $json = ["out" => "AJAX Content 3"];
        wp_send_json($json);
    }

}