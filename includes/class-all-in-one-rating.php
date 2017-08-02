<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.1
 * @package    all_in_one_rating
 * @subpackage all_in_one_rating/includes
 * @author     Multidots <wordpress@multidots.com>
 */
class All_In_One_Rating {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      all_in_one_rating_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'all-in-one-rating';
		$this->version = '1.0.0';

		$this->auto_loaded();
		//$this->set_locale();
		$this->define_admin_hooks();
		//$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - all_in_one_rating_Loader. Orchestrates the hooks of the plugin.
	 * - all_in_one_rating_i18n. Defines internationalization functionality.
	 * - all_in_one_rating_Admin. Defines all hooks for the admin area.
	 * - all_in_one_rating_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function auto_loaded() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-all-in-one-rating-loader.php';
		

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-all-in-one-rating-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		//require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-all-in-one-rating-public.php';

		$this->loader = new all_in_one_rating_Loader();

	}


	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new all_in_one_rating_Admin( $this->get_plugin_name(), $this->get_version() );

		//$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		//$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		//$this->loader->add_action('admin_init', $plugin_admin, 'all_in_one_rating_admin_own');
		$this->loader->add_action('admin_menu', $plugin_admin, 'all_in_one_rating_admin_menu_own');
		
		$this->loader->add_action( 'wp_ajax_add_plugin_user_ctr', $plugin_admin, 'wp_add_plugin_userfn' );
		$this->loader->add_action( 'wp_ajax_hide_subscribe_ctr', $plugin_admin, 'hide_subscribe_ctrfn' );
		
		//$this->loader->add_action('wp_ajax_example_ajax_request', $plugin_admin, 'example_ajax_request');
		
		$this->loader->add_action('admin_init', $plugin_admin, 'welcome_wp_category_tag_ratings_screen_do_activation_redirect');
        $this->loader->add_action('admin_menu', $plugin_admin, 'welcome_pages_screen_wp_category_tag_ratings');
        $this->loader->add_action('wp_category_tag_ratings_about', $plugin_admin, 'wp_category_tag_ratings_about');
        $this->loader->add_action('wp_category_tag_ratings_other_plugins', $plugin_admin, 'wp_category_tag_ratings_other_plugins');
        $this->loader->add_action('admin_print_footer_scripts', $plugin_admin, 'wp_category_tag_ratings_pointers_footer');
        $this->loader->add_action('admin_menu', $plugin_admin, 'welcome_screen_wp_category_tag_ratings_remove_menus', 999 );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new all_in_one_rating_Public( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		
		/*if (in_array( 'woocommerce/woocommerce.php',apply_filters('active_plugins',get_option('active_plugins')))) {
			$this->loader->add_filter( 'woocommerce_paypal_args', $plugin_public, 'paypal_bn_code_filter_wp_category_tag_rating',99,1 );
		}*/
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    all_in_one_rating_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
