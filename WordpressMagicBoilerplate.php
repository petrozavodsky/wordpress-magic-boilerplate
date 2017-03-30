<?php

/*
Plugin Name: Wordpress Magic Boilerplate Plugin
Plugin URI: http://alkoweb.ru
Author: Petrozavodsky
Author URI: http://alkoweb.ru
*/

require_once( "includes/Wrap.php" );


use WordpressMagicBoilerplate\Wrap;

class WordpressMagicBoilerplate extends Wrap {
	public $version = '1.0.0-rc.';
	public $path;
	public $url;

	function __construct() {
		$this->addState();

		$this->init( __FILE__, get_called_class() );
	}

	private function addState() {
		$this->path = plugin_dir_path( __FILE__ );
		$this->url  = plugin_dir_url( __FILE__ );
	}


}

function wordpress_magic_boilerplate__init() {
	new WordpressMagicBoilerplate();
}

add_action( 'plugins_loaded', 'wordpress_magic_boilerplate__init', 30 );

