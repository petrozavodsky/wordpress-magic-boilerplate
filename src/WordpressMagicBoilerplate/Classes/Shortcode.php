<?php

namespace WordpressMagicBoilerplate\Classes;

use WordpressMagicBoilerplate\Utils\ActivateShortcode;
use WordpressMagicBoilerplate\Utils\Assets;

class Shortcode extends ActivateShortcode {
	use Assets;

	protected $js = false;
	protected $css = true;

	function init( $tag, $attrs ) {
		add_action( "template_redirect", function () use ( $tag ) {
			global $wp_query;
			if ( is_singular() && has_shortcode( $wp_query->post->post_content, $tag ) ) {
				$this->addCss($tag);
			}
		} );
	}

	function base( $attrs, $content, $tag ) {
		$json = json_encode( $attrs );
		$res  = "";
		$res  .= "<pre>{$json}</pre>";

		return $res;
	}

}