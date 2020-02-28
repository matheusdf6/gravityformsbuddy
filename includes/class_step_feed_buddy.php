<?php
/**
 * Gravity Flow Step Feed BuddyPress
 *
 * @package     GravityFlow
 * @subpackage  Classes/Gravity_Flow_Step_Feed_Buddy
 * @copyright   Copyright (c) 2016-2018, Steven Henty S.L.
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.3.2-dev
 */


if ( ! class_exists( 'GFForms' ) ) {
	die();
}

/**
 * Class Gravity_Flow_Step_Feed_Buddy
 */
class Gravity_Flow_Step_Feed_Buddy extends Gravity_Flow_Step_Feed_Add_On {

	/**
	 * The step type.
	 *
	 * @var string
	 */
	public $_step_type = 'buddy';

	/**
	 * The name of the class used by the add-on.
	 *
	 * @var string
	 */
	protected $_class_name = 'GFBuddy';

	/**
	 * Returns the step label.
	 *
	 * @return string
	 */
	public function get_label() {
		return 'BuddyPress';
	}

	/**
	 * Returns the feed name.
	 *
	 * @param array $feed The Slack feed properties.
	 *
	 * @return string
	 */
	public function get_feed_label( $feed ) {

		$label = $feed['meta']['feedName'];

		return $label;
	}

	/**
	 * Returns the URL for the step icon.
	 *
	 * @return string
	 */
	public function get_icon_url() {

        return  GF_BP_PLUGIN_URL  . 'image/buddy-icon.png';
        
	}


	public function process(){
		parent::process();
		return true;
	}
}

