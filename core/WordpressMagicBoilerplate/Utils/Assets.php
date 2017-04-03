<?php
/**
 * Created by PhpStorm.
 * User: vovasik
 * Date: 31.03.17
 * Time: 22:41
 */

namespace WordpressMagicBoilerplate\Utils;

trait Assets {

	private $file;
	private $css_patch = "public/css/";
	private $js_patch = "public/js/";

	/**
	 * @param string $handle
	 * @param bool $in_footer
	 * @param array $dep
	 * @param bool|string $version
	 * @param bool|string $src
	 *
	 * @return string
	 */
	public function registerJs( $handle, $in_footer = false, $dep = array(), $version = false, $src = false ) {
		if ( ! $src ) {
			$src     = plugin_dir_url( $this->file ) . "{$this->js_patch}{$this->base_name}-{$handle}.js";
			$file_id = $this->base_name . "-" . $handle;
		} else {
			$file_id = $handle;
		}
		if ( ! $version ) {
			$version = $this->version;
		}
		wp_enqueue_script(
			$file_id,
			$src,
			$dep,
			$version,
			$in_footer
		);

		return $file_id;
	}

	/**
	 * @param string $handle
	 * @param string $position
	 * @param array $dep
	 * @param bool|string $version
	 * @param bool|string $src
	 *
	 * @return string
	 */
	public function addJs( $handle, $position = "wp_enqueue_scripts", $dep = array(), $version = false, $src = false ) {
		$in_footer = false;
		if ( $position == "footer" || $position == "body" ) {
			$position  = "wp_footer";
			$in_footer = true;
		} elseif ( $position == "head" || $position == "wp_enqueue_script" || $position == "head" ) {
			$position = "wp_head";
		}

		$handle    = $this->registerJs( $handle, $position, $dep, $version, $src );
		add_action( $position, function () use ( $in_footer, $handle, $src, $dep, $version ) {
			wp_enqueue_script( $handle, $src, $dep, $version, $in_footer );
		} );

		return $handle;
	}

	/**
	 * @param string $handle
	 * @param array $dep
	 * @param bool|string $version
	 * @param bool|string $src
	 * @param string|string $media
	 *
	 * @return string
	 */
	public function registerCss( $handle, $dep = array(), $version = false, $src = false, $media = 'all' ) {
		if ( ! $src ) {
			$src     = plugin_dir_url( $this->file ) . "{$this->css_patch}{$this->base_name}-{$handle}.css";
			$file_id = $this->base_name . "-" . $handle;
		} else {
			$file_id = $handle;
		}
		if ( ! $version ) {
			$version = $this->version;
		}
		wp_register_style(
			$file_id,
			$src,
			$dep,
			$version,
			$media
		);

		return $file_id;
	}

	/**
	 * @param string $handle
	 * @param string $position
	 * @param array $dep
	 * @param bool|string $version
	 * @param bool|string $src
	 * @param string $media
	 *
	 * @return string
	 */
	public function addCss( $handle, $position = "wp_enqueue_scripts", $dep = array(), $version = false, $src = false, $media = 'all' ) {
		if ( $position == "footer" || $position == "body" ) {
			$position = "wp_footer";
		} elseif ( $position == "header" || $position == "wp_enqueue_script" || $position == "head" ) {
			$position = "wp_enqueue_scripts";
		}

		$handle = $this->registerCss( $handle, $dep, $version, $src, $media );
		add_action( $position, function () use ( $media, $handle, $dep, $version, $src ) {
			wp_enqueue_style( $handle );
		} );

		return $handle;
	}
}