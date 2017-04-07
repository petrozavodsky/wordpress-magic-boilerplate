<?php

namespace WordpressMagicBoilerplate\Utils;

abstract class ActivateShortcode {

	use Assets;
	protected $js = false;
	protected $css = false;

	private $attrs = array();

	public function __construct( $tag, $attrs = false ) {
		if ( $attrs !== false ) {
			$this->attrs = $attrs;
		}

		add_action( 'template_redirect', function () use ( $tag ) {
			add_shortcode( $tag, array( $this, 'wrap' ) );
			$this->assets( $tag );

		} );
	}

	private function assets( $tag ) {
		global $wp_query;
		if ( is_singular() && is_object( $wp_query->post ) && has_shortcode( $wp_query->post->post_content, $tag ) ) {
			if ( $this->js ) {
				$this->addJs( $tag );
			}
			if ( $this->css ) {
				$this->addCss( $tag );
			}
		}
	}

	/**
	 * @param array $attrs
	 * @param string $content
	 * @param string $tag
	 *
	 * @return mixed
	 */
	public function wrap( $attrs, $content, $tag ) {
		$content = $this->attr_checker( $content );
		$tag     = $this->attr_checker( $tag );

		if ( count( $this->attrs ) > 0 ) {
			$attrs = shortcode_atts( $this->attrs, $attrs );
		}

		return $this->base( $attrs, $content, $tag );
	}

	/**
	 * @param string $val
	 *
	 * @return bool|string
	 */
	private function attr_checker( $val ) {
		if ( $val == '' ) {
			return false;
		}

		return $val;
	}

	abstract function base( $attrs, $content, $tag );

}