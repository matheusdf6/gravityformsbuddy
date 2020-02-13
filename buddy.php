<?php

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/*
Plugin Name: Gravity Forms BBPress Add-On
Plugin URI: https://www.gravityforms.com
Description: Integra Gravity Forms com BuddyBoss, permitindo a criação de notificações quando um formulário for enviado.
Version: 2.5.2
Author: Matheus Darós (Drift Web)
Author URI: https://www.driftweb.com.br
License: GPL-2.0+
Text Domain: gravityformsbuddy
Domain Path: /languages

 */

define( 'GF_BB_VERSION', '2.5.2' );

// If Gravity Forms is loaded, bootstrap the BuddyBoss Add-On.
add_action( 'gform_loaded', array( 'GF_BuddyPress_Bootstrap', 'load' ), 5 );

/**
 * Class GF_BuddyBoss_Bootstrap
 *
 * Handles the loading of the Twilio Add-On and registers with the Add-On Framework.
 */
class GF_BuddyPress_Bootstrap {

	/**
	 * If the Feed Add-On Framework exists, Twilio Add-On is loaded.
	 *
	 * @access public
	 * @static
	 */
	public static function load(){

		if ( ! method_exists( 'GFForms', 'include_feed_addon_framework' ) ) {
			return;
		}

		require_once( 'class-gf-twilio.php' );

		GFAddOn::register( 'GFBuddy' );
	}
}

/**
 * Returns an instance of the GFTwilio class
 *
 * @see    GFTwilio::get_instance()
 *
 * @return object GFTwilio
 */
function gf_twilio(){
	return GFTwilio::get_instance();
}
