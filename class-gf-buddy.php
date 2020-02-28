<?php



// don't load directly

if ( ! defined( 'ABSPATH' ) ) {

	die();

}



GFForms::include_feed_addon_framework();



/**

 * Gravity Forms BuddyPress Add-On.

 *

 * @since     1.0

 * @package   GravityForms

 * @author    Matheus Darós

 * @copyright Copyright (c) 2017, Matheus Darós

 */

class GFBuddy extends GFFeedAddOn {



	/**

	 * Contains an instance of this class, if available.

	 *

	 * @since  Unknown

	 * @access private

	 * @var    object $_instance If available, contains an instance of this class.

	 */

	private static $_instance = null;



	/**

	 * Defines the version of the Twilio Add-On.

	 *

	 * @since  Unknown

	 * @access protected

	 * @var    string $_version Contains the version, defined from buddy.php

	 */

	protected $_version = GF_BP_VERSION;



	/**

	 * Defines the minimum Gravity Forms version required.

	 *

	 * @since  Unknown

	 * @access protected

	 * @var    string $_min_gravityforms_version The minimum version required.

	 */

	protected $_min_gravityforms_version = '0.0.1';



	/**

	 * Defines the plugin slug.

	 *

	 * @since  Unknown

	 * @access protected

	 * @var    string $_slug The slug used for this plugin.

	 */

	protected $_slug = 'gravityformsbuddy';



	/**

	 * Defines the main plugin file.

	 *

	 * @since  Unknown

	 * @access protected

	 * @var    string $_path The path to the main plugin file, relative to the plugins folder.

	 */

	protected $_path = 'gravityformsbuddy/buddy.php';



	/**

	 * Defines the full path to this class file.

	 *

	 * @since  Unknown

	 * @access protected

	 * @var    string $_full_path The full path.

	 */

	protected $_full_path = __FILE__;



	/**

	 * Defines the URL where this Add-On can be found.

	 *

	 * @since  Unknown

	 * @access protected

	 * @var    string The URL of the Add-On.

	 */

	protected $_url = 'http://www.gravityforms.com';



	/**

	 * Defines the title of this Add-On.

	 *

	 * @since  Unknown

	 * @access protected

	 * @var    string $_title The title of the Add-On.

	 */

	protected $_title = 'BuddyPress Add-On';



	/**

	 * Defines the short title of the Add-On.

	 *

	 * @since  Unknown

	 * @access protected

	 * @var    string $_short_title The short title.

	 */

	protected $_short_title = 'BuddyPress';



	/**

	 * Defines if Add-On should use Gravity Forms servers for update data.

	 *

	 * @since  Unknown

	 * @access protected

	 * @var    bool

	 */

	protected $_enable_rg_autoupgrade = true;



	/**

	 * Defines the capability needed to access the Add-On settings page.

	 *

	 * @since  Unknown

	 * @access protected

	 * @var    string $_capabilities_settings_page The capability needed to access the Add-On settings page.

	 */

	protected $_capabilities_settings_page = 'gravityforms_buddy';



	/**

	 * Defines the capability needed to access the Add-On form settings page.

	 *

	 * @since  Unknown

	 * @access protected

	 * @var    string $_capabilities_form_settings The capability needed to access the Add-On form settings page.

	 */

	protected $_capabilities_form_settings = 'gravityforms_buddy';



	/**

	 * Defines the capability needed to uninstall the Add-On.

	 *

	 * @since  Unknown

	 * @access protected

	 * @var    string $_capabilities_uninstall The capability needed to uninstall the Add-On.

	 */

	protected $_capabilities_uninstall = 'gravityforms_buddy_uninstall';



	/**

	 * Defines the capabilities needed for the BuddyPress Add-On.

	 *

	 * @since  Unknown

	 * @access protected

	 * @var    array $_capabilities The capabilities needed for the Add-On.

	 */

	protected $_capabilities = array( 'gravityforms_buddy', 'gravityforms_buddy_uninstall' );





	/**

	 * Get instance of this class.

	 *

	 * @access public

	 * @static

	 *

	 * @return GFBuddy

	 */

	public static function get_instance() {



		if ( null === self::$_instance ) {

			self::$_instance = new self;

		}



		return self::$_instance;



	}



	/**

	 * Plugin starting point. 

	 *

	 * @since  Unknown

	 * @access public

	 */

	public function init() {



		parent::init();

	}





	// # FEED SETTINGS -------------------------------------------------------------------------------------------------



	/**

	 * Setup fields for feed settings.

	 *

	 * @since  Unknown

	 * @access public

	 *

	 * @uses GFBuddy::get_buddy_users_as_choices()

	 *

	 * @return array

	 */

	public function feed_settings_fields() {

        return array(
			array(
				'title'       => esc_html__( 'Configurações do Feed BuddyPress', 'gravityformsbuddy' ),
				'description' => '',
				'fields'      => array(
					array(
						'name'                => 'feedName',
						'label'               => esc_html__( 'Nome', 'gravityformsbuddy' ),
						'type'                => 'text',
						'required'            => true,
						'class'               => 'medium',
						'tooltip'             => sprintf(
							'<h6>%s</h6>%s',
							esc_html__( 'Nome', 'gravityformsbuddy' ),
							esc_html__( 'Entre com um nome para o Feed para identificá-lo.', 'gravityformsbuddy' )
						),
					),
					array(
						'name'                => 'toUser',
						'label'               => esc_html__( 'Para quem enviar?', 'gravityformsbuddy' ),
						'type'                => 'select_custom',
						'choices'             => $this->get_buddy_users_as_choices( 'outgoing_numbers' ),
						'required'            => true,
						'input_class'         => 'merge-tag-support mt-position-right',
						'tooltip'             => sprintf(
							'<h6>%s</h6>%s',
							esc_html__( 'Para quem enviar?', 'gravityformsbuddy' ),
							esc_html__( 'Usuário o qual receberá as notificações', 'gravityformsbuddy' )
						),
					),
					array(
						'name'                => 'pathUrl',
						'label'               => esc_html__( 'URL para redirecionar?', 'gravityformsbuddy' ),
						'type'                => 'text',
						'required'            => false,
						'class'         	  => 'medium',
						'tooltip'             => sprintf(
							'<h6>%s</h6>%s',
							esc_html__( 'URL para redirecionar?', 'gravityformsbuddy' ),
							esc_html__( 'Link que será redirecionado para quando o usuário clicar na notificação', 'gravityformsbuddy' )
						),
					),
					array(
						'name'                => 'message',
						'label'               => esc_html__( 'Mensagem Padrão', 'gravityformsbuddy' ),
						'type'                => 'textarea',
						'class'               => 'medium merge-tag-support mt-position-right',
						'tooltip'             => sprintf(
							'<h6>%s</h6>%s',
							esc_html__( 'Mensagem', 'gravityformstwilio' ),
							esc_html__( 'Escreva uma mensagem que será mostrada como notificação', 'gravityformsbuddy' )

						),
					),
				),
			),
		);

	}



	/**

	 * Retrieve the from/to numbers for use on the feed settings page.

	 *

	 * @since  2.4

	 * @access public

	 *

	 * @param string $type The phone number type. Either incoming_numbers or outgoing_numbers.

	 *

	 * @uses GFAddOn::get_current_form()

	 * @uses GFAddOn::log_debug()

	 * @uses GFAddOn::log_error()

	 * @uses GFAPI::get_fields_by_type()

	 * @uses GFTwilio::initialize_api()

	 *

	 * @return array

	 */

	public function get_buddy_users_as_choices( $type ) {

		$users = get_users( array( 'fields' => array( 'ID', 'display_name' )  ) );
		
        $user_choices = array();
        foreach ( $users as $user) {
            $user_choices[] = array(
                'label' => esc_html( $user->display_name ),
                'value' => 'field_' . esc_attr( $user->ID ),
            );
        }

        return $user_choices;
	}





	// # FEED LIST -----------------------------------------------------------------------------------------------------



	/**

	 * Setup columns for feed list table.

	 *

	 * @since  Unknown

	 * @access public

	 *

	 * @return array

	 */

	public function feed_list_columns() {



		return array(

			'feedName'   => esc_html__( 'Nome', 'gravityformsbuddy' ),

			'toUser' => esc_html__( 'Para qual usuário', 'gravityformsbuddy' )

		);



	}

	public function get_column_value_toUser( $feed ){

		if ( ! class_exists( 'GFBuddyFunctions' ) ) {

			require_once( 'includes/class_gf_buddy_functions.php' );
		} 

		$user_field = rgars( $feed, 'meta/toUser' );

		$user_id = intval( str_replace("field_", "", $user_field) );

		return '<b>' . GFBuddyFunctions::get_user_display_name($user_id) . '</b>';

	}



	// # FEED PROCESSING -----------------------------------------------------------------------------------------------



	/**

	 * Initiate processing the feed.

	 *

	 * @since  2.0

	 * @access public

	 *

	 * @param array $feed  The Feed object to be processed.

	 * @param array $entry The Entry object currently being processed.

	 * @param array $form  The Form object currently being processed.

	 *

	 * @uses GFAddOn::get_plugin_settings()

	 * @uses GFAddOn::log_debug()

	 * @uses GFCommon::replace_variables()

	 * @uses GFFeedAddOn::add_feed_error()

	 * @uses GFTwilio::get_message_form()

	 */

	public function process_feed( $feed, $entry, $form ) {

        $args = array(
            'message'   => $feed['meta']['message'],
            'toUser'    => rgars( $feed, 'meta/toUser' )
		);

		$args['toUser'] = apply_filters( 'gform_buddy_set_user', $args['toUser'], $entry, $feed['id'] );
        $args['message'] = apply_filters( 'gform_buddy_set_message', $args['message'], $entry, $feed['id'] );

		if( ! class_exists('GFBuddyData') ) {

			require_once( 'includes/class_gf_buddy_data.php' );
		}

		if ( ! class_exists( 'GFBuddyFunctions' ) ) {

			require_once( 'includes/class_gf_buddy_functions.php' );
		} 

		$args['message'] = GFCommon::replace_variables($args['message'], $form, $entry, false, false, false, 'text');

		$map_id = GFBuddyData::add_new_item($feed['id'], $form['id'], $entry['id'], $args['message']);

		$toUser = rgar($args, 'toUser');

		GFBuddyFunctions::send_notification($toUser, $map_id, $entry);

	}

}

