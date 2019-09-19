<?php

namespace WordpressMagicBoilerplate\Classes;

use WordpressMagicBoilerplate\Utils\Assets;

class MyClass {

	use Assets;
	private $state;
	private $post_type = 'post';
	private $baseName;

	/**
	 *
	 * @param object $state
	 */
	public function __construct( $state ) {
		$this->state     = $state;
		$this->baseName = $state->baseName;
		add_action( "get_header", [ $this, "router" ] );

	}

	public function router() {

		//Add css in footer
		$this->addCss(
			'MyClassStyle',
			'footer'
		);

		//Add custom url css
		$this->addCss(
			"Common-style",
			"header",
			[],
			$this->state->version,
			$this->state->pluginUrl . $this->state->cssPatch . "Common-style.css"
		);

		//page type rout
		if ( is_singular( $this->post_type ) ) {

			//Add auto url css
			$this->addCss(
				"Single-style",
				"footer"
			);

			//Add auto url js
			$this->addJs(
				"Single-script",
				"footer",
				[ "jquery" ],
				"1.0.3"
			);
		}
	}

}
