<?php

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

GFForms::include_feed_addon_framework();

/**
 * Gravity Forms Twilio Add-On.
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
	 * @var    string $_version Contains the version, defined from twilio.php
	 */
	protected $_version = GF_BB_VERSION;

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




	// # PLUGIN SETTINGS -----------------------------------------------------------------------------------------------

	/**
	 * Configures the settings which should be rendered on the add-on settings tab.
	 *
	 * @since  Unknown
	 * @access public
	 *
	 * @return array
	 */
	// public function plugin_settings_fields() {

	// 	return array(
	// 		array(
	// 			'title'       => esc_html__( 'Twilio Account Information', 'gravityformstwilio' ),
	// 			'description' => sprintf(
	// 				esc_html__( 'Twilio provides a web-service API for businesses to build scalable and reliable communication apps. %1$s Sign up for a Twilio account%2$s to receive SMS messages when a Gravity Form is submitted.', 'gravityformstwilio' ),
	// 				'<a href="http://www.twilio.com" target="_blank">',
	// 				'</a>'
	// 			),
	// 			'fields'      => array(
	// 				array(
	// 					'name'              => 'apiMode',
	// 					'label'             => esc_html__( 'API Mode', 'gravityformstwilio' ),
	// 					'type'              => 'radio',
	// 					'default_value'     => 'live',
	// 					'horizontal'        => true,
	// 					'choices'           => array(
	// 						array(
	// 							'value' => 'live',
	// 							'label' => esc_html__( 'Live', 'gravityformstwilio' ),
	// 						),
	// 						array(
	// 							'value' => 'test',
	// 							'label' => esc_html__( 'Test', 'gravityformstwilio' ),
	// 						),
	// 					),
	// 				),
	// 				array(
	// 					'name'              => 'accountSid',
	// 					'label'             => esc_html__( 'Account SID', 'gravityformstwilio' ),
	// 					'type'              => 'text',
	// 					'class'             => 'medium',
	// 					'feedback_callback' => array( $this, 'initialize_api' ),
	// 				),
	// 				array(
	// 					'name'              => 'authToken',
	// 					'label'             => esc_html__( 'Auth Token', 'gravityformstwilio' ),
	// 					'type'              => 'text',
	// 					'class'             => 'medium',
	// 					'feedback_callback' => array( $this, 'initialize_api' ),
	// 				),
	// 				array(
	// 					'name'              => 'testAccountSid',
	// 					'label'             => esc_html__( 'Test Account SID', 'gravityformstwilio' ),
	// 					'type'              => 'text',
	// 					'class'             => 'medium',
	// 					'feedback_callback' => array( $this, 'initialize_test_api' ),
	// 				),
	// 				array(
	// 					'name'              => 'testAuthToken',
	// 					'label'             => esc_html__( 'Test Auth Token', 'gravityformstwilio' ),
	// 					'type'              => 'text',
	// 					'class'             => 'medium',
	// 					'feedback_callback' => array( $this, 'initialize_test_api' ),
	// 				),
	// 			),
	// 		),
	// 		array(
	// 			'title'       => esc_html__( 'Bitly Account Information', 'gravityformstwilio' ),
	// 			'description' => sprintf(
	// 				esc_html__( 'Bitly helps you shorten, track and analyze your links. Enter your Bitly account information below to automatically shorten URLs in your SMS message. If you don\'t have a Bitly account, %1$ssign-up for one here%2$s', 'gravityformstwilio' ),
	// 				'<a href="http://bit.ly" target="_blank">',
	// 				'</a>.'
	// 			),
	// 			'fields'      => array(
	// 				array(
	// 					'name'              => 'bitlyAccessToken',
	// 					'label'             => esc_html__( 'Access Token', 'gravityformstwilio' ),
	// 					'type'              => 'text',
	// 					'class'             => 'large',
	// 					'feedback_callback' => array( $this, 'validate_bitly_credentials' ),
	// 				),
	// 				array(
	// 					'name'              => 'bitlyLogin',
	// 					'label'             => esc_html__( 'Login', 'gravityformstwilio' ),
	// 					'type'              => 'hidden',
	// 					'class'             => 'medium',
	// 					'feedback_callback' => array( $this, 'validate_legacy_bitly_credentials' ),
	// 				),
	// 				array(
	// 					'name'              => 'bitlyApikey',
	// 					'label'             => esc_html__( 'API Key', 'gravityformstwilio' ),
	// 					'type'              => 'hidden',
	// 					'class'             => 'medium',
	// 					'feedback_callback' => array( $this, 'validate_legacy_bitly_credentials' ),
	// 				),
	// 			),
	// 		),
	// 	);

	// }





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

	/**
	 * Validate the text input for the message From setting.
	 *
	 * @since  Unknown
	 * @access public
	 *
	 * @param array  $field         The field setting.
	 * @param string $field_setting The field value.
	 *
	 * @uses GFAddOn::get_posted_settings()
	 * @uses GFAddOn::set_field_error()
	 */
	public function validate_from( $field, $field_setting ) {

		// If a custom From Number is not set, return.
		if ( $field_setting != 'gf_custom' ) {
			return;
		}

		// Get posted settings.
		$settings = $this->get_posted_settings();

		$field['name'] .= '_custom';
		$from           = rgar( $settings, 'fromNumber_custom' );

		// Alphanumeric Sender ID can't be more than 11 characters.
		if ( rgblank( $from ) ) {
			$this->set_field_error( $field );
		} elseif ( strlen( $from ) > 11 ) {
			$this->set_field_error( $field, __( 'The Alphanumeric Sender ID must be no longer than 11 characters.' ), 'gravityformstwilio' );
		} elseif ( ! preg_match( '/^[a-zA-Z0-9 ]+$/', $from ) ) {
			$this->set_field_error( $field, __( 'The Alphanumeric Sender ID only supports upper and lower case letters, the digits 0 through 9, and spaces.' ), 'gravityformstwilio' );
		}

	}

	/**
	 * Renders and initializes a drop down field with a input field for custom input based on the $field array.
	 * (Forked to add support for merge tags in input field.)
	 *
	 * @since  2.4
	 * @access public
	 *
	 * @param array $field Field array containing the configuration options of this field
	 * @param bool  $echo  True to echo the output to the screen, false to simply return the contents as a string
	 *
	 * @return string The HTML for the field
	 */
	public function settings_select_custom( $field, $echo = true ) {

		// Prepare select field.F
		$select_field             = $field;
		$select_field_value       = $this->get_setting( $select_field['name'], rgar( $select_field, 'default_value' ) );
		$select_field['onchange'] = '';
		$select_field['class']    = ( isset( $select_field['class'] ) ) ? $select_field['class'] . 'gaddon-setting-select-custom' : 'gaddon-setting-select-custom';

		// Prepare input field.
		$input_field          = $field;
		$input_field['name'] .= '_custom';
		$input_field['style'] = 'width:200px;max-width:90%;';
		$input_field['class'] = rgar( $field, 'input_class' );
		$input_field_display  = '';

		// Loop through select choices and make sure option for custom exists.
		$has_gf_custom = false;
		foreach ( $select_field['choices'] as $choice ) {

			if ( rgar( $choice, 'name' ) == 'gf_custom' || rgar( $choice, 'value' ) == 'gf_custom' ) {
				$has_gf_custom = true;
			}

			// If choice has choices, check inside those choices..
			if ( rgar( $choice, 'choices' ) ) {
				foreach ( $choice['choices'] as $subchoice ) {
					if ( rgar( $subchoice, 'name' ) == 'gf_custom' || rgar( $subchoice, 'value' ) == 'gf_custom' ) {
						$has_gf_custom = true;
					}
				}
			}

		}
		if ( ! $has_gf_custom ) {
			$select_field['choices'][] = array(
				'label' => esc_html__( 'Add Custom', 'gravityforms' ) .' ' . $select_field['label'],
				'value' => 'gf_custom'
			);
		}

		// If select value is "gf_custom", hide the select field and display the input field.
		if ( $select_field_value == 'gf_custom' || ( count( $select_field['choices'] ) == 1 && $select_field['choices'][0]['value'] == 'gf_custom' ) ) {
			$select_field['style'] = 'display:none;';
		} else {
			$input_field_display   = ' style="display:none;"';
		}

		// Add select field.
		$html = $this->settings_select( $select_field, false );

		// Add input field.
		$html .= '<div class="gaddon-setting-select-custom-container"'. $input_field_display .'>';
		$html .= count( $select_field['choices'] ) > 1 ? '<a href="#" class="select-custom-reset">Reset</a>' : '';
		$html .= $this->settings_text( $input_field, false );
		$html .= '</div>';

		if ( $echo ) {
			echo $html;
		}

		return $html;

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

	// /**
	//  * Returns the value to be displayed in the From column.
	//  *
	//  * @since  Unknown
	//  * @access public
	//  *
	//  * @param array $feed Feed object.
	//  *
	//  * @uses GFTwilio::get_message_from()
	//  *
	//  * @return string
	//  */
	// public function get_column_value_fromNumber( $feed ) {

	// 	return $this->get_message_from( $feed );

	// }

	// /**
	//  * Returns the value to be displayed in the From column.
	//  *
	//  * @since  Unknown
	//  * @access public
	//  *
	//  * @param array $feed Feed object.
	//  *
	//  * @uses GFAddOn::get_current_form()
	//  * @uses GFFormsModel::get_field()
	//  * @uses GFTwilio::get_message_from()
	//  *
	//  * @return string
	//  */
	// public function get_column_value_toNumber( $feed ) {

	// 	// If a custom value is set, return it.
	// 	if ( 'gf_custom' === rgars( $feed, 'meta/toNumber' ) ) {
	// 		return rgars( $feed, 'meta/toNumber_custom' );
	// 	}

	// 	// Get To Number value.
	// 	$to_number = rgars( $feed, 'meta/toNumber' );

	// 	// If a field is not selected, return number.
	// 	if ( 'field_' !== substr( $to_number, 0, 6 ) ) {
	// 		return $to_number;
	// 	}

	// 	// Get field ID.
	// 	$phone_field = str_replace( 'field_', '', $to_number );

	// 	// Get current form.
	// 	$form = $this->get_current_form();

	// 	// Get field.
	// 	$phone_field = GFFormsModel::get_field( $form, $phone_field );

	// 	return esc_html( $phone_field->label );

	// }





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

		// Get plugin settings.
		$plugin_settings = $this->get_plugin_settings();

		// Prepare message arguments.
		$args = array(
			'to'          => $this->get_message_to( $feed, $entry, $form ),
			'from'        => $this->get_message_from( $feed ),
			'body'        => rgars( $feed, 'meta/smsMessage' ),
			'shorten_url' => rgars( $feed, 'meta/shortenURL' ),
        );
        
        $args = array(
            'message'   => rgars( $feed, 'meta/message' ),
            'toUser'    => rgars( $feed, 'meta/toUser' )
        )

		$args['toUser'] = apply_filters( 'gform_buddy_set_user', $args['toUser'], $entry, $feed['id'] );
        $args['setMessage'] = apply_filters( 'gform_buddy_set_message', $args['message'], $entry, $feed['id'] );

		// Limit message to 200 characters.
		$max_len = 200;
		if ( strlen( $args['message'] ) > $max_len ) {
			$args['message'] = substr( $args['message'], 0, $max_len - 3 );
			$args['message'] = $args['message'] . '...';
        }
        
        if ( bp_is_active( 'notifications' ) ) 
        {
            bp_notifications_add_notification( array(
                'user_id'           => $user_id,
                'item_id'           => $activity,
                'secondary_item_id' => $reacted_userid,
                'component_name'    => 'reaction',
                'component_action'  => 'ai_reaction_bp',
                'date_notified'     => bp_core_current_time(),
                'is_new'            => 1
            ) );
        }
    

		try {

			// Remove To Number from arguments.
			$to = rgar( $args, 'to' );
			unset( $args['to'] );

			// Send message.
			$message = $api->messages->create( $to, $args );

			// Log that the message was sent.
			$this->log_debug( __METHOD__ . '(): SMS successfully sent; ' . print_r( $message, true ) );

		} catch ( \Exception $e ) {

			// Log that message could not be sent.
			$this->add_feed_error( sprintf( esc_html__( 'Unable to send SMS: %s (%d)', 'gravityformstwilio' ), $e->getMessage(), $e->getCode() ), $feed, $entry, $form );

		}

	}





	// # HELPER METHODS ------------------------------------------------------------------------------------------------


	/**
	 * Return the from number or Alphanumeric Sender ID.
	 *
	 * @since  Unknown
	 * @access public
	 *
	 * @param array $feed The Feed object.
	 *
	 * @return string
	 */
	public function get_message_from( $feed ) {

		return 'gf_custom' === rgars( $feed, 'meta/fromNumber' ) ? rgars( $feed, 'meta/fromNumber_custom' ) : rgars( $feed, 'meta/fromNumber' );

	}

	/**
	 * Return the To Number.
	 *
	 * @since  2.4
	 * @access public
	 *
	 * @param array $feed  The Feed object.
	 * @param array $entry The Entry object.
	 * @param array $form  The Form object.
	 *
	 * @uses GFCommon::replace_variables()
	 *
	 * @return string
	 */
	public function get_message_to( $feed, $entry, $form ) {

		// If a custom value is set, return it.
		if ( 'gf_custom' === rgars( $feed, 'meta/toNumber' ) ) {
			return GFCommon::replace_variables( $feed['meta']['toNumber_custom'], $form, $entry, false, true, false, 'text' );
		}

		// Get To Number value.
		$to_number = rgars( $feed, 'meta/toNumber' );

		// If a field is not selected, return number.
		if ( 'field_' !== substr( $to_number, 0, 6 ) ) {
			return $to_number;
		}

		// Get field ID.
		$phone_field = str_replace( 'field_', '', $to_number );

		// Get field value.
		$to_number = rgar( $entry, $phone_field );

		return $to_number;

	}


}
