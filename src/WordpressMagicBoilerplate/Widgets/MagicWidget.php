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
			echo '<p class="no-options-widget">' . __('There are no options for this widget.') . '</p>';
			return 'noform';
		}

		public function update( $new_instance, $old_instance ) {
			return $new_instance;
		}

	}
}