<?php

namespace WordpressMagicBoilerplate\Classes {

	use WordpressMagicBoilerplate\Utils\Assets;

	class MyClass {
		use Assets;
		private $state;
		private $post_type = 'post';
		private $base_name;

		/**
		 *
		 * @param object $state
		 */
		function __construct( $state ) {
			$this->state     = $state;
			$this->base_name = $state->base_name;
			add_action( "get_header", array( $this, "router" ) );
			$this->addCss( 'MyClassStyle', 'footer' );
		}

		public function router() {
			if ( is_singular( $this->post_type ) ) {
				$this->addCss( "Single-style", "footer" );
				$this->addJs( "Single-script", "footer", array( "jquery" ), "1.0.0" );
			}
		}
	}


}