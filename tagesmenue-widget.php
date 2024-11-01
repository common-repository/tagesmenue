<?php
/**
 * Plugin Name: Tagesmenue Widget
 * Plugin URI: http://www.tagesmenue.ch
 * Description: Tagesmenue Widget
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
 class Tagesmenue_Widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'tagesmenue_widget',
			__( 'Tagesmenue', 'text_domain' ),
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
		echo '<div id="tagesmenue2" class="tagesmenue '.$instance['tagesmenue_design'].'"><span id="TAGESMENUElogo">[Tagesmenue Full]</span></div>';
		echo $args['after_widget'];
	}
	public function form( $instance ) {
		?>
		<p>	
			<select name="<?php echo $this->get_field_name( 'tagesmenue_design' ); ?>" id="<?php echo $this->get_field_name( 'tagesmenue_design' ); ?>">
				<option <?php if ($instance['tagesmenue_design'] == 'tagesmenue-left2x') echo ' selected ' ?> value="tagesmenue-left2x">Left 2x</option>
				<option <?php if ($instance['tagesmenue_design'] == 'tagesmenue-centered2x') echo ' selected ' ?> value="tagesmenue-centered2x">Centered 2x</option>
				<option <?php if ($instance['tagesmenue_design'] == 'tagesmenue-left') echo ' selected ' ?> value="tagesmenue-left">Left</option>
				<option <?php if ($instance['tagesmenue_design'] == 'tagesmenue-centered') echo ' selected ' ?> value="tagesmenue-centered">Centered</option>
			</select>
		</p>
		<?php
	}	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance = $old_instance;
		$instance['tagesmenue_design'] = ( ! empty( $new_instance['tagesmenue_design'] ) ) ? strip_tags( $new_instance['tagesmenue_design'] ) : '';
		return $instance;
	}
	
	
}

function register_tagesmenue_widget() {
    register_widget( 'Tagesmenue_Widget' );
}
add_action( 'widgets_init', 'register_tagesmenue_widget' );