<?php

namespace WordpressMagicBoilerplate\Classes;

use WordpressMagicBoilerplate\Utils\Ajax;

class AjaxOut2 extends Ajax {

    public $js = true;

	/**
	 * AjaxOut2 constructor.
	 */
	public function __construct() {
		$name = 'AjaxOut2';
		parent::__construct( $name );
	}

	/**
	 * @param string $request
	 */
	public function callback( $request ) {
		unset( $request['action'] );
		$json = [ "out" => "AJAX Content 2" ];
		wp_send_json( $json );
	}
}
