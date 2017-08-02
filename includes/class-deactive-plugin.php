<?php

/**
 * Fired during plugin deactive.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    all_in_one_rating
 * @subpackage all_in_one_rating/includes
 * @author     Multidots <wordpress@multidots.com>
 */
class all_in_one_rating_plugin_deactive {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		global $wpdb;
		
		$table_name = $wpdb->prefix . "post_ratings";
//		$sql = "DROP TABLE $table_name;";	
//	    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
//		$wpdb->query( $sql );
	}

}
