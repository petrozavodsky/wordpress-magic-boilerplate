<?php

namespace WordpressMagicBoilerplate\Widgets {

	use WP_Widget;

	class MagicWidget extends WP_Widget {
		private $textdomain = __NAMESPACE__;
		private $suffix = " - MagicWidget";

		function __construct() {
			$className = get_called_class();
			$className = str_replace( "\\", '-', $className );
			parent::__construct(
				$className,
				__( "My widget {$this->suffix}", $this->textdomain ),
				array(
					'description' => __( "My widget {$this->suffix}", $this->textdomain )
				)
			);
		}

		public function widget( $args, $instance ) {

			echo $args['before_widget'];
			?>
            <div>
                <h1>Magic</h1>
            </div>

			<?php
			echo $args['after_widget'];
		}


		public function form( $instance ) {

		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();

			return $instance;
		}


	}
}