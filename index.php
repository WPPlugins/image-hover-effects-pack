<?php 

	/*
	Plugin Name: Image Hover Effects Pack
	Description: Add 200+ hover effects to images with captions.Really simple to use and light.
	Plugin URI: http://webdevocean.com/
	Author: Labib Ahmed
	Author URI: http://webdevocean.com/
	Version: 1.0
	Text Domain: la-hover-advance
	*/
	
	/*
	
	    Copyright (C) 2016  Labib Ahmed  webdevocean@gmail.com
	   
	*/

	 include_once ('plugin.class.php');
	if (class_exists('LA_Hover_Pack')) {
		$object = new LA_Hover_Pack;
	}
	
 ?>