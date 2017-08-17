<?php

namespace WordpressMagicBoilerplate\Utils;


abstract class Ajax {

	protected $ajax_url;
	protected $ajax_url_action;


	/**
	 * Ajax constructor.
	 *
	 * @param string $action_name
	 * @param string $type
	 *
	 */
	function __construct( $action_name, $type = 'front' ) {

		$this->ajax_url        = $this->create_ajax_url();
		$this->ajax_url_action = $this->create_ajax_url_action( $action_name );

		$this->$type( $action_name );

		if ( method_exists( $this, 'init' ) ) {
			$this->init( $action_name );
		}
	}

	/**
	 * @return string
	 */
	protected function create_ajax_url() {
		return admin_url( 'admin-ajax.php' );
	}

	/**
	 * @param $action
	 *
	 * @return string
	 */
	protected function create_ajax_url_action( $action ) {
		return add_query_arg( [ 'action' => $action ], $this->ajax_url );
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

	public function front( $action_name, $callback = 'payload_action' ) {
		add_action( 'wp_ajax_' . $action_name, [ $this, $callback]  );
		add_action( 'wp_ajax_nopriv_' . $action_name, [ $this, $callback ] );
	}


	public function admin( $action_name, $callback = 'payload_action' ) {
		add_action( 'wp_ajax_' . $action_name, [$this, $callback] );
	}

	public function payload() {
		$request = $_REQUEST;
		unset( $request['action'] );
		$this->callback( $request );
	}

	public function payload_action() {
		$request = $_REQUEST;
		$this->callback( $request );
		die;
	}

	abstract public function callback( $request );

}