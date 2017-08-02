<?php
/**
 * @link              http://www.multidots.com/
 * @since             1.0.0
 * @package           all_in_one_rating
 *
 * @wordpress-plugin
 * Plugin Name:       WordPress Category Tag Rating
 * Plugin URI:        http://www.multidots.com/
 * Description:       Very Simple, easy, developer-friendly rating plugin which can be used for pages, posts, categories & tags.
 * Version:           1.0.4
 * Author:            Multidots
 * Author URI:        http://www.multidots.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-category-tag-ratings
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * This code will runs at plugin activation time
 * This action is will includes/class-all-in-one-rating-active.php
 */
function activate_all_in_one_rating_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-active-plugin.php';
	all_in_one_rating_active::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-all-in-one-rating-deactivator.php
 */
function deactivate_all_in_one_rating_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-deactive-plugin.php';
	all_in_one_rating_plugin_deactive::deactivate();
}

register_activation_hook( __FILE__, 'activate_all_in_one_rating_plugin' );
register_deactivation_hook( __FILE__, 'deactivate_all_in_one_rating_plugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-all-in-one-rating.php';

require plugin_dir_path( __FILE__ ) . 'includes/all-in-one-rating-function.php';	


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function All_In_One_Rating_plugin_Own() {
	
	$plugin_obj = new All_In_One_Rating();
	$plugin_obj->run();
}

function AIO_Rating($ratings_post_id = 0){
	
	if('custom' == get_option('rating_img_name') ){
 		$rating_none_img = get_option('rating_none');
		$rating_full_img = get_option('rating_full');
		$rating_avg_img = get_option('rating_avg');
		$rating_hover_img = get_option('rating_hover');
 	}else{
 		$img_path = plugins_url('/images/rating/', __FILE__ ).'star/';
		$rating_none_img = $img_path.'rating_none.png';	
		$rating_full_img = $img_path.'rating_full.png';
		$rating_avg_img = $img_path.'rating_avg.png';
		$rating_hover_img = $img_path.'rating_hover.png';
 	}
		
	wp_enqueue_style('wp-all_in_one_post_ratings', plugins_url('all-in-one-post-ratings-css.css',__FILE__), false, '1.0.0', 'all');	
	wp_enqueue_script('wp-all_in_one_post_ratings_js', plugins_url('all-in-one-post-ratings-js.js',__FILE__),'','1.0.0', false);
	wp_localize_script('wp-all_in_one_post_ratings_js', 'aio_rating', array(		
		'image' => get_option('rating_img_name'),
		'ajax_url' => admin_url('admin-ajax.php'),
		'max_rating' => (int) get_option('total_rating'),
		'rating_none' =>$rating_none_img,
		'rating_full' =>$rating_full_img,
		'rating_avg' =>$rating_avg_img,
		'rating_hover' =>$rating_hover_img,
	));	

	require plugin_dir_path( __FILE__ ) . 'post-rating-display.php';
}


All_In_One_Rating_plugin_Own();

// [aio_rating id=1]
function aio_rating_shortcode_func( $atts ) {
    if(empty($atts['id'])){
    	AIO_Rating();
    }else{
    	AIO_Rating($atts['id']);
    }
    
}

add_shortcode( 'aio_rating', 'aio_rating_shortcode_func' );

add_action( 'wp_ajax_user_rating_data', 'user_given_rating_to_post');
add_action('wp_ajax_nopriv_user_rating_data', 'user_given_rating_to_post');
//add_action('wp_enqueue_scripts', 'all_in_one_ratings_scripts',20);