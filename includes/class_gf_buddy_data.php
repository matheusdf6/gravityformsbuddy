<?php

if ( ! defined( 'ABSPATH' ) ) {
    die();
}

global $wpdb;

define("GFBP_TABLE_NAME", $wpdb->prefix . 'gfbuddy_maps' );

abstract class GFBuddyData {

    public static function init() {

        global $wpdb;
        $table_name = GFBP_TABLE_NAME;

        $query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );
 
        if ( $wpdb->get_var( $query ) != $table_name ) {

            $charset_collate = $wpdb->get_charset_collate();

            $sql = "CREATE TABLE $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                feed_id mediumint(9) NOT NULL,
                form_id mediumint(9)  NOT NULL,
                entry_id mediumint(9) NOT NULL,
                msg varchar(200) DEFAULT '' NOT NULL,
                PRIMARY KEY  (id)
            ) $charset_collate;";
    
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
    
        }
        
    }

    public static function add_new_item($feed, $form, $entry, $message) {
        
        global $wpdb;

        $table_name = GFBP_TABLE_NAME;

        $wpdb->insert( 
            $table_name, 
            array( 
                'feed_id' => $feed, 
                'form_id' => $form, 
                'entry_id' => $entry, 
                'msg'  => $message,
            ) 
        );

        return $wpdb->insert_id;
        
    }

    public static function get_item($id) {
                
        global $wpdb;

        $table_name = GFBP_TABLE_NAME;

        $sql = $wpdb->prepare("SELECT feed_id, form_id, entry_id, msg FROM {$table_name} WHERE id = %d", $id);
        $results = $wpdb->get_results($sql, ARRAY_A);

        $return = array();
        foreach($results as $result) {
            $return = array(
                "form_id" => $result['form_id'],
                "feed_id" => $result['feed_id'],
                "entry_id" => $result['entry_id'],
                "message"   => $result['msg'],
            );
        }

        return $return;

    }

}