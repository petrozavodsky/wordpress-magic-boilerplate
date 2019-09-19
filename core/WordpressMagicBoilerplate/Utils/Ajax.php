<?php

namespace WordpressMagicBoilerplate\Utils;

abstract class Ajax {

	protected $ajaxUrl;
	protected $ajaxUrlAction;
	protected $action;

	/**
	 * Ajax constructor.
	 *
	 * @param string $actionName
	 * @param string $type
	 *
	 */
	public function __construct($actionName, $type = 'front' ) {

		$this->action        = $actionName;
		$this->ajaxUrl        = $this->createAjaxUrl();
		$this->ajaxUrlAction = $this->createAjaxUrlAction( $actionName );

		$this->$type( $actionName );

		if ( method_exists( $this, 'init' ) ) {
			$this->init( $actionName );
		}
	}

	/**
	 * @return string
	 */
	protected function createAjaxUrl() {
		return admin_url( 'admin-ajax.php' );
	}

	/**
	 * @param $action
	 *
	 * @return string
	 */
	protected function createAjaxUrlAction( $action ) {
		return add_query_arg( [ 'action' => $action ], $this->ajaxUrl );
	}

	/**
	 *
	 * @param string $handle
	 * @param array $data
	 *
	 */
	public function varsAjax( $handle, $data ) {

        $actions = [
            'login_enqueue_scripts',
            'wp_enqueue_scripts',
            'admin_enqueue_scripts'
        ];

        foreach ($actions as $action)

		add_action( $action, function () use ( $data, $handle ) {
			wp_localize_script(
				$handle,
				str_replace( '-', '_', $handle . "__vars" ),
				$data
			);
		}, 80 );

	}

	public function front($actionName, $callback = 'payload' ) {
		add_action( 'wp_ajax_' . $actionName, [ $this, $callback]  );
		add_action( 'wp_ajax_nopriv_' . $actionName, [ $this, $callback ] );
	}


	public function admin($actionName, $callback = 'payload' ) {
		add_action( 'wp_ajax_' . $actionName, [$this, $callback] );
	}

	public function payload() {
		$request = $_REQUEST;
		unset( $request['action'] );
		$this->callback( $request );
	}

	abstract public function callback( $request );

}
