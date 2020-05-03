<?php

namespace WordpressMagicBoilerplate\Classes;

use WordpressMagicBoilerplate\Utils\ActivateShortcode;
use WordpressMagicBoilerplate\Utils\Assets;

class Shortcode extends ActivateShortcode {

	use Assets;

	protected $js = false;
	protected $css = true;

	public function init( $tag, $attrs ) {
		add_action( "template_redirect", function () use ( $tag ) {
			global $wp_query;
			if ( is_singular() && has_shortcode( $wp_query->post->post_content, $tag ) ) {
				$this->addCss($tag);
			}
		} );
	}

	public function base( $attrs, $content, $tag ) {

		$res  = "";
		$res  .= "<strong>{$attrs['title']}</strong>";
                $res  .= "<p>{$attrs['description']}</p>";

		return $res;
	}

}
