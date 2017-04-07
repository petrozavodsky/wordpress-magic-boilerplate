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
		$this->init( __FILE__, get_called_class() );
		new \WordpressMagicBoilerplate\Classes\MyClass( $this );
		new \WordpressMagicBoilerplate\Utils\ActivateWidgets(
			__FILE__,
			'Widgets',
			'WordpressMagicBoilerplate'
		);
	}


}


function WordpressMagicBoilerplat__init() {
	new WordpressMagicBoilerplate();
}

add_action( 'plugins_loaded', 'WordpressMagicBoilerplat__init', 30 );
