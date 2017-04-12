<?php

namespace WordpressMagicBoilerplate\Utils;


abstract class Ajax {

	/**
	 * Ajax constructor.
	 *
	 * @param string $action_name
	 * @param string $type
	 *
	 */
	function __construct( $action_name, $type = 'front' ) {
		$this->$type( $action_name );

		if ( method_exists( $this, 'init' ) ) {
			$this->init($action_name);
		}
	}

	public function front( $action_name, $callback = 'payload_action' ) {
		add_action( 'wp_ajax_' . $action_name, array( $this, $callback ) );
		add_action( 'wp_ajax_nopriv_' . $action_name, array( $this, $callback ) );
	}

	public function admin( $action_name, $callback = 'payload_action' ) {
		add_action( 'wp_ajax_' . $action_name, array( $this, $callback ) );
	}

	public function payload() {
		$request = $_REQUEST;
		unset($request['action']);
		$this->callback($request);
		die;
	}

	public function payload_action(){
		$request = $_REQUEST;
		$this->callback($request);
		die;
	}

	abstract public function callback($request);

}