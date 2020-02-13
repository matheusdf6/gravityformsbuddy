<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class GFBuddyFunctions {

    public function configurate_notification() {
        add_filter( 'bp_notifications_get_registered_components', array($this, 'set_component_name') );
        add_filter( 'bp_notifications_get_notifications_for_user', array($this, 'set_component_action'), 10, 5 );
    }

    public function set_component_name( $component_names = array() ) {

        // Force $component_names to be an array
        if ( ! is_array( $component_names ) ) {
            $component_names = array();
        }
    
        // Add 'custom' component to registered components array
        array_push( $component_names, 'gf_buddy' );
    
        // Return component's with 'custom' appended
        return $component_names;

    }

    public function set_component_action(  $action, $item_id, $secondary_item_id, $total_items, $format = 'string' ) {
        if ( 'gf_buddy' === $action ) {

            

        }
        return $action;
    }

    public function send_notification() {

    }

}