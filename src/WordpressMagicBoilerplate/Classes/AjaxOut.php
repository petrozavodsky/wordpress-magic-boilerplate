<?php

namespace WordpressMagicBoilerplate\Classes;

use WordpressMagicBoilerplate\Utils\Ajax;
use WordpressMagicBoilerplate\Utils\Assets;

class AjaxOut extends Ajax
{

    use Assets;

    public function init($actionName)
    {
        $this->addJsCss($actionName);
    }

    public function callback($request)
    {
        $json = ["out" => "AJAX Content 1"];
        wp_send_json($json);
    }

    private function addJsCss($action)
    {
        $handle = $this->addJs(
            $action,
            'header',
            ['jquery']
        );

        $this->varsAjax(
            $handle,
            [
                'ajaxUrl' => $this->ajaxUrl,
                'ajaxUrlAction' => $this->ajaxUrlAction,
            ]
        );
    }
}
