<?php
/*
Plugin Name: Tagesmenue
Plugin URI: http://www.colbe.ch
Description: Get Tagesmenue from www.tagesmenue.ch
Version: 1.0.0
Author: Rouh Mehdi
Author URI: http://www.tagesmenue.ch
Text Domain: TAGESMENUE

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation;

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
*/

define( 'TAGESMENUE_VERSION', '1.0.0' );
define( 'TAGESMENUE_URL', plugins_url( '', __FILE__ ) );
define( 'TAGESMENUE_DIR', dirname( __FILE__ ) );
define( 'TAGESMENUE_KATALOG_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );

if ( is_admin() ) {
	require( TAGESMENUE_DIR . '/inc/class.admin.php');
}

register_activation_hook( __FILE__, 'TAGESMENUE_Install' );

function TAGESMENUE_Init() {
	global $TAGESMENUE, $TAGESMENUE_options;
	$TAGESMENUE_options = get_option ( 'TAGESMENUE_options' );
	if ( class_exists( 'TAGESMENUE_Admin' ) ) {
		$TAGESMENUE['admin'] = new TAGESMENUE_Admin();
	}
}
add_action( 'plugins_loaded', 'TAGESMENUE_Init' );

function TAGESMENUE_Install() {
	$TAGESMENUE_options = get_option ( 'TAGESMENUE_options' );
	if ( empty( $TAGESMENUE_options ) ) {
		update_option( 'TAGESMENUE_options', array( 
			'tagesmenue_username' => '',
			'tagesmenue_key' => ''
		) );
	}
}

function hook_TAGESMENUE_javascript()
{
	global $TAGESMENUE_options;	
	wp_enqueue_script( 'tagesmenue-WS_nojquery', plugins_url() .'/tagesmenue/js/WS_nojquery.js', array('jquery'), '1.0.0' );
	wp_enqueue_script( 'tagesmenue-jMsAjax', plugins_url() .'/tagesmenue/js/jMsAjax.js', array(), '0.2.2' );

	wp_enqueue_script( 'tagesmenue-colorbox-script', plugins_url() .'/tagesmenue/js/colorbox/jquery.colorbox-min.js', array(), '1.6.4' );
	wp_enqueue_style('tagesmenue-colorbox-style', plugins_url() .'/tagesmenue/js/colorbox/css/colorbox.css', array(), '1.6.4', 'all');
	wp_enqueue_style('tagesmenue-tagesmenuestyle', plugins_url() .'/tagesmenue/css/tagesmenue.css', array(), '1.0.0', 'all');
	
	$tag[0] = "Sonntag";
	$tag[1] = "Montag";
	$tag[2] = "Dienstag";
	$tag[3] = "Mittwoch";
	$tag[4] = "Donnerstag";
	$tag[5] = "Freitag";
	$tag[6] = "Samstag";
	$tagnummer = date("w");
	$theday = $tag[$tagnummer];
	$TAGESMENUE_key = $TAGESMENUE_options['tagesmenue_key'];

	wp_enqueue_script( 'gettagesmenue-js', plugins_url() .'/tagesmenue/js/gettagesmenue.js', array(), '1.0.0' );
	wp_add_inline_script( 'gettagesmenue-js', 
		'if (jQuery(".tagesmenue")[0] ) { ' .
		'var service = new WS("http://www.tagesmenue.ch/WebServiceTagesmenue.asmx", WSDataType.jsonp); '  .
		'service.call("TagesmenueDIVWP18", { wochentag: "'. $theday . '", iuid: "' . $TAGESMENUE_key . '", showmenu: "true", showpdfbutton: "false" }, function (res) {' .
		'    jQuery("#tagesmenue").html(res[0]); ' .
		'    jQuery("#tagesmenue2").html(res[0]); ' .
		
		'	  jQuery(".menu-detail").each(function () { ' .
		'			var myArray = jQuery(this).html().split("|"); ' .
		'			jQuery(this).html(' .
		'							 ((myArray[0])?\'<br><span style="color:#555; font-style: normal; ">\'+myArray[0]+"</span>":"") ' .
		'							 + ((myArray[1])?\'<br><span style="color:#777; font-style: italic; font-size: -2;">\'+myArray[1]+"</span>":"") ' .
		'							 + ((myArray[2])?\'<br><span style="color:#888; font-style: italic; font-size: -2;">\'+myArray[2]+"</span>":"") ' .
		'							 ); ' .
		'		}); ' .
		'  });' .
		'}'	.
		
		'if (jQuery(".tagesmenuebo")[0] ) { ' .
		'var service = new WS("http://www.tagesmenue.ch/WebServiceTagesmenue.asmx", WSDataType.jsonp); '  .
		'service.call("TagesmenueDIVWP18", { wochentag: "'. $theday . '", iuid: "' . $TAGESMENUE_key . '", showmenu: "false", showpdfbutton: "true" }, function (res) {' .
		'    jQuery("#tagesmenuebo").html(res[0]); ' .
		'    jQuery("#tagesmenuebo2").html(res[0]); ' .
		'  });' .
		'}'	.

		'	jQuery(document).ready(function(){' .
		'		jQuery(".iframe").colorbox({iframe:true, width:"90%", height:"90%"});' .
		'	});' .
		
		'for (var k = 1; k <= 10; k++) { ' .
		'	if (jQuery("a#kp" + k).length > 0) { ' .
		'		var kp_href_orig = jQuery("a#kp" + k).attr("href"); ' .
		'		var kp_href = "http://www.tagesmenue.ch/book.aspx?id=" + kp_href_orig + "&m=" + k; ' .
		'		if (navigator.userAgent.match(/(iPhone|iPod|BlackBerry|Android|Opera Mini|IEMobile)/i) != null) { ' .
		'			var kp_href_ipad = ""; ' .
		'			kp_href_ipad="http://www.tagesmenue.ch/bildupload/" + kp_href_orig.substr(0, 36) + "/katalog"+k+".pdf"; ' .
		'			jQuery("a#kp" + k).attr("href", kp_href_ipad); ' .
		'			jQuery("a#kp" + k).attr("target", "_blank"); ' .
		'		} else { ' .
		'			jQuery("a#kp" + k).attr("href", kp_href); ' .
		'			jQuery("a#kp" + k).attr("class", "iframe"); ' .
		'			jQuery("a#kp" + k).attr("target", ""); ' .
		'		} ' .
		'	} ' .
		'} '
	);
}
add_action('wp_footer','hook_TAGESMENUE_javascript');

function tagesmenue_katalog_scripts( $hook ) {
	wp_enqueue_style( 'tagesmenue-katalog-admin', TAGESMENUE_KATALOG_URL . '/css/admin.css', array(), '1.4.0' );
	wp_enqueue_media();
	wp_enqueue_script( 'tagesmenue-katalog-admin', TAGESMENUE_KATALOG_URL . '/js/adminTM.js', array( 'jquery' ), '1.4.0' );
}
add_action( 'admin_enqueue_scripts', 'tagesmenue_katalog_scripts' );