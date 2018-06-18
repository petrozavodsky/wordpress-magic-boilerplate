<?php
/*
Plugin Name: Wordpress Magic Boilerplate plugin
Plugin URI: http://alkoweb.ru
Author: Petrozavodsky
Author URI: http://alkoweb.ru
Text Domain: WordpressMagicBoilerplate
Domain Path: /languages
Requires PHP: 7.0
Version: 1.0.0-rc.3
License: GPLv3
*/
	
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( plugin_dir_path( __FILE__ )."includes/Autoloader.php" );

use WordpressMagicBoilerplate\Autoloader;

new Autoloader( __FILE__, 'WordpressMagicBoilerplate' );


use WordpressMagicBoilerplate\Base\Wrap;

class WordpressMagicBoilerplate extends Wrap {
	public $version = '1.0.0';
	public static $textdomine;

	function __construct() {
		self::$textdomine = $this->setTextdomain();

		new \WordpressMagicBoilerplate\Classes\AjaxOut2();
		new \WordpressMagicBoilerplate\Classes\AjaxOut( 'boilerplate-ajax' );
		new \WordpressMagicBoilerplate\Classes\MyClass( $this );
		new \WordpressMagicBoilerplate\Utils\ActivateWidgets(
			__FILE__,
			'Widgets',
			'WordpressMagicBoilerplate'
		);
		new \WordpressMagicBoilerplate\Classes\Shortcode(
			'boilerplate_shortcode',
			[
				'title'       => 'Boilerplate title',
				'description' => 'Boilerplate description'
			]
		);

	}

}

function WordpressMagicBoilerplate__init() {
	new WordpressMagicBoilerplate();
}

add_action( 'plugins_loaded', 'WordpressMagicBoilerplate__init', 30 );
