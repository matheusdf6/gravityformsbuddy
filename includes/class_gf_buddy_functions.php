<?php



if ( ! defined( 'ABSPATH' ) ) {

	die();

}



abstract class GFBuddyFunctions {



    public static function configurate_notification() {

        add_filter( 'bp_notifications_get_registered_components', array('GFBuddyFunctions', 'set_component_name') );

        add_filter( 'bp_notifications_get_notifications_for_user', array('GFBuddyFunctions', 'set_component_action'), 10, 5 );

    }



    public static function set_component_name( $component_names = array() ) {



        // Force $component_names to be an array

        if ( ! is_array( $component_names ) ) {

            $component_names = array();

        }

    

        // Add 'custom' component to registered components array

        array_push( $component_names, 'gf_buddy' );

    

        // Return component's with 'custom' appended

        return $component_names;



    }



    public static function set_component_action( $action, $item_id, $secondary_item_id, $total_items, $format = 'string' ) {

        if ( 'gf_buddy_action' === $action ) {
     

            if( ! class_exists('GFBuddyData') ) {

                require_once( 'includes/class_gf_buddy_data.php' );
            }
    
    
            $map = GFBuddyData::get_item( $item_id );

            if ( !empty($map) ) {

                $text = $map['message'];

                $feed = GFAPI::get_feeds($map['feed_id']);

                if( !empty($feed) ) {

                    $feed = $feed[0];

                    $link = $feed['meta']['pathUrl'];

                } else {

                    $link = '';

                }

            } else {

                $usuario =  bp_core_get_user_displayname( $secondary_item_id );

                $text = sprintf(__("%s enviou um novo formulário", "gravityformsbuddy"), $usuario);

                $link = '';

            }

            $link = "https://www.google.com";

            $custom_title = __("Nova atividade no fluxo de trabalho", 'gravityformsbuddy');

            // WordPress Toolbar
            if ( 'string' === $format ) {

                if( empty($link) ) {

                    $return = apply_filters( 'custom_filter', '<span>' . esc_html( $text ) . '</span>', $text );

                } else {

                    $return = apply_filters( 'custom_filter', '<a href="' . esc_url($link) .'" title="' . esc_attr( $custom_title ) . '">' . esc_html( $text ) . '</a>', $text );

                }

     

            // Deprecated BuddyBar
            } else {

                if( empty($link) ) {

                    $return = apply_filters( 'custom_filter', array(

                        'text' => $text
    
                    ), (int) $total_items, $link, $text, $custom_title );
    

                } else {

                    $return = apply_filters( 'custom_filter', array(

                        'text' => $text,
    
                        'link' => $link
    
                    ), (int) $total_items, $link, $text, $custom_title );
    
                }

            }

            

            return $return;



        }

        return $action;

    }



    public static function send_notification($user_field, $map_id, $entry) {

        $user_id = intval( str_replace("field_", "", $user_field) );


        if ( bp_is_active( 'notifications' ) ) {

            bp_notifications_add_notification( array(
                'user_id'           => $user_id,
                'item_id'           => $map_id,
                'secondary_item_id' => $entry['created_by'],
                'component_name'    => 'gf_buddy',
                'component_action'  => 'gf_buddy_action',
                'date_notified'     => bp_core_current_time(),
                'is_new'            => 1
            ) );    

        }

        

    }

    public static function get_user_display_name($user_id) {

        return bp_core_get_user_displayname($user_id);

    }



}