<?php

namespace WordpressMagicBoilerplate\Classes {

	class MyClass {

		private $post_type = 'post';
		public $state;

		/**
		 * Card constructor.
		 *
		 * @param object $state
		 */
		function __construct( $state ) {
			$this->state = $state;
			add_action( "get_header", array( $this, "router" ) );
		}

		public function router() {
			if ( is_singular( $this->post_type ) ) {
				$this->state->addCss( "Single-style", "footer" );
				$this->state->addJs( "Single-script", "footer", array( "jquery" ), "1.0.0" );
			}
		}
	}


}