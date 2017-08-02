<?php

/**
 * Fired during All in one rating plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    all_in_one_rating
 * @subpackage all_in_one_rating/includes
 * @author     Multidots <wordpress@multidots.com>
 */
class all_in_one_rating_active {

	
	public static function activate() { 
			
			global $wpdb;
			set_transient( '_wp_category_tag_rating_welcome_screen', true, 30 );
		
			$table_name = $wpdb->prefix . "all_in_one_post_ratings";
			$sql = "CREATE TABLE $table_name (
  					id int(11) NOT NULL AUTO_INCREMENT,
					postid int(11) NOT NULL,					
					rating int(2) NOT NULL,
					timestamp datetime NOT NULL,
					ip varchar(40) NOT NULL,
					host varchar(200) NOT NULL,
					username varchar(50) NOT NULL,
					userid int(10) NOT NULL DEFAULT '0',
					PRIMARY KEY (id)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
						
			if(!get_option('AOI_postratings_none_template')) update_option('AOI_postratings_none_template','<<%AIO_RATING_IMAGES%>><br>( No Ratings Yet )');
			
			if(!get_option('AOI_all_ready_rate_template')) update_option('AOI_all_ready_rate_template','<<%AIO_RATING_IMAGES%>><br>( <<%AIO_TOTAL_NO_RAT%>> votes, average: <<%AIO_RATINGS_AVERAGE%>> out of <<%AIO_TOTAL_RATINGS%>> )');
			
			if(!get_option('AOI_after_user_rating_template')) update_option('AOI_after_user_rating_template','<<%AIO_RATING_IMAGES%>><br>( <<%AIO_TOTAL_NO_RAT%>> votes, average: <<%AIO_RATINGS_AVERAGE%>> out of <<%AIO_TOTAL_RATINGS%>> )');
			
			update_option('AOI_postratings_none_template_default','<<%AIO_RATING_IMAGES%>><br>( No Ratings Yet )');
			update_option('AOI_all_ready_rate_template_default','<<%AIO_RATING_IMAGES%>><br>( <<%AIO_TOTAL_NO_RAT%>> votes, average: <<%AIO_RATINGS_AVERAGE%>> out of <<%AIO_TOTAL_RATINGS%>> )');
			update_option('AOI_after_user_rating_template_default','<<%AIO_RATING_IMAGES%>><br>( <<%AIO_TOTAL_NO_RAT%>> votes, average: <<%AIO_RATINGS_AVERAGE%>> out of <<%AIO_TOTAL_RATINGS%>> )');
			
			if(!get_option('rating_img_name'))	update_option('rating_img_name','star');
			
			if(!get_option('google_rich')) update_option('google_rich','on');
			
			if(!get_option('total_rating')) update_option('total_rating',5);
			
			if(!get_option('postratings_allow_to')) update_option('postratings_allow_to',3);
			
			if(!get_option('postratings_user_type')) update_option('postratings_user_type', 2);
			
			if(!get_option('rating_restric_day')) update_option('rating_restric_day',1);
			
			
		}
}