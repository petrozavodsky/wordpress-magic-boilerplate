<?php

namespace WordpressMagicBoilerplate\Classes;

use WordpressMagicBoilerplate\Utils\Ajax;
use WordpressMagicBoilerplate\Utils\Assets;

class AjaxOut2 extends Ajax {

	use Assets;

	/**
	 * AjaxOut2 constructor.
	 */
	public function __construct() {
		$name = "AjaxOut2";

		parent::__construct( $name );
		$this->addJsCss( $name );

	}

	/**
	 * @param $name
	 */
	private function addJsCss($name ) {

		$handle = $this->addJs(
			$name,
			'header',
			[ 'jquery' ]
		);

		$this->varsAjax(
			$handle,
			[
				'ajaxUrl'        => $this->ajaxUrl,
				'ajaxUrlAction' => $this->ajaxUrlAction,
			]
		);
	}

	/**
	 * @param string $request
	 */
	public function callback( $request ) {
		unset( $request['action'] );

		$json = [ "out" => "AJAX Content" ];
		wp_send_json( $json );
	}
}
