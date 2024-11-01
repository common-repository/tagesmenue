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
class TAGESMENUE_Admin {
	function TAGESMENUE_Admin() {
		global $pagenow;
		
		add_action( 'admin_menu', array( &$this, 'addPluginMenu' ) );
		add_action( 'admin_init', array( &$this, 'init' ) );
		// Add the tinyMCE button
		add_action( 'admin_init', array( &$this, 'TAGESMENUEaddButtons' ) );
		add_action( 'wp_ajax_TAGESMENUE_shortcodePrinter', array( &$this, 'tagesmenue_popup_shortcode' ) );
	}

	function init() {
		wp_enqueue_script( 'jquery' );
	}

	function addPluginMenu() {
		add_options_page( __('Options for Tagesmenue', 'TAGESMENUE'), __('Tagesmenue', 'TAGESMENUE'), 'manage_options', 'TAGESMENUE-options', array( &$this, 'displayOptions' ) );
	}

	function displayOptions() {
		global $TAGESMENUE_options;
		if ( isset($_POST['save']) ) {
			check_admin_referer( 'TAGESMENUE-update-options' );
			$new_options = array();

			// Update existing
			foreach( (array) $_POST['TAGESMENUE'] as $key => $value ) {
				$new_options[$key] = stripslashes($value);
			}

			update_option( 'TAGESMENUE_options', $new_options );
			$TAGESMENUE_options = get_option ( 'TAGESMENUE_options' );
		}

		if (isset($_POST['save']) ) {
			echo '<div class="message updated"><p>'.__('Options updated!', 'TAGESMENUE').'</p></div>';
		}

		if ( $TAGESMENUE_options == false ) {
			$TAGESMENUE_options = array();
		}
		?>
		<div class="wrap" id="TAGESMENUE_options" >
			<h2><?php _e('Tagesmenue Setting', 'TAGESMENUE'); ?></h2>

			<form method="post" action="#">
				<table class="form-table describe media-upload-form">

					<tr><td colspan="2"><h3><?php _e('Configuration', 'TAGESMENUE'); ?></h3></td></tr>


					<tr valign="top" class="field">
						<th class="label" scope="row"><label for="TAGESMENUE[tagesmenue_key]"><span class="alignleft"><?php _e('Tagesmenue key', 'TAGESMENUE'); ?></span></label></th>
						<td><input id="TAGESMENUE[tagesmenue_key]" type="text" style="width: 360px;" class="text" name="TAGESMENUE[tagesmenue_key]" value="<?php echo isset( $TAGESMENUE_options['tagesmenue_key'] ) ? esc_attr( $TAGESMENUE_options['tagesmenue_key'] ) : '' ; ?>" /></a>
						</td>
					</tr>
					
					<tr>
						<td>
							<p class="submit">
								<?php wp_nonce_field( 'TAGESMENUE-update-options'); ?>
								<input type="submit" name="save" class="button-primary" value="<?php _e('Save Changes', 'TAGESMENUE') ?>" />
							</p>
						</td>

				</table>
			</form>
		</div>
		<?php
	}

	function tagesmenue_popup_shortcode(){
		global $TAGESMENUE_options, $wp_styles;

		$pdf_files = new WP_Query( array(
			'post_type'      => 'attachment',
			'posts_per_page' => 100,
			'post_status'    => 'any',
			'meta_query'     => array(
				array(
					'key'     => 'TAGESMENUE_pdf_id',
					'value'   => '',
					'compare' => '!='
				)
			)
		) );

		if ( !empty($wp_styles->concat) ) {
			$dir = $wp_styles->text_direction;
			$ver = md5("$wp_styles->concat_version{$dir}");
			$href = $wp_styles->base_url . "/wp-admin/load-styles.php?c={$zip}&dir={$dir}&load=media&ver=$ver";
			echo "<link rel='stylesheet' href='" . esc_attr( $href ) . "' type='text/css' media='all' />\n";
		}

		 if ( empty($TAGESMENUE_options['tagesmenue_key']) ) : ?>
			<p><strong><?php _e("You havn't set your Tagesmenue Key, go to Settings Tagesmenue and insert your Key!", 'TAGESMENUE'); ?></strong></p>
		<?php else: ?>
		
			<h3 class="media-title"><?php _e('Insert Tagesmenue Shortcode', 'TAGESMENUE'); ?></h3>
			<form name="TAGESMENUE_shortcode_generator" id="TAGESMENUE_shortcode_generator">
				<div id="media-items">
					<div class="media-item media-blank">
						<table class="describe"><tbody>
							<tr valign="top" class="field">
								<td colspan="3">
									<input name="TAGESMENUE_key" type="hidden" id="TAGESMENUE_key" value="<?php echo $TAGESMENUE_options['tagesmenue_key']; ?>">
								</td>
							</tr>
							<tr valign="top" class="field">
								<th style="width: 300px;">Menu Format</th>
								<td colspan="2">
									<select name="tagesmenue_design" id="tagesmenue_design">
										<option value="tagesmenue-left">Left</option>
										<option value="tagesmenue-centered">Centered</option>
										<option selected value="tagesmenue-left2x">Left 2x</option>
										<option value="tagesmenue-centered2x">Centered 2x</option>
									</select>
								</td>
							</tr>
							<tr valign="top" class="field">
								<th style="width: 260px;">Tagesmenue + PDF Button + 3 Speisekarten</th>
								<td colspan="2">
									<input name="TAGESMENUE_showmenu_FULL" type="checkbox" id="TAGESMENUE_showmenu_FULL" value="true">
								</td>
							</tr>
							<tr valign="top" class="field">
								<th>Tagesmenue</th>
								<td colspan="2" >
									<input name="TAGESMENUE_showmenu" type="checkbox" id="TAGESMENUE_showmenu" value="true">
								</td>
							</tr>
							<tr valign="top" class="field">
								<th>Tagesmenue PDF Button</th>
								<td colspan="2" >
									<input name="TAGESMENUE_showpdfbutton" type="checkbox" id="TAGESMENUE_showpdfbutton" value="true">
								</td>
							</tr>

							<tr valign="top" class="field">
								<th>Speisekarte + Weinkarte + Dessertkarte</th>
								<td colspan="2" >
									<input name="TAGESMENUE_3speisekarten" type="checkbox" id="TAGESMENUE_3speisekarten" value="true">
								</td>
							</tr>
							
							<tr valign="top" class="field">
								<th>Single Katalog</td>
								<td>
									<input name="TAGESMENUE_showkatalogbutton" type="checkbox" id="TAGESMENUE_showkatalogbutton" value="true">
								</td>
								<td>
									<table>
										<tr>
										<td>
											<select name="tagesmenue_pdf_id" id="tagesmenue_pdf_id">
								<?php 			for ($k=1; $k<=10; $k++) { ?>				
													<option <?php if ($instance['thekatalog'] == $k) echo ' selected ' ?>  value="<?php echo $k; ?>">Katalog <?php echo $k; ?>
														<?php if ($k==1) echo ' / Speisekarte'; ?>
														<?php if ($k==2) echo ' / Weinkarte'; ?>
														<?php if ($k==3) echo ' / Dessertkarte'; ?>
													</option>
								<?php 			} ?>
											</select>
										</td>
										<tr>
										<tr>
											<td>
												Thumbnail<br>
												<?php
														$instance = wp_parse_args( (array) $instance, array(
															'tagesmenue_image_url'               => '',
															) );
														//echo '<script>var tb = document.getElementById("TB_ajaxContent");tb.setAttribute("style", "");</script>';
												?>

														<div>
															  <input type="text" style="width: 100%;" class="img widefat" name="tagesmenue_thumbnail" id="tagesmenue_thumbnail" value="<?php echo esc_url( $instance['tagesmenue_image_url'] ); ?>" /><br />
															  <input type="button" class="select-imgTM button button-primary" value="<?php _e( 'Upload', 'tagesmenue_katalog_widget' ); ?>" data-uploader_title="<?php _e( 'Select Image', 'tagesmenue_katalog_widget' ); ?>" data-uploader_button_text="<?php _e( 'Choose Image', 'tagesmenue_katalog_widget' ); ?>" style="margin-top:5px;" />

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
															  </div>

														</div>
											</td>
										</tr>									
									</table>
								</td>
							</tr>

							<tr valign="top" class="field">
								<td colspan="3">
									<input name="insert_TAGESMENUE_pdf" type="submit"  class="button-primary" id="insert_TAGESMENUE_pdf" tabindex="5" accesskey="p" value="<?php _e('Insert', 'TAGESMENUE') ?>">
								</td>
							</tr>
							
							
						</tbody></table>
					</div>
				</div>
			</form>
		<?php endif; ?>
		<?php exit();
	}

	function TAGESMENUEaddButtons() {
		global $TAGESMENUE_options;
		// Don't bother doing this stuff if the current user lacks permissions
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return false;

		if (get_user_option('rich_editing') == 'true') {			
			add_filter('mce_external_plugins', array (&$this,'TAGESMENUEaddScriptTinymce' ) );
			add_filter('mce_buttons', array (&$this,'registerTheButton' ) );
		}
	}

	function registerTheButton($buttons) {
		array_push($buttons, "|", "TAGESMENUE");
		return $buttons;
	}

	function TAGESMENUEaddScriptTinymce($plugin_array) {
		$plugin_array['TAGESMENUE'] = TAGESMENUE_URL . '/js/tagesmenue_tinymce.js';
		return $plugin_array;
	}
}
