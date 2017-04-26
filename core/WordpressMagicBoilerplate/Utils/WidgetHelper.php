<?php

namespace WordpressMagicBoilerplate\Utils;

trait WidgetHelper {

	protected $js = false;
	protected $css = false;


	public function addWidgetAssets() {
		add_action( "wp", function () {
			if ( ! is_active_widget( 0, $this->id, $this->id_base ) === false ) {
				$this->add_js_css($this->id_base);
			}
		} );
	}

	public function add_js_css($base){
		if ( $this->css ) {
			$this->addCss( $base, "header" );
		}
		if ( $this->js ) {
			$this->addJs( $base, "header" );
		}
	}

}