<?php
/**
 * Plugin Name: Tagesmenue Katalog widget
 * Plugin URI: http://www.tagesmenue.ch
 * Description: Tagesmenue Katalog widget
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
define( 'TAGESMENUE_KATALOG_WIDGET_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );

 class Tagesmenue_Katalog_Widget extends WP_Widget {
	 
	function __construct() {
		parent::__construct(
			'tagesmenue_katalog_widget',
			__( 'Tagesmenue Katalog', 'text_domain' ),
			array( 'description' => __( 'Tagesmenue', 'text_domain' ), )
		);
	}

	public function widget( $args, $instance ) {
		global $TAGESMENUE_options;	
		$TAGESMENUE_key = $TAGESMENUE_options['tagesmenue_key'];
		echo $args['before_widget'];
		echo '<a id="kp'.$instance['thekatalog'].'" href="'.$TAGESMENUE_key.'" style="text-decoration: none;" >';
		echo '<img src="';
		
		if (!empty($instance['tagesmenue_image_url'])) {
			echo $instance['tagesmenue_image_url'].'" 
				alt="'.$instance['tagesmenue_alt_text'].'" 
				title="'.$instance['tagesmenue_alt_text'].'" ';
			echo 'style="'.(!empty($instance['tagesmenue_image_width'])?'width:'.$instance['tagesmenue_image_width'].'px; ':'').
				//		(!empty($instance['tagesmenue_image_height'])?'height:'.$instance['tagesmenue_image_height'].'px; ':'').
					' height: auto;" >';
		} else {
			if ($instance['thekatalog']==1) echo TAGESMENUE_URL.'/images/speisekarte.png" ';
			else if ($instance['thekatalog']==2) echo TAGESMENUE_URL.'/images/weinkarte.png" ';
			else if ($instance['thekatalog']==3) echo TAGESMENUE_URL.'/images/dessertkarte.png" ';
			else echo TAGESMENUE_URL.'/images/kp_logo.png" ';

			echo 'style="'.(!empty($instance['tagesmenue_image_width'])?'width:'.$instance['tagesmenue_image_width'].'px; ':'250px;').
			//		(!empty($instance['tagesmenue_image_height'])?'height:'.$instance['tagesmenue_image_height'].'px; ':'').
				' height: auto;" >';
		}
		
		echo '<h5>'.$instance['thekatalogname'].'</h5>';
		echo '</a>';

		echo $args['after_widget'];
	}
	public function form( $instance ) {
		?>
		<p>	
			<select name="<?php echo $this->get_field_name( 'thekatalog' ); ?>" id="<?php echo $this->get_field_id( 'thekatalog' ); ?>">
<?php 			for ($k=1; $k<=10; $k++) { ?>				
					<option <?php if ($instance['thekatalog'] == $k) echo ' selected ' ?>  value="<?php echo $k; ?>">Katalog <?php echo $k; ?></option>
<?php 			} ?>
			</select>
		</p>
		<p>
		<input name="<?php echo $this->get_field_name( 'thekatalogname' ); ?>" id="<?php echo $this->get_field_id( 'thekatalogname' ); ?>" type="text" value="<?php echo $instance['thekatalogname']; ?>" >
		</p>
		<?php
		
//////////		
		// Defaults.
		$instance = wp_parse_args( (array) $instance, array(
			'tagesmenue_image_url'               => '',
			'tagesmenue_image_width'             => '',
//			'tagesmenue_image_height'            => '',
			'tagesmenue_alt_text'                => '',
			) );
		?>

	    <div>
		      <label for="<?php echo esc_attr( $this->get_field_id( 'tagesmenue_image_url' ) ); ?>"><?php _e( 'Image URL', 'tagesmenue_katalog_widget' ); ?></label>:<br />
		      <input type="text" class="img widefat" name="<?php echo esc_attr( $this->get_field_name( 'tagesmenue_image_url' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'tagesmenue_image_url' ) ); ?>" value="<?php echo esc_url( $instance['tagesmenue_image_url'] ); ?>" /><br />
		      <input type="button" class="select-imgTMW button button-primary" value="<?php _e( 'Upload', 'tagesmenue_katalog_widget' ); ?>" data-uploader_title="<?php _e( 'Select Image', 'tagesmenue_katalog_widget' ); ?>" data-uploader_button_text="<?php _e( 'Choose Image', 'tagesmenue_katalog_widget' ); ?>" style="margin-top:5px;" />

				<?php
		        $full_image_url = '';
		        if ( ! empty( $instance['tagesmenue_image_url'] ) ) {
					$full_image_url = $instance['tagesmenue_image_url'];
		        }
		        $wrap_style = '';
		        if ( empty( $full_image_url ) ) {
					$wrap_style = ' style="display:none;" ';
		        }
				?>
		      <div class="tagesmenue-preview-wrap" <?php echo $wrap_style; ?>>
		        <img src="<?php echo esc_url( $full_image_url ); ?>" alt="<?php _e( 'Preview', 'tagesmenue_katalog_widget' ); ?>" style="max-width: 100%;"  />
		      </div><!-- .tagesmenue-preview-wrap -->

	    </div>

	    <p>
	      <label for="<?php echo esc_attr( $this->get_field_id( 'tagesmenue_image_width' ) ); ?>"><?php _e( 'Image Width', 'tagesmenue_katalog_widget' ); ?>:</label>
	        <input id="<?php echo esc_attr( $this->get_field_id( 'tagesmenue_image_width' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'tagesmenue_image_width' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['tagesmenue_image_width'] ); ?>" style="max-width:60px;"/>&nbsp;<em class="small"><?php _e( 'in pixel', 'tagesmenue_katalog_widget' ); ?></em>
	    </p>

<!--	    <p>
	      <label for="<?php echo esc_attr( $this->get_field_id( 'tagesmenue_image_height' ) ); ?>"><?php _e( 'Image Height', 'tagesmenue_katalog_widget' ); ?>:</label>
	        <input id="<?php echo esc_attr( $this->get_field_id( 'tagesmenue_image_height' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'tagesmenue_image_height' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['tagesmenue_image_height'] ); ?>" style="max-width:60px;"/>&nbsp;<em class="small"><?php _e( 'in pixel', 'tagesmenue_katalog_widget' ); ?></em>
	    </p>-->

	    <p>
	      <label for="<?php echo esc_attr( $this->get_field_id( 'tagesmenue_alt_text' ) ); ?>"><?php _e( 'Alt Text', 'tagesmenue_katalog_widget' ); ?>:</label>
	        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tagesmenue_alt_text' ) ); ?>"
	        name="<?php echo esc_attr( $this->get_field_name( 'tagesmenue_alt_text' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['tagesmenue_alt_text'] ); ?>" />
	    </p>
		
		<?php
	}	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance = $old_instance;

		$instance['thekatalog'] = ( ! empty( $new_instance['thekatalog'] ) ) ? strip_tags( $new_instance['thekatalog'] ) : '';
		$instance['thekatalogname'] = ( ! empty( $new_instance['thekatalogname'] ) ) ? strip_tags( $new_instance['thekatalogname'] ) : '';

		$instance['tagesmenue_image_url']               = esc_url_raw( $new_instance['tagesmenue_image_url'] );
		$instance['tagesmenue_image_width']             = esc_attr( $new_instance['tagesmenue_image_width'] );
//		$instance['tagesmenue_image_height']            = esc_attr( $new_instance['tagesmenue_image_height'] );
		$instance['tagesmenue_alt_text']                = sanitize_text_field( $new_instance['tagesmenue_alt_text'] );
		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['tagesmenue_image_caption'] = $new_instance['tagesmenue_image_caption'];
		} else {
			$instance['tagesmenue_image_caption'] = wp_kses_post( $new_instance['tagesmenue_image_caption'] );
		}
		return $instance;
	}
}
function tagesmenue_katalog_widget_scripts( $hook ) {
	wp_enqueue_style( 'tagesmenue-katalog-widget-admin', TAGESMENUE_KATALOG_WIDGET_URL . '/css/admin.css', array(), '1.4.0' );
	wp_enqueue_media();
	wp_enqueue_script( 'tagesmenue-katalog-widget-admin', TAGESMENUE_KATALOG_WIDGET_URL . '/js/adminTMW.js', array( 'jquery' ), '1.4.0' );
}
add_action( 'admin_enqueue_scripts', 'tagesmenue_katalog_widget_scripts' );



function register_tagesmenue_katalog_widget() {
    register_widget( 'Tagesmenue_Katalog_Widget' );
}
add_action( 'widgets_init', 'register_tagesmenue_katalog_widget' );