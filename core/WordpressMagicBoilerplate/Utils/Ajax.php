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
	function __construct( $action_name, $type = 'init_hook' ) {
		$this->$type( $action_name );
	}

	public function init_hook( $action_name, $callback = 'payload_action' ) {
		add_action( 'wp_ajax_' . $action_name, array( $this, $callback ) );
		add_action( 'wp_ajax_nopriv_' . $action_name, array( $this, $callback ) );
	}

	public function payload() {
		$request = $_REQUEST;
		unset($request['action']);
		$this->callback($request);
	}

	public function payload_action(){
		$request = $_REQUEST;
		$this->callback($request);
		die;
	}

	abstract public function callback($request);

}