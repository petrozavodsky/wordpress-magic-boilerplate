<?php

namespace WordpressMagicBoilerplate\Utils;

abstract class Ajax
{
    use Assets;

    protected $ajaxUrl;

    protected $ajaxUrlAction;

    protected $action;

    protected $js = false;

    protected $jsDependences = [];

    protected $jsPosition;

    protected $jsVersion = '1.0.0';

    /**
     * Ajax constructor.
     *
     * @param string $actionName
     * @param string $type
     *
     */
    public function __construct($actionName, $type = 'front')
    {

        $this->jsPosition = $this->jsPositionCalc($this->jsPosition);

        $this->action = $actionName;
        $this->ajaxUrl = $this->createAjaxUrl();
        $this->ajaxUrlAction = $this->createAjaxUrlAction($actionName);

        $this->$type($actionName);

        if (method_exists($this, 'init')) {
            $this->init($actionName);
        }

        $this->assets();
    }

    protected function jsPositionCalc($position)
    {
        if ($position == "wp_footer" || $position == "footer" || $position == "body") {
            return "wp_footer";
        } elseif ($position == 'admin' || $position == 'admin_header' || $position == 'admin_head') {
            return 'admin_enqueue_scripts';
        } elseif ($position == 'login' || $position == 'login-page') {
            return 'login_enqueue_scripts';
        } elseif ($position == "wp_head" || $position == "wp_enqueue_script" || $position == "header" || $position == "head") {
            return "wp_enqueue_scripts";
        }

        return "wp_enqueue_scripts";
    }

    protected function assets()
    {
        if ($this->js) {

            $jsHandle = $this->addJs(
                $this->action,
                $this->jsPosition,
                $this->jsDependences,
                $this->jsVersion
            );

            $this->varsAjax($jsHandle);
        }
    }

    /**
     * @return string
     */
    protected function createAjaxUrl()
    {
        return admin_url('admin-ajax.php');
    }

    /**
     * @param $action
     *
     * @return string
     */
    protected function createAjaxUrlAction($action)
    {
        return add_query_arg(['action' => $this->action], $this->ajaxUrl);
    }

    /**
     *
     * @param string $handle
     * @param array $data
     *
     */
    public function varsAjax($handle, $data = [], $position = false)
    {

        if (false == $position) {
            $position = $this->jsPosition;
        } else {
            $position = $this->jsPositionCalc($position);
        }

        $data = wp_parse_args(
            $data,
            [
                'ajaxUrlAction' => $this->ajaxUrlAction,
                'ajaxUrl' => $this->ajaxUrl,
            ]
        );

        add_action($position, function () use ($data, $handle) {
            wp_localize_script(
                $handle,
                str_replace('-', '_', $handle . "__vars"),
                $data
            );
        }, 11);
    }

    public function front($actionName, $callback = 'payload')
    {
        add_action('wp_ajax_' . $actionName, [$this, $callback]);
        add_action('wp_ajax_nopriv_' . $actionName, [$this, $callback]);
    }


    public function admin($actionName, $callback = 'payload')
    {
        add_action('wp_ajax_' . $actionName, [$this, $callback]);
    }

    public function payload()
    {
        $request = $_REQUEST;
        unset($request['action']);
        $this->callback($request);
    }

    abstract public function callback($request);

}
