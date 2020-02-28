<?php

/*



	Plugin Name: Gravity Forms BBPress Add-On

	Plugin URI: https://www.gravityforms.com

	Description: Integra Gravity Forms com BuddyPress, permitindo a criação de notificações quando um formulário for enviado.

	Version: 2.5.2

	Author: Matheus Darós (Drift Web)

	Author URI: https://www.driftweb.com.br

	License: GPL-2.0+

	Text Domain: gravityformsbuddy

	Domain Path: /languages



*/



// don't load directly

if ( ! defined( 'ABSPATH' ) ) {

	die();

}


define( 'GF_BP_VERSION', '2.5.2' );
define( 'GF_BP_PLUGIN_URL', plugin_dir_url(__FILE__) );


// If Gravity Forms is loaded, bootstrap the BuddyBoss Add-On.

add_action( 'gform_loaded', array( 'GF_BuddyPress_Bootstrap', 'load' ), 5 );

require_once('includes/class_gf_buddy_functions.php');
require_once('includes/class_gf_buddy_data.php');


GFBuddyFunctions::configurate_notification();

GFBuddyData::init();

/**

 * Class GF_BuddyBoss_Bootstrap

 *

 * Handles the loading of the Twilio Add-On and registers with the Add-On Framework.

 */

class GF_BuddyPress_Bootstrap {



	/**

	 * If the Feed Add-On Framework exists, BuddyPress Add-On is loaded.

	 *

	 * @access public

	 * @static

	 */

	public static function load(){



		if ( ! method_exists( 'GFForms', 'include_feed_addon_framework' ) ) {

			return;

		}
		
		require_once( 'class-gf-buddy.php' );

		GFAddOn::register( 'GFBuddy' );


	}

}



/**

 * Returns an instance of the GFBuddy class

 *

 * @see    GFBuddy::get_instance()

 *

 * @return object GFBuddy

 */

function gf_buddy(){

	return GFBuddy::get_instance();

}


add_action( 'gravityflow_loaded', function() { 

	if( ! class_exists("class-gf-buddy.php") ) {

		require_once( 'class-gf-buddy.php' );

	}
	
	if( ! class_exists('Gravity_Flow_Step_Feed_Buddy') ) {

		require_once("includes/class_step_feed_buddy.php");

	}

	Gravity_Flow_Steps::register( new Gravity_Flow_Step_Feed_Buddy() );

});

