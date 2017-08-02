<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    all_in_one_rating
 * @subpackage all_in_one_rating/admin
 * @author     Multidots <wordpress@multidots.com>
 */
class all_in_one_rating_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_action( 'wp_ajax_rating_option_ajax', array($this,'ajax_request_for_post_rating_option_save') );		
		add_action( 'wp_ajax_rating_display_template_ajax_request', array($this,'ajax_request_for_display_post_rating_template_save') );
		add_action( 'wp_ajax_rating_display_default_template', array($this,'rating_display_template_ajax_request_for_default_template_fun') );
		
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );		
		//add_action( 'init', array( $this, 'enqueue_styles' ) );		

	}
	
	public function enqueue_scripts(){
	
	wp_enqueue_script( 'jquery-ui-dialog' );	
	wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/admin.js', array( 'jquery'), $this->version, false );
	wp_localize_script( 'ajax-script', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );	
	
	wp_register_style( 'admin_post_rating_css', plugin_dir_url( __FILE__ ) . 'css/admin_style.css', array('wp-jquery-ui-dialog'), $this->version, 'all');
	wp_enqueue_style( 'admin_post_rating_css');
	wp_enqueue_style( 'wp-pointer' );
	
	wp_enqueue_media();
    wp_enqueue_script('media-upload');
    wp_enqueue_script('my-admin-js');
    wp_enqueue_script( 'wp-pointer' );

	
	}	
	
	
	/**
	 * Add Extra Setting tab
	 *
	 * @since    1.0.0
	 */
    public function all_in_one_rating_admin_menu_own(){
    	
    	//add_menu_page( 'Rating', 'Post Rating', 'manage_options', 'rating_menu', 'rating_menu_page', plugins_url( $this->plugin_name.'/images/plugin-icon.png' ), 25 ); 
    	//add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );    	
    	//add_submenu_page( 'rating_menu', 'rating_option', 'Rating Options', 'manage_options', 'rating_option', 'rating_option_functiona_own' );
    	
    	add_menu_page( 'Rating', 'Rating Options', 'manage_options', 'rating_menu', 'rating_option_functiona_own', plugins_url( '/wp-category-tag-ratings/images/plugin-icon.png' ), 110 ); 
    	
    	add_submenu_page( 'rating_menu', 'display rating', 'Display Rating', 'manage_options', 'rating_display', 'display_rating_functiona_own' ); 
    	
    	
		require_once 'rating-admin-display.php';		
		//include('../post-rating-display.php');		
    }
    
    function ajax_request_for_post_rating_option_save() {
    	$update = 0;
      	if(!empty($_POST['rating_img_name'])){
      		update_option('rating_img_name',$_POST['rating_img_name']);
      		$update++;
      	}
      	if(!empty($_POST['google_rich'])){
      		update_option('google_rich',$_POST['google_rich']);
      		$update++;
      	}
      	if(!empty($_POST['total_rating'])){
      		update_option('total_rating',((int)$_POST['total_rating']));
      		$update++;
      	}
      	if(!empty($_POST['postratings_allow_to'])){
      		update_option('postratings_allow_to',$_POST['postratings_allow_to']);
      		$update++;
      	}
      	if(!empty($_POST['postratings_user_type'])){
      		update_option('postratings_user_type',$_POST['postratings_user_type']);
      		$update++;
      	}
      	if(!empty($_POST['rating_restric_day'])){
      		update_option('rating_restric_day',$_POST['rating_restric_day']);
      		$update++;
      	}
      	
      	if(!empty($_POST['rating_none'])){
      		update_option('rating_none',$_POST['rating_none']);
      		$update++;
      	}
      	if(!empty($_POST['rating_full'])){
      		update_option('rating_full',$_POST['rating_full']);
      		$update++;
      	}
      	if(!empty($_POST['rating_avg'])){
      		update_option('rating_avg',$_POST['rating_avg']);
      		$update++;
      	}
      	if(!empty($_POST['rating_hover'])){
      		update_option('rating_hover',$_POST['rating_hover']);
      		$update++;
      	}	
      	
      	if(!empty($_POST['AOI_custom_css'])){
      		update_option('AOI_custom_css',$_POST['AOI_custom_css']);
      		$update++;
      	}
      	if(isset($_POST['aio_rating_loader'])){
      		update_option('aio_rating_loader',$_POST['aio_rating_loader']);
      		$update++;
      	}
      	
      	
      	if($update > 0){
      		echo 'sucess';
      	}else{
      		echo 'error';
      	}
      	exit();
	}
    
	function ajax_request_for_display_post_rating_template_save(){
		$update = 0;
      	if(!empty($_POST['AOI_postratings_none_template'])){
      		update_option('AOI_postratings_none_template',$_POST['AOI_postratings_none_template']);
      		$update++;
      	}
      	if(!empty($_POST['AOI_all_ready_rate_template'])){
      		update_option('AOI_all_ready_rate_template',$_POST['AOI_all_ready_rate_template']);
      		$update++;
      	}
      	if(!empty($_POST['AOI_after_user_rating_template'])){
      		update_option('AOI_after_user_rating_template',$_POST['AOI_after_user_rating_template']);
      		$update++;
      	}
      	if($update > 0){
      		echo 'sucess';
      	}else{
      		echo 'error';
      	}
      	exit();
      		
	}
	
	function rating_display_template_ajax_request_for_default_template_fun(){
		// all default template set here
		$update = 0;
      	if(!empty($_POST['AOI_default_template'])){
      		
      				
      		$AOI_postratings_none_template_default = get_option('AOI_postratings_none_template_default');
      		if(!empty($AOI_postratings_none_template_default)) {
      			update_option('AOI_postratings_none_template',$AOI_postratings_none_template_default);
      			$update++;
      		}
			
      		$AOI_all_ready_rate_template_default = get_option('AOI_all_ready_rate_template_default');
      		if(!empty($AOI_all_ready_rate_template_default)) {
      			update_option('AOI_all_ready_rate_template',$AOI_all_ready_rate_template_default);
      			$update++;
      		}
			$AOI_after_user_rating_template_default = get_option('AOI_after_user_rating_template_default');
			if(!empty($AOI_after_user_rating_template_default)) {
      			update_option('AOI_after_user_rating_template',$AOI_after_user_rating_template_default);
      			$update++;      		
			}     		
      		
      	}
      	if($update > 0){
      		echo 'sucess';
      	}else{
      		echo 'error';
      	}
      	exit();
	}
	
	public function wp_add_plugin_userfn() { 
		global $wpdb;
    	$email_id= $_POST['email_id'];
    	$log_url = $_SERVER['HTTP_HOST'];
    	$cur_date = date('Y-m-d');
    	$url = 'http://www.multidots.com/store/wp-content/themes/business-hub-child/API/wp-add-plugin-users.php';
    	$response = wp_remote_post( $url, array('method' => 'POST',
    	'timeout' => 45,
    	'redirection' => 5,
    	'httpversion' => '1.0',
    	'blocking' => true,
    	'headers' => array(),
    	'body' => array('user'=>array('user_email'=>$email_id,'plugin_site' => $log_url,'status' => 1,'plugin_id' => '13','activation_date'=>$cur_date)),
    	'cookies' => array()));
		update_option('ctr_plugin_notice_shown', 'true');
    }
     public function hide_subscribe_ctrfn() { 
     	global $wpdb;
    	$email_id= $_POST['email_id'];
    	update_option('ctr_plugin_notice_shown', 'true');
    } 
    
    // Function for welcome screen 
    
    public function welcome_wp_category_tag_ratings_screen_do_activation_redirect  ( ){ 
    	
    	if (!get_transient('_wp_category_tag_rating_welcome_screen')) {
			return;
		}
		
		// Delete the redirect transient
		delete_transient('_wp_category_tag_rating_welcome_screen');

		// if activating from network, or bulk
		if (is_network_admin() || isset($_GET['activate-multi'])) {
			return;
		}
		// Redirect to extra cost welcome  page
		wp_safe_redirect(add_query_arg(array('page' => 'wp-category-tag-ratings&tab=about'), admin_url('index.php')));
    
    }
    
    public  function welcome_pages_screen_wp_category_tag_ratings ( ){ 
    	add_dashboard_page ( 
		'Wp Category Tag Ratings Dashboard', 'Wp Category Tag Ratings Dashboard', 'read', 'wp-category-tag-ratings', array(&$this, 'welcome_screen_content_wp_category_tag_rating')
		);
    }
    
   public function welcome_screen_wp_category_tag_ratings_remove_menus ( ){ 
    	
    	remove_submenu_page( 'index.php', 'wp-category-tag-ratings' );
    }
    
    
    public function welcome_screen_content_wp_category_tag_rating ( ) {  
    		
    	$current_user = wp_get_current_user();
		if (!get_option('ctr_plugin_notice_shown')) {
			 echo '<div id="ctr_dialog" title="Basic dialog"><p>Subscribe for latest plugin update and get notified when we update our plugin and launch new products for free! </p> <p><input type="text" id="txt_user_sub_ctr" class="regular-text" name="txt_user_sub_ctr" value="'.$current_user->user_email.'"></p></div>';
		}
    	
    	?>
    	
    	<div class="wrap about-wrap">
            <h1 style="font-size: 2.1em;"><?php printf(__('Welcome to Wp Category Tag Ratings', 'wp-category-tag-ratings')); ?></h1>

            <div class="about-text woocommerce-about-text">
        <?php
        $message = '';
        printf(__('%s Very Simple, easy, developer-friendly rating plugin which can be used for pages, posts, categories & tags.', 'wp-category-tag-ratings'), $message, $this->version);
        ?>
                <img class="version_logo_img" src="<?php echo plugin_dir_url(__FILE__) . 'images/wp-category-tag-ratings.png'; ?>">
            </div>

        <?php
        $setting_tabs_wc = apply_filters('wp_category_tag_ratings_setting_tab', array("about" => "Overview", "other_plugins" => "Checkout our other plugins" ));
        $current_tab_wc = (isset($_GET['tab'])) ? $_GET['tab'] : 'general';
        $aboutpage = isset($_GET['page'])
        ?>
            <h2 id="woo-extra-cost-tab-wrapper" class="nav-tab-wrapper">
            <?php
            foreach ($setting_tabs_wc as $name => $label)
            echo '<a  href="' . home_url('wp-admin/index.php?page=wp-category-tag-ratings&tab=' . $name) . '" class="nav-tab ' . ( $current_tab_wc == $name ? 'nav-tab-active' : '' ) . '">' . $label . '</a>';
            ?>
            </h2>
                <?php
                foreach ($setting_tabs_wc as $setting_tabkey_wc => $setting_tabvalue) {
                	switch ($setting_tabkey_wc) {
                		case $current_tab_wc:
                			do_action('wp_category_tag_ratings_' . $current_tab_wc);
                			break;
                	}
                }
                ?>
            <hr />
            <div class="return-to-dashboard">
                <a href="<?php echo home_url('/wp-admin/admin.php?page=rating_menu'); ?>"><?php _e('Go to Wp Category Tag Ratings Settings', 'wp-category-tag-ratings'); ?></a>
            </div>
        </div>
    <?php } 
    
    public function wp_category_tag_ratings_about () { ?>
    	 <div class="changelog">
            </br>
           	<style type="text/css">
				p.wp_category_tag_ratings_overview {max-width: 100% !important;margin-left: auto;margin-right: auto;font-size: 15px;line-height: 1.5;}.wp_category_tag_ratings_overview_content_ul ul li {margin-left: 3%;list-style: initial;line-height: 23px;}
			</style>  
            <div class="changelog about-integrations">
                <div class="wc-feature feature-section col three-col">
                    <div>
                        <p class="wp_category_tag_ratings_overview"><?php _e('The `Wp-Category-Tag-Ratings` will be helpful for applying rating options specially on categories, tags. Developer is also able to use own custom image of rating. User will be allow to rate every where admin wants rating and also User will be able to see average ratings.', 'wp-category-tag-ratings'); ?></p>
                        
                        <p class="wp_category_tag_ratings_overview"><?php _e('Plugin will simply generate shortcode and we can use it wherever we want to display ratings.', 'wp-category-tag-ratings'); ?></p>
                        
                    </div>
                </div>
            </div>
        </div>
    
    <?php } 
    
    public function wp_category_tag_ratings_other_plugins ( ) {  
    	
    	global $wpdb;
         $url = 'http://www.multidots.com/store/wp-content/themes/business-hub-child/API/checkout_other_plugin.php';
    	 $response = wp_remote_post( $url, array('method' => 'POST',
    	'timeout' => 45,
    	'redirection' => 5,
    	'httpversion' => '1.0',
    	'blocking' => true,
    	'headers' => array(),
    	'body' => array('plugin' => 'advance-flat-rate-shipping-method-for-woocommerce'),
    	'cookies' => array()));
    	
    	$response_new = array();
    	$response_new = json_decode($response['body']);
		$get_other_plugin = maybe_unserialize($response_new);
		
		$paid_arr = array();
		?>

        <div class="plug-containter">
        	<div class="paid_plugin">
        	<h3>Paid Plugins</h3>
	        	<?php foreach ($get_other_plugin as $key=>$val) { 
	        		if ($val['plugindesc'] =='paid') {?>
	        			
	        			
	        		   <div class="contain-section">
	                <div class="contain-img"><img src="<?php echo $val['pluginimage']; ?>"></div>
	                <div class="contain-title"><a target="_blank" href="<?php echo $val['pluginurl'];?>"><?php echo $key;?></a></div>
	            </div>	
	        			
	        			
	        		<?php }else {
	        			
	        			$paid_arry[$key]['plugindesc']= $val['plugindesc'];
	        			$paid_arry[$key]['pluginimage']= $val['pluginimage'];
	        			$paid_arry[$key]['pluginurl']= $val['pluginurl'];
	        			$paid_arry[$key]['pluginname']= $val['pluginname'];
	        		
	        	?>
	        	
	         
	            <?php } }?>
           </div>
           <?php if (isset($paid_arry) && !empty($paid_arry)) {?>
           <div class="free_plugin">
           	<h3>Free Plugins</h3>
                <?php foreach ($paid_arry as $key=>$val) { ?>  	
	            <div class="contain-section">
	                <div class="contain-img"><img src="<?php echo $val['pluginimage']; ?>"></div>
	                <div class="contain-title"><a target="_blank" href="<?php echo $val['pluginurl'];?>"><?php echo $key;?></a></div>
	            </div>
	            <?php } }?>
           </div>
          
        </div>
    
    <?php } 
    
    public function wp_category_tag_ratings_pointers_footer () { 
    	$admin_pointers = wp_category_tag_ratings_admin_pointers();
	    ?>
	    <script type="text/javascript">
	        /* <![CDATA[ */
	        ( function($) {
	            <?php
	            foreach ( $admin_pointers as $pointer => $array ) {
	               if ( $array['active'] ) {
	                  ?>
	            $( '<?php echo $array['anchor_id']; ?>' ).pointer( {
	                content: '<?php echo $array['content']; ?>',
	                position: {
	                    edge: '<?php echo $array['edge']; ?>',
	                    align: '<?php echo $array['align']; ?>'
	                },
	                close: function() {
	                    $.post( ajaxurl, {
	                        pointer: '<?php echo $pointer; ?>',
	                        action: 'dismiss-wp-pointer'
	                    } );
	                }
	            } ).pointer( 'open' );
	            <?php
	         }
	      }
	      ?>
	        } )(jQuery);
	        /* ]]> */
	    </script>
	<?php
    	
    } 
    
  
    

} 

function  wp_category_tag_ratings_admin_pointers () { 

	$dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
    $version = '1_0'; // replace all periods in 1.0 with an underscore
    $prefix = 'wp_category_tag_ratings_admin_pointers' . $version . '_';

    $new_pointer_content = '<h3>' . __( 'Welcome to WP Category Tag Ratings' ) . '</h3>';
    $new_pointer_content .= '<p>' . __( 'Very Simple, easy, developer-friendly rating plugin which can be used for pages, posts, categories & tags.' ) . '</p>';

    return array(
        $prefix . 'wp_category_tag_ratings_admin_pointers' => array(
            'content' => $new_pointer_content,
            'anchor_id' => '#toplevel_page_rating_menu',
            'edge' => 'left',
            'align' => 'left',
            'active' => ( ! in_array( $prefix . 'wp_category_tag_ratings_admin_pointers', $dismissed ) )
        )
    );
    
}

