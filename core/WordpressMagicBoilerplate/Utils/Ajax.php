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
			$this->init( $action_name );
		}
	}

	/**
	 * @param string $action_name
	 * @param string $callback
	 */
	public function front( $action_name, $callback = 'payload_action' ) {
		add_action( 'wp_ajax_' . $action_name, array( $this, $callback ) );
		add_action( 'wp_ajax_nopriv_' . $action_name, array( $this, $callback ) );
	}

	/**
	 * @param string $action_name
	 * @param string $callback
	 */

	public function admin( $action_name, $callback = 'payload_action' ) {
		add_action( 'wp_ajax_' . $action_name, array( $this, $callback ) );
	}

	/**
	 *
	 * @param string $handle
	 * @param array $data
	 *
	 */
	public function vars_ajax( $handle, $data ) {

		add_action( 'wp_enqueue_scripts', function () use ( $data, $handle ) {
			wp_localize_script(
				$handle,
				str_replace( '-', '_', $handle . "__vars" ),
				$data
			);

		}, 80 );

	}

	public function payload() {
		$request = $_REQUEST;
		unset( $request['action'] );
		$this->callback( $request );
		die;
	}

	public function payload_action() {
		$request = $_REQUEST;
		$this->callback( $request );
		die;
	}

	/**
	 * @param string $request
	 *
	 * @return mixed
	 */
	abstract public function callback( $request );

}