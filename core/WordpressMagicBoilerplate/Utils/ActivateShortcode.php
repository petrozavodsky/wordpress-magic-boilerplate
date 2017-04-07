<?php

namespace WordpressMagicBoilerplate\Utils;

abstract class ActivateShortcode {

	private $attrs = array();

	/**
	 * ActivateShortcode constructor.
	 *
	 * @param string $tag
	 * @param array|bool $attrs
	 */
	public function __construct( $tag, $attrs = false ) {
		if ( $attrs !== false ) {
			$this->attrs = $attrs;
		}
		add_shortcode( $tag, array( $this, 'wrap' ) );
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

		if(count($this->attrs) > 0){
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