<?php
/**
 * Plugin Name: Tagesmenue button widget
 * Plugin URI: http://www.tagesmenue.ch
 * Description: Tagesmenue button widget
 * Version: 1.0.0
 * Author: Mehdi Rouh
 * Author URI: http://www.tagesmenue.ch
 * Text Domain: TAGESMENUE
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation;
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
 */
 class Tagesmenue_Button_Widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'tagesmenue_button_widget',
			__( 'Tagesmenue Button', 'text_domain' ),
			array( 'description' => __( 'Tagesmenue', 'text_domain' ), )
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		$tag[0] = "Sonntag";
		$tag[1] = "Montag";
		$tag[2] = "Dienstag";
		$tag[3] = "Mittwoch";
		$tag[4] = "Donnerstag";
		$tag[5] = "Freitag";
		$tag[6] = "Samstag";
		$tagnummer = date("w");
		$theday = $tag[$tagnummer];
		echo '<div id="tagesmenuebo2" class="tagesmenuebo"><span id="TAGESMENUElogo">[Tagesmenue PDF Button]</span></div>';
		echo $args['after_widget'];
	}
}

function register_tagesmenue_button_widget() {
    register_widget( 'Tagesmenue_Button_Widget' );
}
add_action( 'widgets_init', 'register_tagesmenue_button_widget' );