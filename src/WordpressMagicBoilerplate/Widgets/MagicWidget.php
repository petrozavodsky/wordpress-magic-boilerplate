<?php

namespace WordpressMagicBoilerplate\Widgets;

use WordpressMagicBoilerplate;
use WP_Widget;

class MagicWidget extends WP_Widget {
	private $textdomain = __NAMESPACE__;
	private $suffix = " - MagicWidget";

	function __construct() {
		$this->textdomain = WordpressMagicBoilerplate::$textdomine;
		$className        = get_called_class();
		$className        = str_replace( "\\", '-', $className );
		parent::__construct(
			$className,
			__( "My widget ", $this->textdomain ) . $this->suffix,
			[
				'description' => __( "My widget", $this->textdomain ) . $this->suffix
			]
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
		echo '<p class="no-options-widget">' . __( 'There are no options for this widget.', $this->textdomain ) . '</p>';

		return 'noform';
	}

	public function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

}