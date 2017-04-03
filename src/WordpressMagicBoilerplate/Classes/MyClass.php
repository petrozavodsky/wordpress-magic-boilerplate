<?php

namespace WordpressMagicBoilerplate\Classes {

	use WordpressMagicBoilerplate\Utils\Assets;

	class MyClass {
		use Assets;
		private $post_type = 'post';
		public $state;
		private $base_name;
		private $file;

		/**
		 * Card constructor.
		 *
		 * @param object $state
		 */
		function __construct( $state ) {
			$this->state     = $state;
			$this->base_name = $state->base_name;
			$this->file      = $state->file;

			add_action( "get_header", array( $this, "router" ) );
			$this->addCss( 'MyClassStyle', 'wp_footer' );
		}

		public function router() {
			if ( is_singular( $this->post_type ) ) {
				$this->state->addCss( "Single-style", "footer" );
				$this->state->addJs( "Single-script", "footer", array( "jquery" ), "1.0.0" );
			}
		}
	}


}