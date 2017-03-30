<?php

namespace WordpressMagicBoilerplate {

	abstract class Wrap {
		private $space;
		public $version = '1.0.0';
		public $prefix;
		public $base_name;
		private $loader;
		private $file;
		public $css_patch = "public/css/";
		public $js_patch = "public/js/";

		function init( $file, $className ) {
			$this->file      = $file;
			$this->space     = $className;
			$this->prefix    = "_{$this->space}";
			$this->base_name = $this->space;
			$this->autoload();
			$this->addNamespaceObject( "Widgets" );
			$this->addNamespaceObject( "Classes" );
			$this->activateWidgets( "Widgets" );
		}

		/**
		 * @param string $val
		 *
		 * @return $this
		 */
		public function setSpace( $val ) {
			//Exception
			$this->space = $val;

			return $this;
		}

		/**
		 * @param string $val
		 *
		 * @return $this
		 */
		public function setVersion( $val ) {
			//Exception
			$this->version = $val;

			return $this;
		}

		/**
		 * @param string $dir
		 * @param mixed $space
		 */
		function addNamespaceObject( $dir, $space = false ) {
			$s = DIRECTORY_SEPARATOR;
			if ( ! $space ) {
				$space = $this->space;
			}
			$this->loader->addNamespace(
				$space . "\\{$dir}",
				realpath( plugin_dir_path( $this->file ) ) . "{$s}src{$s}{$space}{$s}{$dir}"
			);
		}

		/**
		 * @param string $dir
		 * @param bool $space
		 */
		public function activateWidgets( $dir, $space = false ) {
			$s = DIRECTORY_SEPARATOR;
			if ( ! $space ) {
				$space = $this->space;
			}
			$dir = realpath( plugin_dir_path( $this->file ) ) . "{$s}src{$s}{$space}{$s}{$dir}";

			if ( file_exists( $dir ) ) {
				$dir = opendir( $dir );
				while ( ( $currentFile = readdir( $dir ) ) !== false ) {
					if ( $currentFile == '.' or $currentFile == '..' ) {
						continue;
					}

					$widget_name = basename( $currentFile, ".php" );
					add_action( 'widgets_init', function () use ( $widget_name ) {
						$space = __NAMESPACE__;
						register_widget( $class_name = "\\{$space}\\Widgets\\{$widget_name}" );
						$this->addWidgetJsCss( $widget_name );
					} );
				}
				closedir( $dir );
			}
		}

		public function addWidgetJsCss( $widget_name ) {
			if ( $this->path . $this->css_patch . $widget_name . ".css" ) {
				$this->addCss( $widget_name, "footer" );
			}
		}

		function autoload() {
			require_once( 'Autoload.php' );
			$this->loader = new Autoload();
			$this->loader->register();
		}

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
			$handle    = $this->registerJs( $handle, $position, $dep, $version, $src );
			$in_footer = false;

			if ( $position == "footer" || $position == "body" ) {
				$position  = "wp_footer";
				$in_footer = true;
			} elseif ( $position == "head" || $position == "wp_enqueue_script" || $position == "head" ) {
				$position = "wp_head";
			}

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

			add_action( $position, function () use ( $media, $handle, $dep, $version, $src ) {
				$handle = $this->registerCss( $handle, $dep, $version, $src, $media );
				wp_enqueue_style( $handle );
			} );

			return $handle;
		}
	}
}