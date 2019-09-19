<?php

namespace WordpressMagicBoilerplate\Utils;

class ActivateWidgets {

	use Assets;

	private $version = '1.0.3';
	private $space = false;
	private $file;
	private $cssPatch = "public/css/";
	private $jsPatch = "public/js/";
	private $path;
	public $baseName;

	public function __construct( $file, $dir, $space ) {
		$this->file  = $file;
		$this->space = $space;
		$this->path        = plugin_dir_path( $this->file );
		$this->baseName = $this->space;

		$this->activateWidgets( $dir );
	}

	/**
	 * @param resource $dir
	 * @param bool $space
	 */
	public function activateWidgets( $dir, $space = false ) {
		$s = DIRECTORY_SEPARATOR;
		if ( ! $space ) {
			$space = $this->space;
		}

		$dir = realpath( plugin_dir_path( $this->file ) ) . "{$s}src{$s}{$space}{$s}{$dir}";
		if ( $dir != false && file_exists( $dir ) ) {
			$dir = opendir( $dir );
			while ( ( $currentFile = readdir( $dir ) ) !== false ) {
				if ( $currentFile == '.' or $currentFile == '..' ) {
					continue;
				}
				$widget_name = basename( $currentFile, ".php" );
				add_action( 'widgets_init', function () use ( $space, $widget_name ) {
					register_widget( $class_name = "\\{$space}\\Widgets\\{$widget_name}" );
					$this->addWidgetJsCss( $widget_name, $space );
				} );
			}
			closedir( $dir );
		}
	}

	/**
	 * @param string $widget_name
	 * @param mixed $space
	 */
	public function addWidgetJsCss( $widget_name, $space = false ) {

		if ( $this->path . $this->cssPatch .  $widget_name . ".css" ) {
			$this->addCss( $widget_name, "footer" );
		}
	}

	/**
	 * @param mixed $space
	 */
	public function setSpace( $space ) {
		$this->space = $space;
	}

	/**
	 * @param mixed $file
	 *
	 * @return ActivateWidgets
	 */
	public function setFile( $file ) {
		$this->file = $file;

		return $this;
	}

	/**
	 * @param string $cssPatch
	 *
	 * @return ActivateWidgets
	 */
	public function setCssPatch( $cssPatch ) {
		$this->cssPatch = $cssPatch;

		return $this;
	}

	/**
	 * @param string $jsPatch
	 *
	 * @return ActivateWidgets
	 */
	public function setJsPatch( $jsPatch ) {
		$this->jsPatch = $jsPatch;

		return $this;
	}

	/**
	 * @param mixed $path
	 *
	 * @return ActivateWidgets
	 */
	public function setPath( $path ) {
		$this->path = $path;

		return $this;
	}

	/**
	 * @param string $version
	 *
	 * @return ActivateWidgets
	 */
	public function setVersion( $version ) {
		$this->version = $version;

		return $this;
	}

}
