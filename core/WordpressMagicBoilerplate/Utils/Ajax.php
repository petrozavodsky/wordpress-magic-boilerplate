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

    protected $jsPosition = 'wp_footer';

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

        $this->action = $actionName;
        $this->ajaxUrl = $this->createAjaxUrl();
        $this->ajaxUrlAction = $this->createAjaxUrlAction($actionName);

        $this->$type($actionName);

        if (method_exists($this, 'init')) {
            $this->init($actionName);
        }

        $this->assets();
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
    public function varsAjax($handle, $data = [])
    {
        $data = wp_parse_args(
            $data,
            [
                'ajaxUrlAction' => $this->ajaxUrlAction,
                'ajaxUrl' => $this->ajaxUrl,
            ]
        );

        add_action($this->jsPosition, function () use ($data, $handle) {
            wp_localize_script(
                $handle,
                str_replace('-', '_', $handle . "__vars"),
                $data
            );
        },);
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
