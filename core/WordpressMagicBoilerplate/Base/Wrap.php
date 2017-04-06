<?php

namespace WordpressMagicBoilerplate\Base;
class Wrap {
	private $space;
	public $version = '1.0.0';
	public $prefix;
	public $base_name;
	public $file;
	public $css_patch = "public/css/";
	public $js_patch = "public/js/";
	public $path;
	public $url;

	function init( $file, $className ) {
		$this->file      = $file;
		$this->space     = $className;
		$this->prefix    = "_{$this->space}";
		$this->base_name = $this->space;
		$this->addState( $this->file );
	}

	/**
	 * @param $file resource
	 *
	 * @return void
	 */
	private function addState( $file ) {
		$this->path = plugin_dir_path( $file );
		$this->url  = plugin_dir_url( $file );
	}


	/**
	 * @param string $val
	 *
	 * @return $this
	 */
	public function setSpace( $val ) {
		$this->space = $val;

		return $this;
	}

	/**
	 * @param string $val
	 *
	 * @return $this
	 */
	public function setVersion( $val ) {
		$this->version = $val;

		return $this;
	}

}