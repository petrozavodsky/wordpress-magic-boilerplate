<?php

namespace WordpressMagicBoilerplate\Classes;

use WordpressMagicBoilerplate\Utils\ActivateShortcode;
use WordpressMagicBoilerplate\Utils\Assets;

class Shortcode extends ActivateShortcode {

	use Assets;
	
	// свойство подключает файл стилей
	public $css = true;

	// аргуметы метода получат массив атрибутов шорткода,
	// имя шорткода и контент если он есть.
	// Метод всегда должен возвращать строку.
	public function base( $attrs, $content, $tag ) {

		$res  = "";
		$res  .= "<strong>{$attrs['title']}</strong>";
		$res  .= "<p>{$attrs['description']}</p>";

		return $res;
	}
	
	// тут можно реализовать логику работы шорткода 

}
