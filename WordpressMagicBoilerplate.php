<?php

/*
Plugin Name: Wordpress Magic Boilerplate plugin
Plugin URI: http://alkoweb.ru
Author: Petrozavodsky
Author URI: http://alkoweb.ru
*/

require_once( "includes/Autoloader.php" );
use WordpressMagicBoilerplate\Autoloader;

new Autoloader( __FILE__, 'WordpressMagicBoilerplate' );


use WordpressMagicBoilerplate\Base\Wrap;

class WordpressMagicBoilerplate extends Wrap {
	public $version = '1.0.0-rc.3';

	function __construct() {

		new \WordpressMagicBoilerplate\Classes\MyClass( $this );
		new \WordpressMagicBoilerplate\Utils\ActivateWidgets(
			__FILE__,
			'Widgets',
			'WordpressMagicBoilerplate'
		);

		d(
			$this,
			$this->url,
			$this->file,
			$this->base_name,
			$this->space,
			$this->prefix
		);

	}


}


function WordpressMagicBoilerplate__init() {
	new WordpressMagicBoilerplate();
}

add_action( 'plugins_loaded', 'WordpressMagicBoilerplate__init', 30 );
