<?php

namespace WordpressMagicBoilerplate;

/**
 * An WordpressMagicBoilerplate of a general-purpose implementation that includes the optional
 * functionality of allowing multiple base directories for a single namespace
 * prefix.
 *
 */
class Autoload {
	/**
	 * An associative array where the key is a namespace prefix and the value
	 * is an array of base directories for classes in that namespace.
	 *
	 * @var array
	 */
	protected $prefixes = [];

	/**
	 * Register loader with SPL autoloader stack.
	 *
	 * @return void
	 */
	public function register() {
		spl_autoload_register( [ $this, 'loadClass' ] );
	}

	/**
	 * Adds a base directory for a namespace prefix.
	 *
	 * @param string $prefix The namespace prefix.
	 * @param string $baseDir A base directory for class files in the
	 * namespace.
	 * @param bool $prepend If true, prepend the base directory to the stack
	 * instead of appending it; this causes it to be searched first rather
	 * than last.
	 *
	 * @return void
	 */
	public function addNamespace($prefix, $baseDir, $prepend = false ) {

		$prefix = trim( $prefix, '\\' ) . '\\';

		$baseDir = rtrim( $baseDir, DIRECTORY_SEPARATOR ) . '/';

		if ( isset( $this->prefixes[ $prefix ] ) === false ) {
			$this->prefixes[ $prefix ] = [];
		}

		if ( $prepend ) {
			array_unshift( $this->prefixes[ $prefix ], $baseDir );
		} else {
			array_push( $this->prefixes[ $prefix ], $baseDir );
		}
	}

	/**
	 * Loads the class file for a given class name.
	 *
	 * @param string $class The fully-qualified class name.
	 *
	 * @return mixed The mapped file name on success, or boolean false on
	 * failure.
	 */
	public function loadClass( $class ) {
		$prefix = $class;

		while ( false !== $pos = strrpos( $prefix, '\\' ) ) {

			$prefix = substr( $class, 0, $pos + 1 );

			$relativeClass = substr( $class, $pos + 1 );

			$mapped_file = $this->loadMappedFile( $prefix, $relativeClass );
			if ( $mapped_file ) {
				return $mapped_file;
			}
			$prefix = rtrim( $prefix, '\\' );
		}

		return false;
	}

	/**
	 * Load the mapped file for a namespace prefix and relative class.
	 *
	 * @param string $prefix The namespace prefix.
	 * @param string $relative_class The relative class name.
	 *
	 * @return mixed Boolean false if no mapped file can be loaded, or the
	 * name of the mapped file that was loaded.
	 */
	protected function loadMappedFile( $prefix, $relative_class ) {
		if ( isset( $this->prefixes[ $prefix ] ) === false ) {
			return false;
		}

		foreach ( $this->prefixes[ $prefix ] as $baseDir ) {
			$file = $baseDir . str_replace( '\\', '/', $relative_class ) . '.php';
			if ( $this->requireFile( $file ) ) {
				// yes, we're done
				return $file;
			}
		}

		return false;
	}

	/**
	 * If a file exists, require it from the file system.
	 *
	 * @param string $file The file to require.
	 *
	 * @return bool True if the file exists, false if not.
	 */
	protected function requireFile( $file ) {
		if ( file_exists( $file ) ) {
			require $file;

			return true;
		}

		return false;
	}
}
