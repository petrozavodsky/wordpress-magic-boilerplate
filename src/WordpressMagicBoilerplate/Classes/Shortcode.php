<?php

namespace WordpressMagicBoilerplate\Classes;

use WordpressMagicBoilerplate\Utils\ActivateShortcode;
use WordpressMagicBoilerplate\Utils\Assets;

class Shortcode extends ActivateShortcode {

	use Assets;

	public $css = true;

	public function base( $attrs, $content, $tag ) {

		$res  = "";
		$res  .= "<strong>{$attrs['title']}</strong>";
		$res  .= "<p>{$attrs['description']}</p>";

		return $res;
	}

}
