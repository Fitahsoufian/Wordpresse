<?php
// CONSTANTS
$theme = wp_get_theme();
define('INGENIOUS_THEME_NAME', $theme->get( 'Name' ));
define( 'INGENIOUS_THEME_DIR', get_template_directory() );
define( 'INGENIOUS_THEME_URI', get_template_directory_uri() );
define( 'INGENIOUS_BEFORE_CE_TITLE', '<div class="ce_title">' );
define( 'INGENIOUS_AFTER_CE_TITLE', '</div>' );
define( 'INGENIOUS_V_SEP', '<span class="v_sep"></span>' );
$color_check = esc_attr( ingenious_get_option( 'theme_color' ) );
$theme_custom_color_check = !empty( $color_check ) ? $color_check : '#59ab66';
if ( !defined( 'INGENIOUS_THEME_COLOR' ) ){
	define( 'INGENIOUS_THEME_COLOR', $theme_custom_color_check );
}
$helper_color_check = esc_attr( ingenious_get_option( 'theme_helper_color' ) );
$theme_custom_helper_color_check = !empty( $helper_color_check ) ? $helper_color_check : '#ff6c3a';
if ( !defined( 'INGENIOUS_THEME_HELPER_COLOR' ) ){
	define( 'INGENIOUS_THEME_HELPER_COLOR', $theme_custom_helper_color_check );
}
define( 'INGENIOUS_THEME_HEADER_BG_COLOR', '#272b31' );
define( 'INGENIOUS_THEME_HEADER_FONT_COLOR', '#ffffff' );
define( 'INGENIOUS_THEME_FOOTER_BG_COLOR', '#353535' );
define( 'INGENIOUS_MB_PAGE_LAYOUT_KEY', 'cws_mb_post' );
// \CONSTANTS

# TEXT DOMAIN
load_theme_textdomain( 'ingenious', get_template_directory() .'/languages' );
# \TEXT DOMAIN

// INCLUDES
// config
require_once( trailingslashit( get_template_directory() ) . 'includes/config/scg.php' );
// \config
// core
require_once( trailingslashit( get_template_directory() ) . 'includes/core/ingenious_thumb.php' );
require_once get_template_directory() . '/includes/core/class-tgm-plugin-activation.php';
// \core

// modules
require_once( trailingslashit( get_template_directory() ) . 'includes/modules/ingenious_blog.php' );
require_once( trailingslashit( get_template_directory() ) . 'includes/modules/ingenious_breadcrumbs.php' );
require_once( trailingslashit( get_template_directory() ) . 'includes/modules/ingenious_comments.php' );
require_once( trailingslashit( get_template_directory() ) . 'includes/modules/ingenious_portfolio.php' );
require_once( trailingslashit( get_template_directory() ) . 'includes/modules/ingenious_staff.php' );
require_once( trailingslashit( get_template_directory() ) . 'includes/modules/ingenious_search.php' );

// \modules
// \INCLUDES

function ingenious_clear_closing_prgs ( $content ){
	$match = preg_match( "#^</p>#", $content, $matches, PREG_OFFSET_CAPTURE );
	if ( $match ){
		$match_data = $matches[0];
		$content = substr_replace( $content, "", $match_data[1], strlen( $match_data[0] ) );
	}
	return $content;
}
add_filter( 'the_content', 'ingenious_clear_closing_prgs', 11 );

// Check plugin's version
function cws_check_plugin_version ( $plugin ){

	$opt_res = get_option('cws_plugin_ver', true);

	if (!empty($opt_res['data']) ){
		$cws_chk_ver = array();
		wp_parse_str( $opt_res['data'], $cws_chk_ver );
	}

	if(!empty($cws_chk_ver[$plugin])){
		return $cws_chk_ver[$plugin];
	} else {
		switch ($plugin) {
			case 'revslider':
				$cws_chk_ret = "5.4.8";
				break;
			case 'js_composer':
				$cws_chk_ret = "5.7";
				break;			
			default:
				break;
		}
		return $cws_chk_ret;
	}
}
// \Check plugin's version

add_action( 'tgmpa_register', 'ingenious_register_required_plugins' );

function ingenious_register_required_plugins (){
	$plugins = array(
		array(
			'name'					=> esc_html__( 'Ingenious Shortcodes', 'ingenious' ), // The plugin name
			'slug'					=> 'ingenious-shortcodes', // The plugin slug (typically the folder name)
			'source'				=> get_template_directory() . '/plugins/ingenious-shortcodes.zip', // The plugin source
			'required'				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.0.4',
			'force_activation'		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'					=> esc_html__( 'CWS Portfolio & Staff', 'ingenious' ), // The plugin name
			'slug'					=> 'cws-portfolio-staff', // The plugin slug (typically the folder name)
			'source'				=> get_template_directory() . '/plugins/cws-portfolio-staff.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.1.1',
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'					=> esc_html__( 'CWS MegaMenu', 'ingenious' ), // The plugin name
			'slug'					=> 'cws-megamenu', // The plugin slug (typically the folder name)
			'source'				=> get_template_directory() . '/plugins/cws-megamenu.zip', // The plugin source
			'required'				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.1.1',
			'force_activation'		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'					=> esc_html__( 'CWS Demo Importer', 'ingenious' ), // The plugin name
			'slug'					=> 'cws-demo-importer', // The plugin slug (typically the folder name)
			'source'				=> get_template_directory() . '/plugins/cws-demo-importer.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.2.8', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'					=> esc_html__('CWS Flaticons','ingenious'), // The plugin name
			'slug'					=> 'cws-flaticons', // The plugin slug (typically the folder name)
			'source'				=> get_template_directory() . '/plugins/cws-flaticons.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.1.3', // E.g. 1.1.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'					=> esc_html__('CWS SVGicons','ingenious'), // The plugin name
			'slug'					=> 'cws-svgicons', // The plugin slug (typically the folder name)
			'source'				=> get_template_directory() . '/plugins/cws-svgicons.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.5.4', // E.g. 1.4.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'					=> esc_html__('CWS Theme Options','ingenious'), // The plugin name
			'slug'					=> 'cws-to', // The plugin slug (typically the folder name)
			'source'				=> get_template_directory() . '/plugins/cws-to.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.5.6', // E.g. 1.4.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'					=> esc_html__( 'WPBakery Visual Composer', 'ingenious' ), // The plugin name
			'slug'					=> 'js_composer', // The plugin slug (typically the folder name)
			'source'				=> 'http://up.cwsthemes.com/plugins/js_composer.zip', // The plugin source
			'required'				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> cws_check_plugin_version('js_composer'), // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation'		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'			=> 'http://up.cwsthemes.com/plugins/', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'					=> esc_html__('Revolution Slider','ingenious'), // The plugin name
			'slug'					=> 'revslider', // The plugin slug (typically the folder name)
			'source'				=> 'http://up.cwsthemes.com/plugins/revslider.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> cws_check_plugin_version('revslider'),
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> 'http://up.cwsthemes.com/plugins/', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'					=> esc_html__( 'Contact Form 7', 'ingenious' ), // The plugin name
			'slug'					=> 'contact-form-7', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
		),
		array(
			'name'					=> esc_html__( 'WP Google Maps', 'ingenious' ), // The plugin name
			'slug'					=> 'wp-google-maps', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
		),
		array(
			'name'					=> esc_html__( 'oAuth Twitter Feed for Developers', 'ingenious' ), // The plugin name
			'slug'					=> 'oauth-twitter-feed-for-developers', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
		),
	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       		=> 'ingenious',         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_slug' 		=> 'themes.php', 				// Default parent menu slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
	);

	tgmpa( $plugins, $config );

}

		global $wp_filesystem;
		if(empty( $wp_filesystem )) {
			require_once( ABSPATH .'/wp-admin/includes/file.php' );
			WP_Filesystem();
		}
class Ingenious_Theme_Features{

	protected static $cws_theme_config;

	private function ingenious_assign_constants() {
		self::$cws_theme_config = array(
			'admin_pages' => array('widgets.php', 'edit-tags.php', 'term.php'), // pages where cwsfw should be initialized
		);
	}

	public function get_theme_config($name) {
		if (isset(self::$cws_theme_config[$name])) {
			return self::$cws_theme_config[$name];
		}
		return null;
	}

	public function __construct (){
		// Check if JS_Composer is active
		$this->ingenious_assign_constants();
		// Makes sure the plugin is defined before trying to use it
		if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
		    require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
		}

		if (class_exists('Vc_Manager')) {
			// update fix
			$vc_man = Vc_Manager::getInstance();
			$vc_man->disableUpdater(true);
			if (!isset($_COOKIE['vchideactivationmsg_vc11'])) {
				setcookie('vchideactivationmsg_vc11', WPB_VC_VERSION);
			}
			// \update fix
			require_once( get_template_directory() . '/vc/ingenious_vc_config.php' ); // JS_Composer Theme config file
		}
		// Load Woocommerce Extension
		require_once( get_template_directory() . '/woocommerce/wooinit.php' ); // WooCommerce Shop ini file
		// Check if WPML is active
		if ( ingenious_check_for_plugin('sitepress-multilingual-cms/sitepress.php') ) {
			ingenious_wpml_ext_init();
		}
		if ( class_exists( 'Ingenious_SCG' ) ){
			new Ingenious_SCG;
		}
		$this->ingenious_theme_options_customizer_init ();
		$this->ingenious_set_content_width ();
		add_action( 'ingenious_header_meta', array( $this, 'ingenious_default_header_meta' ) );
		add_action( 'after_setup_theme', array( $this, 'ingenious_after_setup' ) );
		add_action( 'wp', array( $this, 'ingenious_page_meta_vars' ) );
		add_filter( 'wp_title', array( $this, 'ingenious_wp_title_filter' ) );
		add_filter('pre_set_site_transient_update_themes', array($this, 'ingenious_check_for_update') );
		add_action('fw_enqueue_scripts', array($this, 'ingenious_fw_admin_init' ) );
		add_action( 'wp_head', array( $this, 'ingenious_render_site_icon' ) );
		add_filter( 'wp_get_nav_menu_items', array( $this, 'ingenious_split_nav_menu' ) );
		add_filter( 'walker_nav_menu_start_el', array( $this, 'ingenious_nav_menu_pointer' ), 10, 2 );
		add_filter( 'wp_nav_menu_items', array( $this, 'ingenious_sandwich_menu_switcher' ), 10 ,2 );
		add_filter( 'wp_nav_menu_args', array( $this, 'ingenious_sandwich_menu_class' ) );
		add_filter( 'widget_title', array( $this, 'ingenious_wrap_widget_title' ), 11, 3 );
		add_filter('wp_list_categories', array($this, 'ingenious_custom_categories_postcount_filter'));
		add_action( 'wp_enqueue_scripts', array( $this, 'ingenious_register_reset_styles' ), 1 );
		add_action( 'wp_enqueue_scripts', array( $this, 'ingenious_register_theme_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'ingenious_enqueue_main_theme_stylesheet' ), 11 );
		add_action( 'wp_enqueue_scripts', array( $this, 'ingenious_sandwich_menu_animation' ), 11 );
		add_action( 'wp_enqueue_scripts', array( $this, 'ingenious_load_youtube_api' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'ingenious_register_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'ingenious_define_ajaxurl' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'ingenious_localize_data' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'ingenious_enqueue_theme_stylesheet' ), 999 );
		add_action( 'admin_enqueue_scripts', array( $this, 'ingenious_register_admin_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'ingenious_register_admin_styles' ) );
	}

	public function ingenious_fw_admin_init( $hook ) {
		global $typenow;		
		if($typenow != 'product'){		
			wp_enqueue_script('select2-js', get_template_directory_uri() . '/includes/core/assets/js/select2/select2.js', array('jquery') );
			wp_enqueue_style('select2-css', get_template_directory_uri() . '/includes/core/assets/js/select2/select2.css', false, '2.0.0' );
		}
	}

# UPDATE THEME
	public function ingenious_check_for_update($transient) {
		if (empty($transient->checked)) { return $transient; }

		$theme_pc = ingenious_get_option( '_theme_purchase_code' );
		if (empty($theme_pc)) {
			add_action( 'admin_notices', array($this, 'ingenious_an_purchase_code') );
		}

		$result = wp_remote_get('http://up.cwsthemes.com/products-updater.php?pc=' . $theme_pc . '&tname=' . 'ingenious');
		if (!is_wp_error( $result ) ) {
			if (200 == $result['response']['code'] && 0 != strlen($result['body']) ) {
				$resp = json_decode($result['body'], true);
				$h = isset( $resp['h'] ) ? (float) $resp['h'] : 0;
				$theme = wp_get_theme(get_template());
				if ( version_compare( $theme->get('Version'), $resp['new_version'], '<' ) ) {
					$transient->response['ingenious'] = $resp;
				}
				// request and save plugins info
				$opt_res = wp_remote_get('http://up.cwsthemes.com/plugins/update.php', array( 'timeout' => 1));
				update_option('cws_plugin_ver', array('data' => $opt_res['body'], 'lasttime' => date('U')));
				// end of request and save plugins info
			} else {
				unset($transient->response['ingenious']);
			}
		}
		return $transient;
	}


	public function ingenious_an_purchase_code() {
		$ingenious_theme = wp_get_theme();
		echo "<div class='update-nag'>" . esc_html( $ingenious_theme->get( 'Name' ) ) . esc_html__( ' theme notice: Please insert your Item Purchase Code in Theme Options to get the latest theme updates!', 'ingenious' ) .'</div>';
	}
// \UPDATE THEME

	public function ingenious_default_header_meta (){
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php
	}

	public function ingenious_theme_options_customizer_init (){
		if ( is_customize_preview() ) {
			if ( isset( $_POST['wp_customize'] ) && $_POST['wp_customize'] == "on" ) {
				if (strlen($_POST['customized']) > 10) {
					global $cwsfw_settings;
					global $cwsfw_mb_settings;
					$post_values = json_decode( stripslashes_deep( $_POST['customized'] ), true );
					if (isset($post_values['cwsfw_settings'])) {
						$cwsfw_settings = $post_values['cwsfw_settings'];
					}
					if (isset($post_values['cwsfw_mb_settings'])) {
						$cwsfw_mb_settings = $post_values['cwsfw_mb_settings'];
					}
				}
			}
		}
	}

	public function ingenious_set_content_width (){
		if ( ! isset( $content_width ) ) {
			$content_width = 600;
		}
	}

	public function ingenious_wrap_widget_title ( $title, $instance = array(), $id_base = "" ){
		if ( $id_base == "rss" && isset( $instance['url'] ) && !empty( $instance['url'] ) ){
			return $title;
		}
		else{
			return !empty( $title ) ? "<span>$title</span>" : $title;
		}
	}

	public function ingenious_custom_categories_postcount_filter ($count) {
		$count = str_replace('</a> (', '<span class="post_count">(', $count);
		$count = str_replace(')', ')</span> </a>', $count);
		return $count;
	}

	public function ingenious_enqueue_theme_stylesheet () {
		wp_enqueue_style( 'style', get_stylesheet_uri() );
	}

	public function ingenious_after_setup (){
		add_theme_support( 'widgets' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );
		add_theme_support( 'automatic-feed-links' );
		$bg_defaults = array(
			'default-color'				=> '#fafafa'
		);
		add_theme_support( 'custom-background', $bg_defaults );
		register_nav_menus( array(
			'primary' => 'Primary Menu',
			'secondary' => 'Secondary Menu'
		));
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		// Add Gutenberg Compatibility
		add_theme_support( 'align-wide' );
	}

	public function ingenious_wp_title_filter ( $title_text, $sep ){
		$site_name = get_bloginfo( 'name' );
		$site_tagline = get_bloginfo( 'description' );
		if ( is_home() ){
			$title_text = $site_name . $sep . $site_tagline;
		}
		else{
			$title_text .= $site_name;
		}
		return $title_text;
	}

	public function ingenious_render_site_icon (){
		if ( !function_exists( 'wp_site_icon' ) ){
			$site_icon_id = get_option( 'site_icon' );
			if ( !empty( $site_icon_id ) ){
				echo "<link rel='icon' href='" . esc_url(wp_get_attachment_image_src( $site_icon_id, array( 32, 32 ) ) ). "' sizes='32x32' />";
				echo "<link rel='icon' href='" . esc_url(wp_get_attachment_image_src( $site_icon_id, array( 192, 192 ) ) ). "' sizes='192x192' />";
				echo "<link rel='apple-touch-icon-precomposed' href='" . esc_url(wp_get_attachment_image_src( $site_icon_id, array( 180, 180 ) ) ). "' />";
				echo "<link rel='msapplication-TileImage' href='" . esc_url(wp_get_attachment_image_src( $site_icon_id, array( 270, 270 ) ) ). "' />";
			}
		}
	}
	public function ingenious_split_nav_menu ( $items ){
		if ( is_admin() ) return $items;
		$top_level_items = array();
		for ( $i = 0; $i < count( $items ); $i++ ){
			$item = &$items[$i];
			if ( $item->menu_item_parent == '0' ){
				array_push( $top_level_items, $item );
			}
		}
		$top_level_items_count = count( $top_level_items );
		for ( $i = ceil( $top_level_items_count / 2 ); $i < $top_level_items_count; $i++ ){
			array_push( $top_level_items[$i]->classes, 'right' );
		}
		return $items;
	}
	public function ingenious_nav_menu_pointer ( $item_output, $item ){
		if ( in_array( 'menu-item-has-children', $item->classes ) ){
			$item_output = "<span class='menu_wrap'></span>".$item_output;
			$item_output .= "<span class='pointer'></span>";
		}
		return $item_output;
	}
	public function ingenious_sandwich_menu_switcher ( $items, $args){
		if ( !in_array( $args->menu_id, array( 'main_menu', 'sticky_menu' ) ) ) return $items;
		$sandwich_menu = ingenious_get_option( 'sandwich_menu' );
		if ( $sandwich_menu && $args->theme_location == 'primary' && !empty( $items ) ){
			$items .= "<div class='sandwich_switcher' data-sandwich-action='show_hide_main_menu_items' >";
				$items .= "<a class='switcher'>";
					$items .= "<span class='ham'>";
					$items .= "</span>";
				$items .= "</a>";
			$items .= "</div>";
		}
		return $items;
	}
	public function ingenious_sandwich_menu_class ( $args ){
		if ( !in_array( $args['menu_id'], array( 'main_menu', 'sticky_menu' ) ) ) return $args;
		$sandwich_menu = ingenious_get_option( 'sandwich_menu' );
		if ( $sandwich_menu ){
			if ( isset( $args['menu_class'] ) ){
				if ( !empty( $args['menu_class'] ) ){
					$args['menu_class'] .= ' sandwich';
				}
				else{
					$args['menu_class'] = 'sandwich';
				}
			}
			else{
				$args['menu_class'] = 'sandwich';
			}
		}
		return $args;
	}
	public function ingenious_sandwich_menu_animation (){
		$sandwich_menu 		= ingenious_get_option( 'sandwich_menu' );
		$logo_pos 			= ingenious_get_option( 'logo_pos' );
		$menu_pos 			= ingenious_get_option( 'menu_pos' );
		$invert_items_anim 	= $logo_pos == 'right';
		if ( $sandwich_menu ){
			$anim_dur = 250;
			$anim_del = 60;
			$top_level_items = 0;
			$menu_locations = get_nav_menu_locations();
			if ( isset( $menu_locations['primary'] ) ){
				$term_id = $menu_locations['primary'];
				$items = wp_get_nav_menu_items( $term_id );
				if ( is_array( $items ) ){
					for ( $i = 0; $i < count( $items ); $i++ ){
						$item = $items[$i];
						if ( $item->menu_item_parent == '0' ){
							$top_level_items ++;
						}
					}
				}
			}
			$styles = "";
			for ( $i = 1; $i <= $top_level_items; $i++ ){
				$styles .= "
					.main_menu.sandwich.sandwich_active > .menu-item:nth-" . ( $invert_items_anim ? "" : "last-" ) . "child(n+$i){
						-webkit-transition: opacity "  . $anim_dur . "ms ease " . $anim_del . "ms;
						transition: opacity "  . $anim_dur . "ms ease " . $anim_del . "ms;
					}
					.main_menu.sandwich > .menu-item:nth-" . ( $invert_items_anim ? "last-" : "" ) . "child(n+$i){
						-webkit-transition: opacity "  . $anim_dur . "ms ease " . $anim_del . "ms;
						transition: opacity "  . $anim_dur . "ms ease " . $anim_del . "ms;
					}
				";
				$anim_dur += 50;
				$anim_del += 30;
			}
			if ( !empty( $styles ) ) wp_add_inline_style( 'main', $styles );
		}
	}
	public function ingenious_register_reset_styles (){
		wp_enqueue_style( 'reset', INGENIOUS_THEME_URI . '/css/reset.css' );
	}
	public function ingenious_register_theme_styles (){
		$is_rtl = is_rtl();
		$stylesheets = array(
			'font_awesome'	=> INGENIOUS_THEME_URI . '/fonts/fa/font-awesome.min.css',
			'cws-icon'		=> INGENIOUS_THEME_URI . '/fonts/cws-icon/flaticon.css',
			'select2_init'	=> INGENIOUS_THEME_URI . '/css/select2.css',
			'animate'		=> INGENIOUS_THEME_URI . '/css/animate.css',
			'layout'		=> INGENIOUS_THEME_URI . '/css/layout.css',
			'fancybox'		=> INGENIOUS_THEME_URI . '/css/jquery.fancybox.css',
		);

		do_action( 'ingenious_render_fonts_url_hook' );

		foreach ( $stylesheets as $alias => $src ){
			wp_enqueue_style( $alias, $src );
		}

		// Import FlatIcon library, the default one or custom
		$cwsfi = get_option('cwsfi');
		if (!empty($cwsfi) && isset($cwsfi['css'])) { 
			wp_enqueue_style( 'flaticon', $cwsfi['css'] );
		}else{
			wp_enqueue_style( 'flaticon', INGENIOUS_THEME_URI . '/fonts/fi/flaticon.css' );
		};
		// end of icons import

		$rtl_stylesheets = array(
			'layout-rtl'		=> INGENIOUS_THEME_URI . '/css/layout-rtl.css',
		);
		if ( $is_rtl ){
			foreach ( $rtl_stylesheets as $alias => $src ){
				wp_enqueue_style( $alias, $src );
			}
		}
	}
	public function ingenious_enqueue_main_theme_stylesheet (){
		$deps = array(
			'mediaelement',
			'wp-mediaelement',
			'select2_init',
			'animate',
			'layout',
			'fancybox',
		);
		wp_enqueue_style( 'main', INGENIOUS_THEME_URI . '/css/main.css', $deps );
		wp_add_inline_style( 'main', $this->ingenious_body_font_styles () );
		wp_add_inline_style( 'main', $this->ingenious_menu_font_styles () );
		wp_add_inline_style( 'main', $this->ingenious_header_font_styles () );
		wp_add_inline_style( 'main', $this->ingenious_custom_colors_styles () );
		wp_add_inline_style( 'main', $this->ingenious_header_styles () );
		wp_add_inline_style( 'main', $this->ingenious_footer_widgets_styles () );
		wp_add_inline_style( 'main', $this->ingenious_footer_copyrights_styles () );
		wp_add_inline_style( 'main', $this->ingenious_front_dynamic_styles () );
	}
	public function ingenious_load_youtube_api (){
		$video_section = ingenious_get_option('video_section');
		$video_yutube = $video_section['video_type'];
		if (is_front_page() && $video_yutube == 'youtube') {
			?>
			<script type="text/javascript">
				// Loads the IFrame Player API code asynchronously.
				var tag = document.createElement("script");
				tag.src = "https://www.youtube.com/player_api";
				var firstScriptTag = document.getElementsByTagName("script")[0];
				firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
			</script>
			<?php
		}
	}
	public function ingenious_register_scripts (){
		if ( is_singular() ) wp_enqueue_script( "comment-reply" );
		$common_scripts = array(
			'select2_init'			=> INGENIOUS_THEME_URI . '/js/select2.min.js',
			'fixed_sidebars'		=> INGENIOUS_THEME_URI . '/js/sticky_sidebar.min.js'
		);
		$specific_scripts = array(
			'vimeo_api'				=> INGENIOUS_THEME_URI . '/js/jquery.vimeo.api.min.js',
			'owl_carousel'			=> INGENIOUS_THEME_URI . '/js/owl.carousel.min.js',
			'isotope'				=> INGENIOUS_THEME_URI . '/js/isotope.pkgd.min.js',
			'fancybox'				=> INGENIOUS_THEME_URI . '/js/jquery.fancybox.pack.js',
			'lavalamp'				=> INGENIOUS_THEME_URI . '/js/jquery.lavalamp.min.js',
		);
		foreach ( $common_scripts as $handle => $src ) {
			wp_enqueue_script( $handle, $src, array( 'jquery' ), '', true );
		}
		foreach ( $specific_scripts as $handle => $src ) {
			wp_register_script( $handle, $src, array( 'jquery' ), '', true );
		}
		$main_deps = array(
			'jquery',
			'vimeo_api',
			'owl_carousel',
			'isotope',
			'fancybox',
			'lavalamp',
		);
		wp_enqueue_script( 'main', INGENIOUS_THEME_URI . '/js/main.js', $main_deps, '', true );
	}
	public function ingenious_define_ajaxurl (){
		wp_localize_script( 'main', 'ajaxurl', esc_url( admin_url( 'admin-ajax.php' ) ) );
		wp_localize_script( 'main', 'simpleLikes', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'like' => esc_html__( 'Like', 'ingenious' ),
			'unlike' => esc_html__( 'Unlike', 'ingenious' )
		)); 
	}
	public function ingenious_register_admin_scripts (){
		$scripts = array(
			'custom-admin'	=> INGENIOUS_THEME_URI . '/includes/core/assets/js/custom-admin.js'
		);
		foreach ( $scripts as $alias => $src ){
			wp_enqueue_script( $alias, $src );
		}
	}
	public function ingenious_register_admin_styles (){

		// Import FlatIcon library, the default one or custom
		$cwsfi = get_option('cwsfi');
		$cws_flaticon_css = '';
		if (!empty($cwsfi) && isset($cwsfi['css'])) { 
			$cws_flaticon_css = $cwsfi['css'];
		}else{
			$cws_flaticon_css =  INGENIOUS_THEME_URI . '/fonts/fi/flaticon.css';
		};
		// end of icons import
		
		$stylesheets = array(
			'font_awesome'	=> INGENIOUS_THEME_URI . '/fonts/fa/font-awesome.min.css',
			'flaticon'		=> $cws_flaticon_css
		);
		foreach ( $stylesheets as $alias => $src ){
			wp_enqueue_style( $alias, $src );
		}
		wp_enqueue_style( 'mb-post-styles', INGENIOUS_THEME_URI . '/includes/core/assets/css/mb-post-styles.css' );
	}
	public function ingenious_localize_data (){
		$data = array(
			'admin_bar' 			=> is_admin_bar_showing(),
			'rtl' 					=> is_rtl(),
			'menu_stick' 			=> (bool)ingenious_get_option( 'menu_stick' ),
			'sandwich_menu' 		=> (bool)ingenious_get_option( 'sandwich_menu' ),
			'scroll_to_top' 		=> ingenious_get_option( 'scroll_to_top' ),
		);

		$header_page_meta_vars 	= ingenious_get_page_meta_var( array( 'header' ) );
		$page_override_header 	= !empty( $header_page_meta_vars );
		$header_covers_slider 	= false;
		if ( $page_override_header ){
			$header_covers_slider 	= isset( $header_page_meta_vars['header_covers_slider'] ) ? (bool)$header_page_meta_vars['header_covers_slider'] : $header_covers_slider;
		}
		else{
			$header_covers_slider 	= (bool)ingenious_get_option( 'header_covers_slider' );
		}
		$data['header_covers_slider'] = $header_covers_slider;

		wp_localize_script( 'main', 'theme_opts', $data );
	}

	public function ingenious_body_font_styles (){
		ob_start ();
		do_action( 'ingenious_body_font_hook' );
		return ob_get_clean ();
	}
	public function ingenious_menu_font_styles (){
		ob_start ();
		do_action( 'ingenious_menu_font_hook' );
		return ob_get_clean ();
	}
	public function ingenious_header_font_styles (){
		ob_start ();
		do_action( 'ingenious_header_font_hook' );
		return ob_get_clean ();
	}
	public function ingenious_custom_colors_styles (){
		ob_start ();
		do_action( 'ingenious_custom_colors_hook' );
		return ob_get_clean ();
	}
	public function ingenious_header_styles (){
		ob_start ();
		do_action( 'ingenious_header_styles_hook' );
		return ob_get_clean ();
	}
	public function ingenious_footer_widgets_styles (){
		ob_start ();
		do_action( 'ingenious_footer_widgets_styles_hook' );
		return ob_get_clean ();
	}
	public function ingenious_footer_copyrights_styles (){
		ob_start ();
		do_action( 'ingenious_footer_copyrights_styles_hook' );
		return ob_get_clean ();
	}
	public function ingenious_front_dynamic_styles (){
		ob_start ();
		do_action( 'ingenious_front_dynamic_styles_hook' );
		return ob_get_clean ();
	}

	public function ingenious_page_meta_vars() {
		if ( is_page() ) {
			$pid = get_query_var( 'page_id' );
			$pid = ! empty( $pid ) ? $pid : get_queried_object_id();
			$pid = ! empty( $pid ) ? $pid : get_the_ID();
			$post = get_post( $pid );
			if (function_exists('cws_core_cwsfw_get_post_meta')) {
				$stored_meta = cws_core_cwsfw_get_post_meta( $pid );
			}
			$stored_meta = isset( $stored_meta[0] ) ? $stored_meta[0] : array();

			//Default value
			$stored_meta[ 'menu_opacity' ] =  !empty($stored_meta[ 'menu_opacity' ]) ? $stored_meta[ 'menu_opacity' ] : '';
			$stored_meta[ 'header_covers_slider' ] =  !empty($stored_meta[ 'header_covers_slider' ]) ? $stored_meta[ 'header_covers_slider' ] : '';
			$stored_meta[ 'menu_bg_color' ] =  !empty($stored_meta[ 'menu_bg_color' ]) ? $stored_meta[ 'menu_bg_color' ] : '';
			$stored_meta[ 'menu_font_color' ] =  !empty($stored_meta[ 'menu_font_color' ]) ? $stored_meta[ 'menu_font_color' ] : '';
			$stored_meta[ 'header_logo_light' ] =  !empty($stored_meta[ 'header_logo_light' ]) ? $stored_meta[ 'header_logo_light' ] : '';
			$stored_meta[ 'default_header_image' ] =  !empty($stored_meta[ 'default_header_image' ]) ? $stored_meta[ 'default_header_image' ] : '';
			$stored_meta[ 'add_pattern' ] =  !empty($stored_meta[ 'add_pattern' ]) ? $stored_meta[ 'add_pattern' ] : '';
			$stored_meta[ 'default_pattern_image' ] =  !empty($stored_meta[ 'default_pattern_image' ]) ? $stored_meta[ 'default_pattern_image' ] : '';
			
			//Side metabox (Image)
			$stored_meta[ 'page_back_image' ] = !empty($stored_meta[ 'page_back_image' ]) ? $stored_meta[ 'page_back_image' ] : '';

			$stored_meta[ 'header_overlay_type' ] =  !empty($stored_meta[ 'header_overlay_type' ]) ? $stored_meta[ 'header_overlay_type' ] : '';
			$stored_meta[ 'header_bg_color' ] =  !empty($stored_meta[ 'header_bg_color' ]) ? $stored_meta[ 'header_bg_color' ] : '';
			$stored_meta[ 'header_bg_opacity' ] =  !empty($stored_meta[ 'header_bg_opacity' ]) ? $stored_meta[ 'header_bg_opacity' ] : '';
			$stored_meta[ 'header_bg_overlay_gradient' ] =  !empty($stored_meta[ 'header_bg_overlay_gradient' ]) ? $stored_meta[ 'header_bg_overlay_gradient' ] : '';

			$stored_meta[ 'page_title_spacings' ] =  !empty($stored_meta[ 'page_title_spacings' ]) ? $stored_meta[ 'page_title_spacings' ] : '';

			$GLOBALS['ingenious_page_meta'] = array();
			$GLOBALS['ingenious_page_meta']['header'] = array();

			if ( isset( $stored_meta['header_override'] ) && $stored_meta['header_override'] !== '0' ){
				if (!isset($stored_meta['menu_bg_color'])) {
					$stored_meta['menu_bg_color'] = '#fff';
				}
				if (!isset($stored_meta['menu_font_color'])) {
					$stored_meta['menu_font_color'] = '#1c3545';
				}
				$GLOBALS['ingenious_page_meta']['header']['header_override'] 		= true;
				$GLOBALS['ingenious_page_meta']['header']['menu_opacity']			= $stored_meta['menu_opacity'];
				$GLOBALS['ingenious_page_meta']['header']['header_covers_slider'] 	= $stored_meta['header_covers_slider'];
				$GLOBALS['ingenious_page_meta']['header']['menu_bg_color'] 			= $stored_meta['menu_bg_color'];
				$GLOBALS['ingenious_page_meta']['header']['menu_font_color'] 		= $stored_meta['menu_font_color'];
				$GLOBALS['ingenious_page_meta']['header']['header_logo_light']	 	= $stored_meta['header_logo_light'];
				$GLOBALS['ingenious_page_meta']['header']['default_header_image'] 	= ingenious_get_option( 'default_header_image' ); //[!] From ThemeOptions

				$GLOBALS['ingenious_page_meta']['header']['add_pattern'] 	= $stored_meta['add_pattern'];
				$GLOBALS['ingenious_page_meta']['header']['default_pattern_image'] 	= $stored_meta['default_pattern_image'];

				$GLOBALS['ingenious_page_meta']['header']['header_overlay_type'] 	= $stored_meta['header_overlay_type'];
				$GLOBALS['ingenious_page_meta']['header']['header_bg_color'] 		= $stored_meta['header_bg_color'];
				$GLOBALS['ingenious_page_meta']['header']['header_bg_opacity'] 		= $stored_meta['header_bg_opacity'];
				$GLOBALS['ingenious_page_meta']['header']['header_bg_overlay_gradient'] = $stored_meta['header_bg_overlay_gradient'];

				$GLOBALS['ingenious_page_meta']['header']['page_title_spacings'] 	= $stored_meta['page_title_spacings'];
			}
			else{
				$GLOBALS['ingenious_page_meta']['header']['header_override'] 		= false;
				$GLOBALS['ingenious_page_meta']['header']['menu_opacity'] 			= ingenious_get_option( 'menu_opacity' );
				$GLOBALS['ingenious_page_meta']['header']['header_covers_slider'] 	= ingenious_get_option( 'header_covers_slider' );
				$GLOBALS['ingenious_page_meta']['header']['menu_bg_color'] 			= ingenious_get_option( 'menu_bg_color' );
				$GLOBALS['ingenious_page_meta']['header']['menu_font_color'] 		= ingenious_get_option( 'menu_font_color' );
				$GLOBALS['ingenious_page_meta']['header']['header_logo_light'] 		= ingenious_get_option( 'header_logo_light' );
				$GLOBALS['ingenious_page_meta']['header']['default_header_image'] 	= ingenious_get_option( 'default_header_image' );

				$GLOBALS['ingenious_page_meta']['header']['header_overlay_type'] 	= ingenious_get_option( 'header_overlay_type' );

				$GLOBALS['ingenious_page_meta']['header']['add_pattern'] 			= ingenious_get_option( 'add_pattern' );
				$GLOBALS['ingenious_page_meta']['header']['default_pattern_image'] 	= ingenious_get_option( 'default_pattern_image' );


				$GLOBALS['ingenious_page_meta']['header']['header_bg_color'] 		= ingenious_get_option( 'header_bg_color' );
				$GLOBALS['ingenious_page_meta']['header']['header_bg_opacity'] 		= ingenious_get_option( 'header_bg_opacity' );
				$GLOBALS['ingenious_page_meta']['header']['header_bg_overlay_gradient'] = ingenious_get_option( 'header_bg_overlay_gradient' );

				$GLOBALS['ingenious_page_meta']['header']['page_title_spacings'] 	= ingenious_get_option( 'page_title_spacings' );
			}

			//Override ThemeOptions image, with image from metabox
			if (!empty($stored_meta[ 'page_back_image' ]['src'])){
				$GLOBALS['ingenious_page_meta']['header']['default_header_image']['image'] = $stored_meta[ 'page_back_image' ];
			}

			$GLOBALS['ingenious_page_meta']['sb'] = ingenious_get_sidebars( $pid );
			$GLOBALS['ingenious_page_meta']['footer'] = array( 'footer_sb_top' => '', 'footer_sb_bottom' => '' );
			if ( isset( $stored_meta['sb_foot_override'] ) && $stored_meta['sb_foot_override'] !== '0' ) {
				$GLOBALS['ingenious_page_meta']['footer']['footer_sb_top'] = isset( $stored_meta['footer-sidebar-top'] ) ? $stored_meta['footer-sidebar-top'] : '';
			} else {
				$GLOBALS['ingenious_page_meta']['footer']['footer_sb_top'] = ingenious_get_option( 'footer_sb' );
			}
			$GLOBALS['ingenious_page_meta']['slider'] = array( 'slider_override' => '', 'slider_shortcode' => '' );
			$GLOBALS['ingenious_page_meta']['slider']['slider_override'] = isset( $stored_meta['sb_slider_override'] ) && $stored_meta['sb_slider_override'] !== '0' ? $stored_meta['sb_slider_override'] : false;
			$GLOBALS['ingenious_page_meta']['slider']['slider_shortcode'] = isset( $stored_meta['slider_shortcode'] ) ? $stored_meta['slider_shortcode'] : '';
			return true;
		} else {
			return false;
		}
	}
}

global $cws_theme_funcs;

$cws_theme_funcs = new Ingenious_Theme_Features;

function ingenious_check_for_plugin ( $plugin ){   /* $plugin - folder/file  */
	return in_array( $plugin, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
}

/*****
* WPML
*****/

function ingenious_wpml_ext_init (){
	define('CWS_WPML_ACTIVE', true);
}
function ingenious_is_wpml_active() {
	return defined('CWS_WPML_ACTIVE') && CWS_WPML_ACTIVE;
}
function ingenious_show_flags_in_footer () {
	return isset( $GLOBALS['wpml_settings']['icl_lang_sel_footer'] ) ? $GLOBALS['wpml_settings']['icl_lang_sel_footer'] : false;
}
function ingenious_wpml_ext_nav_menu_items_filter ( $items, $args ){
	$items = preg_replace( "#\"((\w|\s|-)*menu-item-language(\w|\s|-)*)\"#", "\"$1 right\"", $items );
	return $items;
}
/* ! WPML Issue ! */
function ingenious_wpml_ext_bodyClass_filter ( $classes ){
	$wpml_prefix = "cws_wpml_icl_ls_";
	$opt_name = "";
	$display_flag = get_option( "icl_lso_flags" );
	$display_native_lang = get_option( "icl_lso_native_lang" );
	$display_display_lang = get_option( "icl_lso_display_lang" );
	if ( $display_flag && !$display_native_lang && !$display_display_lang ){
		$opt_name = "only_flag";
	}
	else if ( $display_native_lang && $display_display_lang ){
		$opt_name = "extended_width";
	}
	if ( !empty( $opt_name ) ){
		$classes[] = $wpml_prefix . $opt_name;
	}
	return $classes;
}
/******
* \WPML
******/

function ingenious_site_header_html (){
	ob_start();
	$header_class = $sticky_header_class = $mobile_header_class = "site_header";

	$mobile_header_class .= " sandwich";
	$logo_init = ingenious_get_option( 'logo' );
	$light_logo = ingenious_get_option( 'light_logo' );
	$logo_dims = ingenious_get_option( 'logo_dims' );
	$menu_fw = ingenious_get_option( 'menu_fw' );
	$menu_fw = (bool)$menu_fw;

	$show_woo_minicart = ingenious_check_for_plugin( 'woocommerce/woocommerce.php' ) && ingenious_get_option( 'woo_cart_enable' );
	$wmpl_menu_icon = ingenious_is_wpml_active() && ingenious_get_option( 'wmpl_menu_icon' );
	$header_page_meta_vars 	= ingenious_get_page_meta_var( array( 'header' ) );
	$header_override 	= !empty( $header_page_meta_vars );

	if ( $header_override ){
		if ( $header_page_meta_vars['header_logo_light'] == 'black' ) {
			$logo = $logo_init;
		} else if ( $header_page_meta_vars['header_logo_light'] == 'white' ) {
			$logo = $light_logo;
		} 
	}
	else{
		if (function_exists('is_woocommerce') && is_woocommerce()) {
			$logo_var = ingenious_get_option('header_woo_logo_sel'); 
		} else {
			$logo_var = ingenious_get_option('header_logo_light'); 
		}

		if ( $logo_var == 'black' ) {
			$logo = $logo_init;
		} else if( $logo_var == 'white' ) {
			$logo = $light_logo;
		}
	}
	$logo_id = isset( $logo['id'] ) ? $logo['id'] : "";
	$logo_hdpi = isset( $logo['is_high_dpi'] ) ? (bool)$logo['is_high_dpi'] : false;
	$logo_obj = !empty( $logo_id ) ? wp_get_attachment_image_src( $logo_id, 'full' ) : array();
	$logo_bfi_args = array();
	if ( is_array( $logo_dims ) ){
		foreach ( $logo_dims as $key => $value ) {
			if ( !empty($value) ){
				$logo_bfi_args[$key] = $value;
			}
		}
	}

	$logo_srcs = ingenious_get_img_srcs( $logo_obj, $logo_hdpi, $logo_bfi_args, $logo_id);
	$logo_exists 				= isset( $logo_srcs['src'] ) && !empty( $logo_srcs['src'] );
	$logo_src 					= $logo_exists ? $logo_srcs['src'] : '';
	$logo_retina_thumb_exists 	= $logo_exists ? $logo_srcs['retina_thumb_exists'] : false;
	$logo_retina_thumb_url 		= $logo_exists ? $logo_srcs['retina_thumb_url'] : '';
	/* sticky logo */
	$sticky_logo = ingenious_get_option( 'sticky_logo' );
	$sticky_logo_id = isset( $sticky_logo['id'] ) ? $sticky_logo['id'] : "";
	$sticky_logo_hdpi = isset( $sticky_logo['is_high_dpi'] ) ? (bool)$sticky_logo['is_high_dpi'] : false;
	$sticky_logo_obj = !empty( $sticky_logo_id ) ? wp_get_attachment_image_src( $sticky_logo_id, 'full' ) : array();
	$sticky_logo_exists = !empty( $sticky_logo_obj );
	$sticky_logo_src 					= "";
	$sticky_logo_retina_thumb_exists 	= false;
	$sticky_logo_thumb_url 				= "";
	if ( $sticky_logo_exists ){
		$sticky_logo_url = $sticky_logo_obj[0];
		if ( $sticky_logo_hdpi ){
			$sticky_logo_bfi_obj = ingenious_thumb( $sticky_logo_url, array( 'width' => floor( $sticky_logo_obj[1] / 2 ) ), $sticky_logo_id );
			$sticky_logo_src = $sticky_logo_bfi_obj[0];
			$sticky_logo_retina_thumb_exists = isset($sticky_logo_bfi_obj[3]) ? $sticky_logo_bfi_obj[3] : ""; 
			$sticky_logo_retina_thumb_url = isset($sticky_logo_bfi_obj[3]) ? $sticky_logo_bfi_obj[3] : ""; 
		}
		else{
			$sticky_logo_src = $sticky_logo_url;
		}
	}
	else{
		$sticky_logo_exists 				= $logo_exists;
		$sticky_logo_src 					= $logo_src;
		$sticky_logo_retina_thumb_exists 	= $logo_retina_thumb_exists;
		$sticky_logo_retina_thumb_url 		= $logo_retina_thumb_url;
	}
	/* \sticky logo */
	/* mobile logo */
	$mobile_logo = ingenious_get_option( 'mobile_logo' );
	$mobile_logo_id = isset( $mobile_logo['id'] ) ? $mobile_logo['id'] : "";
	$mobile_logo_hdpi = isset( $mobile_logo['is_high_dpi'] ) ? (bool)$mobile_logo['is_high_dpi'] : false;
	$mobile_logo_obj = !empty( $mobile_logo_id ) ? wp_get_attachment_image_src( $mobile_logo_id, 'full' ) : array();
	$mobile_logo_exists = !empty( $mobile_logo_obj );
	$mobile_logo_src 					= "";
	$mobile_logo_retina_thumb_exists 	= false;
	$mobile_logo_retina_thumb_url 		= "";
	if ( $mobile_logo_exists ){
		$mobile_logo_url = $mobile_logo_obj[0];
		if ( $mobile_logo_hdpi ){
			$mobile_logo_bfi_obj = ingenious_thumb( $mobile_logo_url, array( 'width' => floor( $mobile_logo_obj[1] / 2 ) ), $mobile_logo_id );
			$mobile_logo_src = $mobile_logo_bfi_obj[0];
			$mobile_logo_retina_thumb_exists = isset($mobile_logo_bfi_obj[3]) ? $mobile_logo_bfi_obj[3] : ""; 
			$mobile_logo_retina_thumb_url = isset($mobile_logo_bfi_obj[3]) ? $mobile_logo_bfi_obj[3] : ""; 
		}
		else{
			$mobile_logo_src = $mobile_logo_url;
		}
	}
	else{
		$mobile_logo_exists 				= $logo_exists;
		$mobile_logo_src 					= $logo_src;
		$mobile_logo_retina_thumb_exists 	= $logo_retina_thumb_exists;
		$mobile_logo_retina_thumb_url 		= $logo_retina_thumb_url;
	}
	/* \mobile logo */
	$logo_pos = ingenious_get_option( 'logo_pos' );
	$header_class .= $logo_exists && !empty( $logo_pos ) ? " logo_$logo_pos" : "";
	$header_class .= !ingenious_check_for_plugin( 'cws-to/cws-to.php' ) ? " default_style" : '';
	$sticky_header_class .= $logo_exists && !empty( $logo_pos ) ? " logo_$logo_pos" : "";
	$logo_margins = ingenious_get_option( 'logo_margins' );
	$logo_styles = "";
	if ( is_array( $logo_margins ) ){
		foreach ( $logo_margins as $side => $value ) {
			$logo_styles .= $value !== '' && is_numeric($value) ? "padding-$side: {$value}px;" : '';
		}
	}

	$logo_pos_check = esc_attr( ingenious_get_option( 'logo_pos' ) );
	$logo_pos = !empty ( $logo_pos_check ) ? $logo_pos_check : 'left';

	$menu_pos_check = esc_attr( ingenious_get_option( 'menu_pos' ) );
	$menu_pos = !empty ( $menu_pos_check ) ? $menu_pos_check : 'right';

	$menu_args = array(
		'menu_id' => 'main_menu',
		'menu_class' => 'main_menu' . ( !empty( $menu_pos ) ? " a_{$menu_pos}_flex" : "" ),
		'container' => false,
		'echo' => false,
		'theme_location' => 'primary'
	);
	$sticky_menu_args = array(
		'menu_id' => 'sticky_menu',
		'menu_class' => 'main_menu' . ( !empty( $menu_pos ) ? " a_{$menu_pos}_flex" : "" ),
		'container' => false,
		'echo' => false,
		'theme_location' => 'primary'
	);
	$mobile_menu_args = array(
		'menu_id'	=> 'mobile_menu',
		'menu_class'=> 'main_menu',
		'container'	=> false,
		'echo' => false,
		'theme_location' => 'primary'
	);
	$menu_exists = has_nav_menu( 'primary' );
	$menu = $menu_exists ? wp_nav_menu( $menu_args ) : "";
	$menu_stick = ingenious_get_option( 'menu_stick' );
	$sticky_menu = ($menu_stick !== 'none') && $menu_exists ? wp_nav_menu( $sticky_menu_args ) : "";
	$mobile_menu = $menu_exists ? wp_nav_menu( $mobile_menu_args ) : "";
	$sticky_header_class .= !empty($menu_stick) && $menu_stick != 'none' ? " $menu_stick" : "";
	$logo = "";
	$sticky_logo = "";
	$mobile_logo = "";
	$ingenious_svg_logo_dims = "";
	$filetype = wp_check_filetype($logo_src);
	if ($filetype && $filetype['ext'] == 'svg'){
		$ingenious_svg_logo_dims = (! empty($logo_dims['width']) ? 'width = "'.$logo_dims['width'].'px"' : '') . (! empty($logo_dims['height']) ? ' height = "'.$logo_dims['height'].'px"' : '');
	}
	$logo .= "<div class='header_logo a_{$logo_pos}'" . ( !empty( $logo_styles ) ? " style='$logo_styles'" : "" ) . " role='banner'>";
		$logo .= "<a href='" . esc_url( get_site_url() ) . "'>";
			if ($logo_exists) {
				$logo .= "<img src='$logo_src' class='header_logo_img'" . $ingenious_svg_logo_dims . ( $logo_retina_thumb_exists ? " data-at2x='$logo_retina_thumb_url'" : " data-no-retina" ) . " alt />";
			} else {
				$logo .= "<h1>" . get_bloginfo( 'name' ) . "</h1>";
			}
		$logo .= "</a>";
	$logo .= "</div>";
	if ( $sticky_logo_exists ){
		$sticky_logo .= "<div class='header_logo a_{$logo_pos}'" . ( !empty( $logo_styles ) ? " style='$logo_styles'" : "" ) . " role='banner'>";
			$sticky_logo .= "<a href='" . esc_url( get_site_url() ) . "'>";
				$sticky_logo .= "<img src='$sticky_logo_src' class='header_logo_img'" . ( $sticky_logo_retina_thumb_exists ? " data-at2x='$sticky_logo_retina_thumb_url'" : " data-no-retina" ) . " alt />";
			$sticky_logo .= "</a>";
		$sticky_logo .= "</div>";
	}
	$mobile_logo .= "<div class='header_logo' role='banner'>";
		$mobile_logo .= "<a href='" . esc_url( get_site_url() ) . "'>";
		if ($mobile_logo_exists) {
			$mobile_logo .= "<img src='".esc_url($mobile_logo_src)."' class='header_logo_img'" . ( $mobile_logo_retina_thumb_exists ? " data-at2x='".esc_url($mobile_logo_retina_thumb_url)."'" : " data-no-retina" ) . " alt />";
		} else {
			$mobile_logo .= "<h1>" . get_bloginfo( 'name' ) . "</h1>";
		}
		$mobile_logo .= "</a>";
	$mobile_logo .= "</div>";
	$mini_cart = '';

	if ( $show_woo_minicart ) {
		ob_start();
		ob_start();
		woocommerce_mini_cart();
		$minicart = ob_get_clean();
		$cart_url = esc_url( wc_get_cart_url() );
		$cart_content = (WC()->cart->cart_contents_count > 0) ? esc_html( WC()->cart->cart_contents_count ) : "";
		echo "<div class='woo_minicart_bar_item bar_item'>";
			echo "<div class=\"top_panel_woo_minicart bar_item_content widget woocommerce\">";
				echo sprintf("%s", $minicart);
			echo "</div>";
			echo "<a class='top_panel_woo_minicart_el woo_icon bar_element cws-icon-commerce-2' href='$cart_url' title='" . esc_html__( "View your shopping cart", "ingenious" ) . "'><span class='woo_mini_count'>$cart_content</span></a>";
		echo "</div>";
		$mini_cart = ob_get_clean();
	}

	$wpml_bar = '';
	if ( ingenious_is_wpml_active() ) {
		ob_start();
			echo "<div class='lang_bar".($wmpl_menu_icon ? ' wpml_icon' : '')."'>";
				do_action( 'icl_language_selector' );
			echo "</div>";
		$wpml_bar = ob_get_clean();
	}

	$menu_search = '';
	$menu_search_form = '';
	$menu_search = "<div class='menu_search_button'></div>";
	ob_start();

	echo "<div class='menu_search_wrap".(!ingenious_check_for_plugin( 'cws-to/cws-to.php' ) ? " default_style" : '')."'>";
		echo "<div class='container'>";
			echo "<div class='search_back_button'></div>";
			echo get_search_form();
		echo "</div>";
	echo "</div>";
	$menu_search_form = ob_get_clean();
	$menu_boxed = $menu_fw ? ' menu_boxed' : '';
	if ( ($menu_stick !== 'none') && !empty( $sticky_menu ) ){
		echo "<section id='sticky'" . ( !empty( $sticky_header_class ) ? " class='".esc_attr($sticky_header_class . " " . $menu_boxed )." '" : "" ) . ">";
			echo "<div id='sticky_box'>";
				echo "<div class='ingenious_layout_container'>";
				if ( !empty( $sticky_logo ) ){
					if ( $logo_pos == 'center' ){
						echo sprintf("%s", $sticky_menu);
					} else {
						echo sprintf("%s", $sticky_logo);
						echo "<div class='cws_sticky_extra'>";
							echo sprintf("%s", $sticky_menu);
							echo sprintf("%s", $menu_search);
							echo sprintf("%s", $mini_cart);
						echo "</div>";
					}
				}
				else{
					echo sprintf("%s", $sticky_menu);
				}
				echo "</div>";
			echo "</div>";
		echo "</section>";
	}
	echo sprintf("%s", $menu_search_form);
	if ( !empty( $logo ) || !empty( $menu ) ){
		echo "<header id='site_header'" . ( !empty( $header_class ) ? " class='" . esc_attr( trim( $header_class ) . $menu_boxed ) . "'" : "" ) . ">";
			if ( !empty( $logo ) ){
				if ( $logo_pos == 'center' ){
					echo "<div class='ingenious_layout_container flex_center'>";
						echo sprintf("%s", $logo);
					echo "</div>";
					echo "<div class='ingenious_layout_container " . ( !empty( $menu_pos_check ) ? " a_{$menu_pos_check}_flex" : "" ) . "'>";
						echo "<div class='menu_wrapper a_{$menu_pos}'>";
							echo sprintf("%s", $menu);
							echo sprintf("%s", $menu_search);
							echo sprintf("%s", $mini_cart);
							echo sprintf("%s", $wpml_bar);
						echo "</div>";
					echo "</div>";
				}
				else{
					echo "<div class='ingenious_layout_container'>";
						echo sprintf("%s", $logo);
						echo "<div class='menu_wrapper a_{$menu_pos}'>";
							echo sprintf("%s", $menu);
							echo sprintf("%s", $menu_search);
							echo sprintf("%s", $mini_cart);
							echo sprintf("%s", $wpml_bar);
						echo "</div>";
					echo "</div>";
				}
			}
			else{
				echo "<div class='ingenious_layout_container'>";
					echo "<div class='menu_wrapper a_{$menu_pos}'>";
						echo sprintf("%s", $menu);
						echo sprintf("%s", $menu_search);
						echo sprintf("%s", $mini_cart);
						echo sprintf("%s", $wpml_bar);
					echo "</div>";
				echo "</div>";
			}
		echo "</header>";
	}
	if ( !empty( $logo ) || !empty( $mobile_menu ) ){
		$mobile_sandwich = "";
		$mobile_sandwich .= "<div class='sandwich_switcher' data-sandwich-action='toggle_mobile_menu' >";
			$mobile_sandwich .= "<a class='switcher'>";
				$mobile_sandwich .= "<span class='ham'>";
				$mobile_sandwich .= "</span>";
			$mobile_sandwich .= "</a>";
		$mobile_sandwich .= "</div>";
		echo "<section id='mobile_header'" . ( !empty( $mobile_header_class ) ? " class='".esc_attr($mobile_header_class)."'" : "" ) . ">";
				echo "<div class='ingenious_layout_container" . ( empty( $mobile_logo ) && !empty( $mobile_menu ) ? " a_right_flex" : "" ) . "'>";
				if ( !empty( $mobile_logo ) ){
					echo sprintf("%s", $mobile_logo);
					echo "<div class='header_wrap_menu'>";
						echo sprintf("%s", $menu_search);
						echo sprintf("%s", $mini_cart);
						echo sprintf("%s", $wpml_bar);
						echo !empty( $mobile_menu ) ? $mobile_sandwich : "";
					echo "</div>";
				}
				else{
					echo "<div class='header_wrap_menu'>";
						echo sprintf("%s", $menu_search);
						echo sprintf("%s", $mini_cart);
						echo sprintf("%s", $wpml_bar);
						echo !empty( $mobile_menu ) ? $mobile_sandwich : "";
					echo "</div>";
				}
				echo "</div>";
				if ( !empty( $mobile_menu ) ){
					echo "<div id='mobile_menu_wrapper'>";
						echo "<div class='ingenious_layout_container'>";
							echo sprintf("%s", $mobile_menu);
						echo "</div>";
					echo "</div>";
				}
		echo "</section>";
	}
	$site_header_html = ob_get_clean();
	return $site_header_html;
}
function ingenious_header (){
	$header = "";
	$header_page_meta_vars 	= ingenious_get_page_meta_var( array( 'header' ) );
	$page_override_header 	= !empty( $header_page_meta_vars );
	$customize_menu 		= (bool)ingenious_get_option( 'customize_menu' );
	$menu_opacity 			= '100';
	$header_covers_slider 	= '';
	if ( $page_override_header ){
		$header_covers_slider 	= isset( $header_page_meta_vars['header_covers_slider'] ) ? (bool)$header_page_meta_vars['header_covers_slider'] : $header_covers_slider;
		$menu_opacity 			= isset( $header_page_meta_vars['menu_opacity'] ) ? $header_page_meta_vars['menu_opacity'] : $menu_opacity;
	} else{
		$menu_opacity 			= ingenious_get_option( 'menu_opacity' );
	}
	$menu_opacity = (int)$menu_opacity;

	$site_header_html = ingenious_site_header_html();

	$slider = "";
	ob_start();
	get_template_part( 'slider' );
	$slider_section_content = ob_get_clean();
	if ( !empty( $slider_section_content ) ){
		$slider .= "<section id='main_slider_section'>";
			$slider .= $slider_section_content;
		$slider .= "</section>";
	}
	ob_start();
	get_template_part( "page-title" );
	$page_title = ob_get_clean();
	$header .= $site_header_html;
	$header .=  "<div id='header_wrapper'>";
		$header .= ingenious_page_loader();
		if ( empty($slider) || is_single() ){
			$header .= $page_title;
		} else{
			$header .= $slider;
		}
	$header .=  "</div>";

	echo sprintf("%s", $header);
}

function ingenious_get_img_srcs ( $img_data = array(), $hdpi = false, $bfi_args = array(), $logo_id = 0 ){
	$url = isset($img_data[0]) ? $img_data[0] : '';
	$srcs = array(
		'src' 					=> '',
		'retina_thumb_exists'	=> false,
		'retina_thumb_url'		=> ''
	);
	if ( empty( $bfi_args ) ){
		if ( $hdpi ){
			$bfi_obj = ingenious_thumb( $url, array( 'width' => floor( $img_data[1] / 2 ) ), $logo_id );
			$srcs['src'] = $bfi_obj[0];
			$srcs['retina_thumb_exists'] = isset($bfi_obj[3]) ? $bfi_obj[3] : ""; 
			$srcs['retina_thumb_url'] = isset($bfi_obj[3]) ? $bfi_obj[3] : ""; 
		}
		else{
			$srcs['src'] = $url;
		}
	}
	else{
		$bfi_obj = ingenious_thumb( $url, $bfi_args, $logo_id );
		$srcs['src'] = $bfi_obj[0];
		$srcs['retina_thumb_exists'] = isset($bfi_obj[3]) ? $bfi_obj[3] : ""; 
		$srcs['retina_thumb_url'] = isset($bfi_obj[3]) ? $bfi_obj[3] : ""; 
	}
	return $srcs;
}

function ingenious_scroll_to_top (){
	ob_start();
	?>
	<div id='scroll_to_top'>
		<i class='cws-icon-arrows'></i>
	</div>
	<?php
	return ob_get_clean();
}

function ingenious_custom_search ( $form ) {
	$form = "
		<form method='get' class='searchform' action=' ".site_url()." ' >
			<div class='search_wrapper'>
			<label><span class='screen-reader-text'>Search for:</span></label>
			<input type='text' placeholder='".esc_html__( 'Search...', 'ingenious' )."' class='search-field' value='". esc_attr(apply_filters('the_search_query', get_search_query())) ."' name='s'/>
			<input type='submit' class='search-submit' value='".esc_html__( 'Search', 'ingenious' )."' />
			</div>
		</form>";

	return $form;
}
add_filter('get_search_form','ingenious_custom_search');

function ingenious_get_post_term_links_str ( $tax = "", $delim = "&#x2c;&#x20;" ){
	$pid = get_the_id();
	$terms_arr = wp_get_post_terms( $pid, $tax );
	$terms = "";
	if ( is_wp_error( $terms_arr ) ){
		return $terms;
	}
	for( $i = 0; $i < count( $terms_arr ); $i++ ){
		$term_obj	= $terms_arr[$i];
		$term_slug	= $term_obj->slug;
		$term_name	= esc_html( $term_obj->name );
		$term_link	= esc_url( get_term_link( $term_slug, $tax ) );
		$terms		.= "<a href='$term_link'>$term_name</a>" . ( $i < ( count( $terms_arr ) - 1 ) ? $delim : "" );
	}
	return $terms;
}

function ingenious_dbl_to_sngl_quotes ( $content ){
	return preg_replace( "|\"|", "'", $content );
}
add_filter( "ingenious_dbl_to_sngl_quotes", "ingenious_dbl_to_sngl_quotes" );

//Render help functions
function ingenious_render_gradient_rules( $settings, $selectors = '',  $use_extra_rules = false) {
	extract( shortcode_atts( array(
		'c1' => INGENIOUS_THEME_COLOR,
		'c2' => INGENIOUS_THEME_COLOR,
		'op1' => '100',
		'op2' => '100',
		'type' => 'linear',
		'linear' => array(),
		'radial' => array(),
		'custom_css' => '',
	), $settings));

	if (!empty($custom_css)) return $custom_css;

	$c1 = 'rgba('.ingenious_Hex2RGBA($c1,(int)$op1/100) .')';
	$c2 = 'rgba('.ingenious_Hex2RGBA($c2,(int)$op2/100) .')';

	$out = '';
	$rules = '';
	switch ($type) {
		case 'linear':
			$angle = isset($linear['angle']) ? $linear['angle'] : 0;
			$rules .= "background:-webkit-linear-gradient(".esc_attr($angle)."deg, ".esc_attr($c1).", ".esc_attr($c2).");";
			$rules .= "background:-o-linear-gradient(".esc_attr($angle)."deg, ".esc_attr($c1).", ".esc_attr($c2).");";
			$rules .= "background:-moz-linear-gradient(".esc_attr($angle)."deg, ".esc_attr($c1).", ".esc_attr($c2).");";
			$rules .= "background:linear-gradient(".esc_attr($angle)."deg, ".esc_attr($c1).", ".esc_attr($c2).");";
			break;
		case 'radial':
			extract( shortcode_atts( array(
				'shape_type' => 'simple',
				'shape' => 'ellipse',
				'keyword' => 'farthest-corner',
				'size' => ''
			), $radial));

			switch ($shape_type) {
				case 'simple':
					$rules .= "background:-webkit-radial-gradient(".esc_attr($shape)." ".esc_attr($c1).", ".esc_attr($c2).");";
					$rules .= "background:-o-radial-gradient(".esc_attr($shape)." ".esc_attr($c1).", ".esc_attr($c2).");";
					$rules .= "background:-moz-radial-gradient(".esc_attr($shape)." ".esc_attr($c1).", ".esc_attr($c2).");";
					$rules .= "background:radial-gradient(".esc_attr($shape)." ".esc_attr($c1).", ".esc_attr($c2).");";
					break;
				case 'exteneded':
					$rules .= "background:-webkit-radial-gradient( ".esc_attr($size)." ".esc_attr($size_keyword)." ".esc_attr($c1).", ".esc_attr($c2).");";
					$rules .= "background:-o-radial-gradient( ".esc_attr($size)." ".esc_attr($size_keyword)." ".esc_attr($c1).", ".esc_attr($c2).");";
					$rules .= "background:-moz-radial-gradient( ".esc_attr($size)." ".esc_attr($size_keyword)." ".esc_attr($c1).", ".esc_attr($c2).");";
					$rules .= "background:radial-gradient(".esc_attr($size_keyword)." at ".esc_attr($size)." ".esc_attr($c1).", ".esc_attr($c2).");";
					break;
		}
			break;
	}

	if ( !empty( $rules ) ) {
		$printf_rules = !empty($selectors) ? '%s{%s}' : '%s%s';
		$out .= sprintf($printf_rules, $selectors, $rules);
		if ( $use_extra_rules ) {
			$border_extra_rules = 'border-color:transparent;-moz-background-clip:border;-webkit-background-clip: border;background-clip:border-box;-moz-background-origin:border;-webkit-background-origin:border;background-origin:border-box;background-repeat:no-repeat;';
			$transition_extra_rules = '-webkit-transition-property:background,color,border-color,opacity;-webkit-transition-duration:0s,0s,0s,0.6s;-o-transition-property:background,color,border-color,opacity;-o-transition-duration:0s,0s,0s,0.6s;-moz-transition-property:background,color,border-color,opacity;-moz-transition-duration:0s,0s,0s,0.6s;transition-property:background,color,border-color,opacity;transition-duration:0s,0s,0s,0.6s;';
			$out .= sprintf($printf_rules, $selectors, $border_extra_rules);
			$out .= sprintf($printf_rules, $selectors, 'color: #fff !important;');
			$selectors_wth_pseudo = str_replace( ':hover', '', $selectors );
			$out .= sprintf($printf_rules, $selectors_wth_pseudo, $transition_extra_rules);
		}
	}
	return $out;
}

function ingenious_Hex2RGBA( $hex, $opacity = '1' ) {
	$hex = str_replace('#', '', $hex);
	$color = '';

	if(strlen($hex) == 3) {
		$color = hexdec(substr($hex, 0, 1 )) . ',';
		$color .= hexdec(substr($hex, 1, 1 )) . ',';
		$color .= hexdec(substr($hex, 2, 1 )) . ',';
	}
	else if(strlen($hex) == 6) {
		$color = hexdec(substr($hex, 0, 2 )) . ',';
		$color .= hexdec(substr($hex, 2, 2 )) . ',';
		$color .= hexdec(substr($hex, 4, 2 )) . ',';
	}
	$color .= $opacity;
	return $color;
}

function ingenious_print_background($props = null) {
	$out = '';
	if ($props && is_array($props)) {
		foreach ($props as $key => $value) {
			if ('image' === $key) {
				$out .= 'background-'.esc_attr($key).':';
				$out .= sprintf('url(%s);', esc_url($value['src']));
			}
		}
		$out .=  ingenious_print_css_keys($props, 'background-');
	}
	return $out;
}

function ingenious_print_css_keys($a, $prefix = '', $suffix = '') {
	$out = '';
	if (is_array($a)) {
		foreach ($a as $key => $value) {
			if (!is_array($a[$key]) && !empty($value)) {
				if ('position' === $key) {
					$out .= $prefix . $key . ':' . ingenious_print9positions($value) . $suffix . ';';
				} else {
					$out .= $prefix . $key . ':' . $value . $suffix . ';';
				}
			}
		}
	}
	return trim($out);
}

function ingenious_print9positions($pos){
	$bg_pos = '';
	for ($i=0; $i<2;$i++) {
		$c = $pos[$i];
		switch ($c) {
			case 'l':
				$bg_pos .= ' left';
				break;
			case 'r':
				$bg_pos .= ' right';
				break;
			case 'c':
				$bg_pos .= ' center';
				break;
			case 'b':
				$bg_pos .= ' bottom';
				break;
			case 't':
				$bg_pos .= ' top';
				break;
		}
	}
	return trim($bg_pos);
}
//Render help functions

function ingenious_get_option($name) {
	$ret = null;
	if (is_customize_preview()) {
		global $cwsfw_settings;
		if (isset($cwsfw_settings[$name])) {
			$ret = $cwsfw_settings[$name];
			if (is_array($ret)) {
				$theme_options = get_option( 'ingenious' );
				if (isset($theme_options[$name])) {
					$to = $theme_options[$name];
					foreach ($ret as $key => $value) {
						$to[$key] = $value;
					}
					$ret = $to;
				}
			}
			return $ret;
		}
	}
	$theme_options = get_option( 'ingenious' );
	$ret = isset($theme_options[$name]) ? $theme_options[$name] : null;
	$ret = stripslashes_deep( $ret );
	return $ret;
}

function ingenious_get_all_fa_icons (){
	$meta = get_option('cws_fa');
	if (empty($meta) || (time() - $meta['t']) > 3600*7 ) {
		global $wp_filesystem;
		if( empty( $wp_filesystem ) ) {
			require_once( ABSPATH .'/wp-admin/includes/file.php' );
			WP_Filesystem();
		}
		$file = get_template_directory() . '/fonts/fa/font-awesome.min.css';
		$fa_content = '';
		if ( $wp_filesystem && $wp_filesystem->exists($file) ) {
			$fa_content = $wp_filesystem->get_contents($file);
			if ( preg_match_all( "/fa-((\w+|-?)+):before/", $fa_content, $matches, PREG_PATTERN_ORDER ) ) {
				return $matches[1];
			}
		}
	} else {
		return $meta['fa'];
	}
}

function ingenious_render_social_links (){
	$out = "";
	$social_group = ingenious_get_option( "social_group" );
	if (!empty($social_group)){
		for ( $i = 0; $i < count( $social_group ); $i++ ){
			$social_icon = esc_html( $social_group[$i]['icon'] );
			$social_title = esc_html( $social_group[$i]['title'] );
			$social_url = esc_url( $social_group[$i]['url'] );
			if ( !empty( $social_icon ) ){
				$out .= "<a class='social_icon'" . ( !empty( $social_url ) ? " href='$social_url'" : "" ) . ( !empty( $social_title ) ? " title='$social_title'" : "" ) . "><i class='$social_icon'></i></a>";
			}
		}
	}
	return $out;
}

function ingenious_pagination ( $paged=1, $max_paged=1, $dynamic = true ){
	$is_rtl = is_rtl();

	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts	= explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = $GLOBALS['wp_rewrite']->using_permalinks() ? trailingslashit( $pagenum_link ) . '%_%' : trailingslashit( $pagenum_link ) . '?%_%';
	$pagenum_link = add_query_arg( $query_args, $pagenum_link );

	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : 'paged=%#%';
	$prev_text = esc_html__( 'Prev' , 'ingenious' );
	$next_text = esc_html__( 'Next' , 'ingenious' );
	?>
	<div class="pagination<?php echo sprintf("%s", $dynamic) ? ' dynamic' : ''; ?>">
		<div class='page_links'>
		
		<?php
		$pagination_args = array( 'base' => $pagenum_link,
									'format' => $format,
									'current' => $paged,
									'total' => $max_paged,
									"prev_text" => "<span>" . $prev_text . "</span>",
									"next_text" => "<span>" . $next_text . "</span>",
									"link_before" => "",
									"link_after" => "",
									"before" => "",
									"after" => "",
									"mid_size" => 2,
									);
		echo paginate_links( $pagination_args );
		?>
		</div>
	</div>
	<?php
}

function ingenious_page_links(){
	$args = array(
	 'before'		   => ''
	,'after'			=> ''
	,'link_before'	  => '<span>'
	,'link_after'	   => '</span>'
	,'next_or_number'   => 'number'
	,'nextpagelink'	 =>  esc_html__("Next Page",'ingenious')
	,'previouspagelink' => esc_html__("Previous Page",'ingenious')
	,'pagelink'		 => '%'
	,'echo'			 => 0 );
	$pagination = wp_link_pages( $args );
	echo !empty( $pagination ) ? "<div class='pagination'><div class='page_links'>$pagination</div></div>" : "";
}

function ingenious_load_more ( $paged = 1, $max_paged = PHP_INT_MAX ){
	?>
		<a class="ingenious_button large ingenious_load_more alt" href="#"><?php echo esc_html__( "Load More", 'ingenious' ); ?></a>
	<?php
}

function ingenious_get_date_part ( $part = '' ){
	$part_val = '';
	$p_id = get_queried_object_id();
	$perm_struct = get_option( 'permalink_structure' );
	$use_perms = !empty( $perm_struct );
	$merge_date = get_query_var( 'm' );
	$match = preg_match( '#(\d{4})?(\d{1,2})?(\d{1,2})?#', $merge_date, $matches );
	switch ( $part ){
		case 'y':
			$part_val = $use_perms ? get_query_var( 'year' ) : ( isset( $matches[1] ) ? $matches[1] : '' );
			break;
		case 'm':
			$part_val = $use_perms ? get_query_var( 'monthnum' ) : ( isset( $matches[2] ) ? $matches[2] : '' );
			break;
		case 'd':
			$part_val = $use_perms ? get_query_var( 'day' ) : ( isset( $matches[3] ) ? $matches[3] : '' );
			break;
	}
	return $part_val;
}

function ingenious_get_all_flaticon_icons() {
	$cwsfi = get_option('cwsfi');
	if (!empty($cwsfi) && isset($cwsfi['entries'])) {
		return $cwsfi['entries'];
	} else {
		global $wp_filesystem;
		if( empty( $wp_filesystem ) ) {
			require_once( ABSPATH .'/wp-admin/includes/file.php' );
			WP_Filesystem();
		}
		$file = get_template_directory() . '/fonts/fi/flaticon.css';
		$fi_content = '';
		$out = '';
		if ( $wp_filesystem && $wp_filesystem->exists($file) ) {
			$fi_content = $wp_filesystem->get_contents($file);
			if ( preg_match_all( "/flaticon-((\w+|-?)+):before/", $fi_content, $matches, PREG_PATTERN_ORDER ) ){
				return $matches[1];
			}
		}
	}
}


function ingenious_body_font_styles (){
	$font_options_check = ingenious_get_option( "body_font" );
	$font_options = !empty( $font_options_check ) ? $font_options_check : array('font-family' => 'Roboto',
																				 'font-weight' => array('300','500','600'),
																				 'font-sub' => array('latin'),
																				 'font-type' => '',
																				 'color' => '#363636',
																				 'font-size' => '16px',
																				 'line-height' => '28px',
																				);
	$font_family = esc_attr( $font_options['font-family'] );
	$font_size = esc_attr( $font_options['font-size'] );
	$line_height = esc_attr( $font_options['line-height'] );
	$font_color = esc_attr( $font_options['color'] );
	$font_styles = "";
	$font_styles .= "body,
					.main_menu .cws_megamenu_item{
						" . ( !empty( $font_family ) ? "font-family: $font_family;" : "" ) . "
						" . ( !empty( $font_size ) ? "font-size: $font_size;" : "" ) . "
						" . ( !empty( $line_height ) ? "line-height: $line_height;" : "" ) . "
						" . ( !empty( $font_color ) ? "color: $font_color;" : "" ) . "
					}";
	$font_styles .= "#wp-calendar td#prev a:before,
					#wp-calendar td#next a:before,
					.widget #searchform .screen-reader-text:before,
					#search_bar_item input[name='s']{
						" . ( !empty($font_size ) ? "font-size:$font_size;" : "" ) . "
					}";
	$font_styles .= ".site_header#sticky.alt .main_menu .menu-item,
						.testimonial.without_image .author_info + .author_info:before{
						" . ( !empty( $font_color ) ? "color: $font_color;" : "" ) . "
					}";
	$font_styles .= ".site_header#sticky.alt .main_menu.sandwich .sandwich_switcher .ham,
					.site_header#sticky.alt .main_menu.sandwich .sandwich_switcher .ham:before,
					.site_header#sticky.alt .main_menu.sandwich .sandwich_switcher .ham:after{
						" . ( !empty( $font_color ) ? "background-color: $font_color;" : "" ) . "
					}";
	$font_styles .= ".widget ul>li.recentcomments:before,
					.widget ul>li.recentcomments:after{
						width: $line_height;
						height: $line_height;
					}
					.widget .menu .pointer{
						height: $line_height;
					}
					";
	$font_styles .= !empty( $line_height ) ? ".dropcap{
						line-height: -webkit-calc($line_height*1.85);
						line-height: -ms-calc($line_height*1.85);
						line-height: calc($line_height*1.85);
						width: -webkit-calc($line_height*1.85);
						width: -ms-calc($line_height*1.85);
						width: calc($line_height*1.85);
					}
					" : "";
	echo sprintf("%s", $font_styles);
}
add_action( 'ingenious_body_font_hook', 'ingenious_body_font_styles' );




	function ingenious_merge_fonts_options ( $fonts_arr = array(), $ind = 0 ){
		$r = $temp = $rem_inds = array();
		if ( !isset( $fonts_arr[ $ind ] ) ){
			return $fonts_arr;
		}
		$cur_font_opts = $fonts_arr[ $ind ];
		$cur_font_family = $cur_font_opts['font-family'];
		if ( empty( $cur_font_family ) ){
			$r = ingenious_merge_fonts_options( array_splice( $fonts_arr, $ind, 1 ), $ind );
		}
		else{
			for ( $i = $ind + 1; $i < count( $fonts_arr ); $i++ ){
				if ( $fonts_arr[$i]['font-family'] == $cur_font_family ){
					$temp['font-family'] = $cur_font_family;
					$temp['font-weight'] = $cur_font_opts['font-weight'];
					for ( $j = 0; $j < count(  $fonts_arr[$i]['font-weight'] ); $j ++ ){
						if ( !in_array( $fonts_arr[$i]['font-weight'][$j],  $temp['font-weight'] ) ){
							array_push( $temp['font-weight'], $fonts_arr[$i]['font-weight'][$j] );
						}
					}
					$temp['font-sub'] = $cur_font_opts['font-sub'];
					for ( $j = 0; $j < count(  $fonts_arr[$i]['font-sub'] ); $j ++ ){
						if ( !in_array( $fonts_arr[$i]['font-sub'][$j], $temp['font-sub'] ) ){
							array_push( $temp['font-sub'], $fonts_arr[$i]['font-sub'][$j] );
						}
					}
					$fonts_arr[$ind] = $temp;
					$r = ingenious_merge_fonts_options( array_splice( $fonts_arr, $i, 1 ), $ind );
				}
			}
			$r = ingenious_merge_fonts_options( $fonts_arr, $ind + 1 );
		}
		unset( $r['color'] );
		unset( $r['font-size'] );
		unset( $r['line-height'] );
		return $r;
	}

	function ingenious_render_fonts_url (){
		$url = "";
		$query_args = "";
		$body_font_opts_check = ingenious_get_option( "body_font" );
		$body_font_opts = !empty( $body_font_opts_check ) ? $body_font_opts_check : array('font-family' => 'Roboto',
																						 'font-weight' => array('300','500','600'),
																						 'font-sub' => array('latin'),
																						 'font-type' => '',
																						 'color' => '#363636',
																						 'font-size' => '16px',
																						 'line-height' => '28px',
																						);
		$menu_font_opts_check = ingenious_get_option( "menu_font" );
		$menu_font_opts = !empty( $menu_font_opts_check ) ? $menu_font_opts_check : array('font-family' => 'Catamaran',
																				 'font-weight' => array('700'),
																				 'font-sub' => array('latin'),
																				 'font-type' => '',
																				 'color' => '#363636',
																				 'font-size' => '15px',
																				 'line-height' => '36px',
																				);
		$header_font_opts_check = ingenious_get_option( "header_font" );
		$header_font_opts = !empty( $header_font_opts_check ) ? $header_font_opts_check : array('font-family' => 'Catamaran',
																				 'font-weight' => array('regular' , '700','800'),
																				 'font-sub' => array('latin'),
																				 'font-type' => '',
																				 'color' => '#363636',
																				 'font-size' => '28px',
																				 'line-height' => '39px',
																				);
		$fonts_opts = ingenious_merge_fonts_options( array( $body_font_opts, $menu_font_opts, $header_font_opts ) );
		if ( empty( $fonts_opts ) ) return $url;
		$fonts_urls = array( count( $fonts_opts ) );
		$subsets_arr = array();
		$base_url = "//fonts.googleapis.com/css";
		$url = "";
		for ( $i = 0; $i < count( $fonts_opts ); $i++ ){
			$fonts_urls[$i] = "" . $fonts_opts[$i]['font-family'];
			$fonts_urls[$i] .= !empty( $fonts_opts[$i]['font-weight'] ) ? ":" . implode( $fonts_opts[$i]['font-weight'], ',' ) : "";
			for ( $j = 0; $j < count( $fonts_opts[$i]['font-sub'] ); $j++ ){
				if ( !in_array( $fonts_opts[$i]['font-sub'][$j], $subsets_arr ) ){
					array_push( $subsets_arr, $fonts_opts[$i]['font-sub'][$j] );
				}
			}
		};
		$query_args = array(
			'family'	=> urlencode( implode( $fonts_urls, '|' ) )
		);
		if ( !empty( $subsets_arr ) ){
			$query_args['subset']	= urlencode( implode( $subsets_arr, ',' ) );
		}
		$url = add_query_arg( $query_args, $base_url );

		if ( 'off' !== _x( 'on', 'Google font: on or off', 'ingenious' ) ) {
			$gf_url = esc_url( $url );
			if ( !empty( $gf_url ) ) wp_enqueue_style( 'gf', $gf_url);
		}

	}

add_action( 'ingenious_render_fonts_url_hook', 'ingenious_render_fonts_url' );

function ingenious_menu_font_styles (){
	$font_options_check = ingenious_get_option( "menu_font" );
	$font_options = !empty( $font_options_check ) ? $font_options_check : array('font-family' => 'Catamaran',
																				 'font-weight' => array('700'),
																				 'font-sub' => array('latin'),
																				 'font-type' => '',
																				 'color' => '#000',
																				 'font-size' => '15px',
																				 'line-height' => '36px',
																				);
	$font_family = esc_attr( $font_options['font-family'] );
	$font_size = esc_attr( $font_options['font-size'] );
	$line_height = esc_attr( $font_options['line-height'] );
	$font_color = esc_attr( $font_options['color'] );
	$font_styles = "";
	$font_styles .= ".main_menu .menu-item,
					#mobile_menu .megamenu_item_column_title,
					#mobile_menu .widget_nav_menu .menu-item{
						" . ( !empty( $font_family ) ? "font-family: $font_family;" : "" ) . "
						" . ( !empty( $font_size ) ? "font-size: $font_size;" : "" ) . "
						" . ( !empty( $line_height ) ? "line-height: $line_height;" : "" ) . "
						" . ( !empty( $font_color ) ? "color: $font_color;" : "" ) . "
					}
					#sticky_box .cws_sticky_extra .menu_search_button,
					#sticky_box .cws_sticky_extra .woo_icon,
					#mobile_menu > .menu-item.current_page_ancestor > span,
					#mobile_menu > .menu-item.current_page_ancestor > a,
					#mobile_menu > .menu-item.current_page_ancestor
					{
						" . ( !empty( $font_color ) ? "color: $font_color;" : "" ) . "
					}
					";
	$font_styles .= ".main_menu.sandwich .sandwich_switcher .ham,
					.main_menu.sandwich .sandwich_switcher .ham:before,
					.main_menu.sandwich .sandwich_switcher .ham:after,
					#mobile_header .sandwich_switcher .ham,
					#mobile_header .sandwich_switcher .ham:before,
					#mobile_header .sandwich_switcher .ham:after{
						background-color: #1c3545;
					}";
	$font_styles .= ".main_menu > .menu-item + .menu-item:before{
						" . ( !empty( $font_size ) ? "height:$font_size;" : "" ) . "
					}";
	$font_styles .= ".cws_megamenu_item .megamenu_item_column_title .pointer{
						" . ( !empty( $font_size ) ? "font-size:$font_size;" : "" ) . "
					}";
	$font_styles .= "#mobile_menu .menu-item:hover{
						" . ( !empty( $font_color ) ? "color:$font_color;" : "" ) . "
					}";
	echo sprintf("%s", $font_styles);
}
add_action( 'ingenious_menu_font_hook', 'ingenious_menu_font_styles' );

function ingenious_header_font_styles (){
	$font_options_check = ingenious_get_option( "header_font" );
	$font_options = !empty( $font_options_check ) ? $font_options_check : array('font-family' => 'Catamaran',
																				 'font-weight' => array('regular' , '400','600','700','800'),
																				 'font-sub' => array('latin'),
																				 'font-type' => '',
																				 'color' => '#363636',
																				 'font-size' => '28px',
																				 'line-height' => '39px',
																				);
	$font_family = esc_attr( $font_options['font-family'] );
	$font_size = esc_attr( $font_options['font-size'] );
	$line_height = esc_attr( $font_options['line-height'] );
	$font_color = esc_attr( $font_options['color'] );
	$font_styles = "";
	$font_styles .= ".widgettitle{
						" . ( !empty( $font_family ) ? "font-family: $font_family;" : "" ) . "
						" . ( !empty( $font_size ) ? "font-size: $font_size;" : "" ) . "
						" . ( !empty( $line_height ) ? "line-height: $line_height;" : "" ) . "
						" . ( !empty( $font_color ) ? "color: $font_color;" : "" ) . "
					}";
	$font_styles .= ".widgettitle + .carousel_nav{
						" . ( !empty( $line_height ) ? "line-height: $line_height;" : "" ) . "
	}
	";
	$font_styles .= "h1, h2, h3, h4, h5, h6{
						" . ( !empty( $font_family ) ? "font-family: $font_family;" : "" ) . "
						" . ( !empty( $font_color ) ? "color: $font_color;" : "" ) . "
					}";
	$font_styles .= "ol, blockquote, .widget ul a,
					.staff_post.posts_grid_post:hover .post_title{
						" . ( !empty( $font_color ) ? "color: $font_color;" : "" ) . "
	}";
	$font_styles .= "
					@media screen and ( min-width: 981px ){
						#page.single_sidebar .staff_posts_grid.posts_grid_2 .staff_post_title.posts_grid_post_title,
						#page.double_sidebar .staff_posts_grid.posts_grid_2 .staff_post_title.posts_grid_post_title{
							" . ( !empty( $font_color ) ? "color: $font_color;" : "" ) . "
						}
					}
	";
	$font_styles .= "
					@media screen and ( max-width: 479px ){
						.staff_post_title.posts_grid_post_title{
							" . ( !empty( $font_color ) ? "color: $font_color;" : "" ) . "
						}
					}
	";
	echo sprintf("%s", $font_styles);
}
add_action( 'ingenious_header_font_hook', 'ingenious_header_font_styles' );

if ( !function_exists( "ingenious_custom_colors_styles" ) ){
	function ingenious_custom_colors_styles (){
		$pid = get_the_ID();
		if (function_exists('cws_core_cwsfw_get_post_meta')) {
			$stored_meta = cws_core_cwsfw_get_post_meta( $pid );
		}
		$stored_meta = isset( $stored_meta[0] ) ? $stored_meta[0] : array();
		$page_color_check =  isset($stored_meta[ 'page_color_override' ]) ? $stored_meta[ 'page_color_override' ] : '';
		$page_color =  isset($stored_meta[ 'page_color' ]) ? $stored_meta[ 'page_color' ] : '';
		$theme_custom_color_check = esc_attr( ingenious_get_option( 'theme_color' ) );
		if ($page_color_check == '1') {
			$theme_custom_color = $page_color;
		} else {
			$theme_custom_color = !empty ( $theme_custom_color_check ) ? $theme_custom_color_check : '#59ab66';
		}
		$theme_helper_color_check = esc_attr( ingenious_get_option( 'theme_helper_color' ) );
		$theme_helper_color = !empty ( $theme_helper_color_check ) ? $theme_helper_color_check : '#ff6c3a';

		/* Style for highlight menu current
		#main_menu.main_menu .menu-item.current-menu-item,
		#main_menu.main_menu > .menu-item.current_page_ancestor,
		*/
		$custom_colors_styles = "";
		$custom_colors_styles .= "a,
									ul li:before,
									ul.custom_icon_style .list_list,
									.widget ul a:hover,
									h1 > a:hover,
									h2 > a:hover,
									h3 > a:hover,
									h4 > a:hover,
									h5 > a:hover,
									h6 > a:hover,
									.post_posts_grid_post_content.read_more_alt .more-link:hover,
									#comments .comments_number,
									.wp-playlist-light .wp-playlist-current-item:before,
									.wp-playlist-light .wp-playlist-tracks .wp-playlist-playing,
									.staff_post_terms.single_post_terms,
									.staff_social_links.post_social_links a:hover,
									#footer_widgets .widget ul a:hover,
									#footer_social .social_icon:hover,
									.banner_icon,
									.ingenious_services_column:hover
									.testimonial .author_status,
									.cws_twitter .cws_twitter_icon i,
									.select2-results .select2-highlighted,
									.widget_icon,
									span.wpcf7-form-control-wrap:first-of-type:last-of-type:first-child input.wpcf7-validates-as-required.wpcf7-not-valid + .wpcf7-not-valid-tip:after,
									.post_posts_grid_post_content.read_more_alt
									.more-link i,
									.comment-reply-link,
									.widget #searchform .screen-reader-text.hover,
									.widget_social .social_icon:hover,
									.widget.custom_color .widget_social .social_icon:hover,
									.post_title.post_post_title a:hover,
									.ingenious_process_title .process_number,
									.ingenious_process_icon,
									.small_type .latest_post_post:hover .latest_post_post_date .date,
									.latest_post_post .latest_post_post_media .link:hover,
									.hexagon_grid .pic .links a:hover,
									.ingenious_button,
									.ingenious_button.alt:not(.none_anim):hover,
									.ingenious_button.hex_style.alt_hex:hover,
									.post_info_wrap .info_icon,
									.post_info_wrap i,
									.comment-reply-link .reply_icon,
									.post_post_header > a:hover,
									.widget ul>li:before,
									.cws_megamenu_item .megamenu_item_column_title,
									.main_menu .cws_megamenu_item .widget .menu .menu-item > a:before,
									.ingenious_button.shadow:hover,
									.pricing_plan_price,
									.dropcap:not(.dropcap_fill),
									.ingenious_button.alt:hover,
									.main_menu .sub-menu .menu-item.current-menu-item,
									
									#main_menu.main_menu .sub-menu > .menu-item.current-menu-ancestor,
									.main_menu > .menu-item.current_page_ancestor,

									#mobile_menu > .menu-item.current_page_ancestor.active .pointer,

									.main_menu .sub-menu > .menu-item.current-menu-ancestor,
									.large_type .latest_post_post .latest_post_post_data .date,
									
									.ingenious_button.only_icon i,
									.post_post_header .info_icon,
									.post_post_header .like .sl-icon,
									.post_post_header .like a:hover,
									.post_post_header .meta_wrapper a:not(.comments_link),
									.widget.widget_categories ul>li .post_count,
									.testimonial .testimonial_name,
									.filter_wrap .filter.active h5,
									.widget .widget_post_terms a,
									.post_media .quote-wrap .author,
									.widget .parent_archive .widget_archive_opener,
									.widget .menu-item-has-children .opener
									{
			color: $theme_custom_color;
		}
								.ingenious_services_column.hovered:hover .ingenious_services_icon svg,
								.ingenious_services_column.icon_alt .ingenious_services_icon svg{
			fill: $theme_custom_color;
		}
								hr:before,
								.post_terms .v_sep,
								blockquote{
			border-left-color: $theme_custom_color;
		}
								abbr,
								.filter_wrap .lavalamp-object{
			border-bottom-color: $theme_custom_color;
		}
								mark,
								.ingenious_button:not(.none_anim):hover,
								.more-link:hover,
								input[type='submit']:hover,
								.widget ul>li.recentcomments:after,
								.widget .menu .pointer:before,
								.widget .menu .pointer:after,
								.widget .menu .menu-item.active,
								.widget .menu .menu-item.li_active,
								.widget .menu .menu-item:hover,
								a[rel^=\"attachment\"]:before,
								.gallery .gallery-item a:before,
								.wp-playlist-light .wp-playlist-current-item,
								.ingenious_button.alt,
								.ingenious_services_divider,
								hr.posts_grid_small_divider,
								input[type='submit'],
								hr.short,
								.testimonial.ingenious_module figcaption:before,
								.process_number_wrap,
								.filter_wrap .filter.active:before,
								.testimonial.ingenious_module .quote q:after,
								.vc_tta.vc_tta-accordion.vc_general .vc_tta-panel-body:before,
								.vc_tta.vc_general.vc_tta-accordion .vc_tta-panel-title:before,
								.vc_tta.vc_general.vc_tta-accordion .vc_tta-panel-title:after,
								.vc_tta.vc_general.vc_tta-tabs.vc_tta-tabs-position-top .vc_tta-tab.vc_active,
								.portfolio_item_post .side_load .load_bg,
								.widget .tagcloud a,
								#wp-calendar td:not(#prev):not(#next) a,
								#wp-calendar td:not(#prev):not(#next) a:before,
								#wp-calendar td:not(#prev):not(#next) a:after,
								.main_menu .sub-menu .menu-item > a:after,
								.ingenious_button.swipe_left:before,
								.ingenious_button.swipe_right:before,
								.ingenious_button.swipe_top:before,
								.ingenious_button.swipe_bot:before,
								.ingenious_button.smoosh:before, 
								.ingenious_button.smoosh:after,
								.ingenious_button.collision:before, 
								.ingenious_button.collision:after,
								.ingenious_button.pos_aware:active,
								.ingenious_button.pos_aware span,
								.dropcap.dropcap_fill,
								.widget .woocommerce-product-search .screen-reader-text,
								.ingenious_pb_progress,
								.sidebar .widget .widgettitle:after,
								.main_menu > .menu-item > a:before,
								.tabs_alternative.vc_tta.vc_general.vc_tta-tabs.vc_tta-tabs-position-top .vc_tta-panel-heading .vc_tta-panel-title,
								.staff_post_media:hover .staff_hover_content:before,
								.staff_social_links.single_social_links,
								.sec_desc .benefits_media:hover .benefits_hover_content:before,
								.benefits_icon .icon,
								.post_post_media .date,
								.post_post_media .date:before,
								table thead tr:first-child,
								.widget-ingenious-about .ingenious_button_wrapper .ingenious_button:hover,
								.widget-ingenious-about .image_wrap:before,
								.testimonial .testimonial_name:before{
			background-color: $theme_custom_color;
		}
								.ingenious_button,
								.more-link:hover,
								button,
								.latest_tweets .tweet:before,
								.cws_twitter .cws_twitter_icon i,
								.cta_icon,
								span.wpcf7-form-control-wrap:first-of-type:last-of-type:first-child input.wpcf7-not-valid,
								.ingenious_button.border_out:before,
								.ingenious_button.border_out:after,
								.ingenious_button.border_out_2:before,
								.ingenious_button.border_out_2:after,
								.ingenious_button.shadow,
								.dropcap.dropcap_border,
								.widget .woocommerce-product-search .screen-reader-text,
								.select2-container .select2-selection--single,
								input[type='submit'],
								.widget .tagcloud a,
								.vc_tta.vc_general .vc_tta-panel .vc_tta-panel-title > a:before,
								.widget-ingenious-about .ingenious_button_wrapper,
								.woocommerce .checkout-button,
								.ingenious_button:hover{
			border-color: $theme_custom_color;
		}
								.main_menu > .menu-item >.sub-menu,
								.ingenious_services_column,
								.ingenious_button.close_diagonal:after{
			border-top-color: $theme_custom_color;
		}
								.ingenious_button.swipe_diagonal:before,
								.ingenious_button.close_diagonal:before{
			border-bottom-color: $theme_custom_color;
		}
								.ingenious_button.slice:after,
								body:not(.rtl) .post_post_header .meta_wrapper a:not(.comments_link):before,
								body:not(.rtl) .widget .tagcloud a:before
								{
			border-right-color: $theme_custom_color;
		}
								body.rtl .widget .tagcloud a:before,
								body.rtl .post_post_header .meta_wrapper a:not(.comments_link):before
								{
			border-left-color: $theme_custom_color;
		}
								.ingenious_button.slice:before{
			border-left-color: $theme_custom_color;
		}
								.ingenious_button.shadow{
			box-shadow: 0 0 40px 40px $theme_custom_color inset, 0 0 0 0 $theme_custom_color;
		}
								.ingenious_button.shadow:hover{
			box-shadow: 0 0 10px 0 $theme_custom_color inset, 0 0 10px 1px $theme_custom_color;
		}
								.ingenious_button.shadow_alt:hover{
			box-shadow: 0 0 40px 40px $theme_custom_color inset, 0 0 10px 1px $theme_custom_color;
		}
								.post_post_header .meta_wrapper a:not(.comments_link),
								.single-product .product_meta span > a{
			background-color:rgba(" . ingenious_Hex2RGBA( $theme_custom_color, '0.2' ) . ");						
		}
								#mobile_menu_wrapper,
								#mobile_header.site_header.sandwich_active{
			background-color:rgba(" . ingenious_Hex2RGBA( $theme_custom_color, '0.9' ) . ");						
		}		
		";
		$custom_colors_styles .= ".comment-form-rating .stars .stars-active,
									.post_post_terms,
									.post_post_terms a,
									.woocommerce-page .woocommerce .checkout-button,
									.latest_post_list_more{
			color: $theme_custom_color;
		}
									hr:before,
									.ingenious_button.button_color_2:hover,
									.ingenious_button.alt.button_color_2,
									.owl-controls .owl-page.active{
			background-color: $theme_custom_color;
		}
									ingenious_button.button_color_2{
			border-color: $theme_custom_color;
		}
		";
		$custom_colors_styles .= ".vc_toggle .vc_toggle_icon,
									.ingenious_button.button_color_3,
									span.wpcf7-form-control-wrap:first-of-type:last-of-type:first-child + input[type='submit'],
									#banner_404_away .ingenious_button{
			border-color: $theme_custom_color;
		}
								.hex:before,
								.menu_search_wrap .search-field{
			border-bottom-color: $theme_custom_color;
		}
								hr:before{
			border-right-color: $theme_custom_color;
		}
								.hex:after{
			border-top-color: $theme_custom_color;
		}
								.vc_toggle.vc_toggle_active .vc_toggle_icon,
								.ingenious_button.button_color_3:hover,
								.ingenious_button.alt.button_color_3,
								span.wpcf7-form-control-wrap:first-of-type:last-of-type:first-child + input[type='submit'],
								.post_post.sticky > .post_post_header,
								.hex,
								#banner_404_away .ingenious_button:hover,
								.woo_mini_count{
			background-color: $theme_custom_color;
		}
								#wp-calendar td#prev a:hover:before,
								#wp-calendar td#next a:hover:before,
								.vc_toggle .vc_toggle_icon,
								.vc_toggle.vc_toggle_active .vc_toggle_title > h4{
			color: $theme_custom_color;
		}
								.hex{
			box-shadow: 0 0 20px $theme_custom_color, 0 0 20px $theme_custom_color;
		}";
		$custom_colors_styles .= "
		.wpcf7-form .wpcf7-submit.orange{
			background-color: $theme_helper_color;
		}
		.wpcf7-form .wpcf7-submit.orange,
		.widget-ingenious-about .ingenious_button_wrapper .ingenious_button,
		.more-link{
			border-color: $theme_helper_color;
		}
		.wpcf7-form .wpcf7-submit.orange:hover{
			color: $theme_helper_color;
		}
		.widget-ingenious-about .ingenious_button_wrapper .ingenious_button,
		.more-link{
			background: $theme_helper_color;
		}
		";

		echo sprintf("%s", $custom_colors_styles);
	}
}
add_action( 'ingenious_custom_colors_hook', 'ingenious_custom_colors_styles' );

function ingenious_header_styles (){
	$p_id = get_queried_object_id();
	$post_type = get_post_type( $p_id );
	$header_font_color = '';
	if (function_exists('cws_core_cwsfw_get_post_meta')) {
		$post_meta = cws_core_cwsfw_get_post_meta( get_the_ID() );
	}
	$post_meta = isset( $post_meta[0] ) ? $post_meta[0] : array();
	if (function_exists('is_woocommerce')) {
		if (is_woocommerce()) {
			$header_font_color_check = esc_attr( ingenious_get_option( 'woo_header_font_color' ) );
			$header_bg_color_check = esc_attr( ingenious_get_option( 'woo_header_bg_color' ) );
			$menu_font_color_check = esc_attr( ingenious_get_option( 'woo_menu_font_color' ) );
		}
	} else {
		$header_font_color_check = esc_attr( ingenious_get_option( 'header_font_color' ) );
		$header_bg_color_check = esc_attr( ingenious_get_option( 'header_bg_color' ) );
		$menu_font_color_check = esc_attr( ingenious_get_option( 'menu_font_color' ) );
	}
	$header_font_color = !empty ( $header_font_color_check ) ? $header_font_color_check : '#ffffff';
	$header_bg_color = !empty ( $header_bg_color_check ) ? $header_bg_color_check : '#000000';
	$menu_font_color = !empty ( $menu_font_color_check ) ? $menu_font_color_check : '#000000';
	$header_page_meta_vars 	= ingenious_get_page_meta_var( array( 'header' ) );
	$page_override_header 	= !empty( $header_page_meta_vars );
	$customize_menu 		= (bool)ingenious_get_option( 'customize_menu' );

	$menu_spacings = ingenious_get_option( 'menu_spacings' );
	$menu_items_spacings = ingenious_get_option( 'menu_items_spacings' );

	$header_covers_slider 	= false;
	$menu_opacity 			= '';
	$menu_bg_color 			= '';
	$header_bg_opacity 		= '';
	$page_title_spacings 	= '';
	if ( $page_override_header && $GLOBALS['ingenious_page_meta']['header']['header_override'] ){
		$header_covers_slider 	= isset( $header_page_meta_vars['header_covers_slider'] ) ? (bool)$header_page_meta_vars['header_covers_slider'] : $header_covers_slider;
		$menu_opacity 			= isset( $header_page_meta_vars['menu_opacity'] ) ? $header_page_meta_vars['menu_opacity'] : $menu_opacity;

		$header_overlay_type 	= isset( $header_page_meta_vars['header_overlay_type'] ) ? $header_page_meta_vars['header_overlay_type'] : '';
		$add_pattern 			= isset( $header_page_meta_vars['add_pattern'] ) ? $header_page_meta_vars['add_pattern'] : '';
		$default_pattern_image 	= isset( $header_page_meta_vars['default_pattern_image'] ) ? $header_page_meta_vars['default_pattern_image'] : '';

		$header_bg_color 		= isset( $header_page_meta_vars['header_bg_color'] ) ? $header_page_meta_vars['header_bg_color'] : '';
		$header_bg_opacity 		= isset( $header_page_meta_vars['header_bg_opacity'] ) ? $header_page_meta_vars['header_bg_opacity'] : '';
		$header_bg_overlay_gradient = isset( $header_page_meta_vars['header_bg_overlay_gradient'] ) ? $header_page_meta_vars['header_bg_overlay_gradient'] : '';

		$page_title_spacings 		= isset( $header_page_meta_vars['page_title_spacings'] ) ? $header_page_meta_vars['page_title_spacings'] : $page_title_spacings;
		$menu_font_color 		= isset( $header_page_meta_vars['menu_font_color'] ) ? $header_page_meta_vars['menu_font_color'] : $menu_font_color;
		$menu_bg_color 			= isset( $header_page_meta_vars['menu_bg_color'] ) ? $header_page_meta_vars['menu_bg_color'] : $menu_bg_color;
		$title_space_top = isset($page_title_spacings['top']) ? $page_title_spacings['top'] : '';
		$title_space_bot = isset($page_title_spacings['bottom']) ? $page_title_spacings['bottom'] : '';
	}
	else{
		$menu_font_color 		= ingenious_get_option( 'menu_font_color' );
		$menu_opacity 			= ingenious_get_option( 'menu_opacity' );

		$header_overlay_type 	= ingenious_get_option( 'header_overlay_type' );
		$add_pattern 			= ingenious_get_option( 'add_pattern' );
		$default_pattern_image	= ingenious_get_option( 'default_pattern_image' );
		$header_bg_color 		= ingenious_get_option( 'header_bg_color' );
		$header_bg_opacity 		= ingenious_get_option( 'header_bg_opacity' );
		$header_bg_overlay_gradient = ingenious_get_option( 'header_bg_overlay_gradient' );

		$menu_bg_color 			= ingenious_get_option( 'menu_bg_color' );
	}

	if (function_exists('is_woocommerce')) {
		if (is_woocommerce()) {
			$menu_font_color 		= ingenious_get_option( 'woo_menu_font_color' );
			$menu_opacity 			= ingenious_get_option( 'woo_menu_opacity' );

			$header_overlay_type 	= ingenious_get_option( 'woo_header_overlay_type' );
			$add_pattern 			= ingenious_get_option( 'woo_add_pattern' );
			$default_pattern_image	= ingenious_get_option( 'woo_default_pattern_image' );
			$header_bg_color 		= ingenious_get_option( 'woo_header_bg_color' );
			$header_bg_opacity 		= ingenious_get_option( 'woo_header_bg_opacity' );
			$header_bg_overlay_gradient = ingenious_get_option( 'woo_header_bg_overlay_gradient' );

			$header_covers_slider 	= ingenious_get_option( 'woo_header_covers_slider' );
		}
	}
	$menu_opacity_css = isset($menu_opacity) ? strval( (int)$menu_opacity / 100 ) : "";
	$header_bg_opacity_css = isset($header_bg_opacity) ? strval( (int)$header_bg_opacity / 100 ) : "";
	$post_thumb_url = "";
	$post_thumb_obj = "";
	if ( has_post_thumbnail () && !(in_array( $post_type, array( 'post', 'cwsportfolio', 'cwsstaff', 'product', 'lp_course' ) ) || is_archive()) ){
		$post_thumb_id = get_post_thumbnail_id( $p_id );
		$post_thumb_obj = !empty( $post_thumb_id ) ? wp_get_attachment_image_src( $post_thumb_id, 'full' ) : array();
		$post_thumb_url = isset( $post_thumb_obj[0] ) ? $post_thumb_obj[0] : "";
	}
	else{
		$post_thumb_obj = ingenious_get_option( 'default_header_image' );

		if (isset($GLOBALS['ingenious_page_meta']['header']['default_header_image']) && !empty($GLOBALS['ingenious_page_meta']['header']['default_header_image']['image']['src'])){
			$post_thumb_obj = $GLOBALS['ingenious_page_meta']['header']['default_header_image'];
		}
	}

	$woo_img_obj = ingenious_get_option('woo_default_header_image');
	if (function_exists('is_woocommerce')) {
		if (is_woocommerce() && isset($woo_img_obj) && !empty($woo_img_obj['image']['src'])){
			$post_thumb_obj = $woo_img_obj;
		}	
	}
	$header_styles = "";

	if ($header_overlay_type == 'color'){
		if ( !empty($header_bg_color) && isset($header_bg_opacity) ) {
			$header_styles .= "
				#header_img_bg:before{
					background-color:rgba(" . ingenious_Hex2RGBA( $header_bg_color, $header_bg_opacity_css ) . ");
				}
			";
		}
	} elseif ($header_overlay_type == 'gradient') {
		$header_bg_overlay_gradient_css = ingenious_render_gradient_rules($header_bg_overlay_gradient);
		$header_bg_overlay_gradient_css .= "opacity:".esc_attr($header_bg_opacity_css).";";
		$header_styles .= "
			#header_img_bg:before{
				".esc_attr($header_bg_overlay_gradient_css)."
			}
		";
	}

	if (!empty($menu_spacings)){
		if (!empty($menu_spacings['top'])){			
			$header_styles .= ".main_menu > .menu-item{padding-top:".esc_attr($menu_spacings['top'])."px;}";
		}
		if (!empty($menu_spacings['bottom'])){			
			$header_styles .= ".main_menu > .menu-item{padding-bottom:".esc_attr($menu_spacings['bottom'])."px;}";
		}
	}

	if (!empty($menu_items_spacings)){
		$header_styles .= ".main_menu > .menu-item{padding-left:".esc_attr($menu_items_spacings)."px; padding-right:".esc_attr($menu_items_spacings)."px;}";
	}

	if ($add_pattern == '1' && isset($default_pattern_image)){
		$header_pattern_css = ingenious_print_background($default_pattern_image);
		$header_styles .= "
		#header_img_bg:after{
			".esc_attr($header_pattern_css)."
		}
		";
	}

	$header_styles .= "#page_title_section #page_title,
							#page_title_section .bread-crumbs,
							#page_title_section .bread-crumbs .delimiter{
		color: $header_font_color;
	}";
	if (isset($post_meta['header_override']) && ($post_meta['header_override'] == 1) ) {
		if ( $title_space_top !== '' && is_numeric($title_space_top) ) {
			$header_styles .= "#page_title_section .page_title_content{
				padding-top: {$title_space_top}px !important;
			}";
		}
		if ( $title_space_bot !== '' && is_numeric($title_space_bot) ) {
			$header_styles .= "#page_title_section .page_title_content{
				padding-bottom: {$title_space_bot}px !important;
			}";
		}
	}
	$header_styles .= "
	#main_menu.sandwich .sandwich_switcher .ham,
	#main_menu.sandwich .sandwich_switcher .ham:before,
	#main_menu.sandwich .sandwich_switcher .ham:after,
	#mobile_header .sandwich_switcher .ham,
	#mobile_header .sandwich_switcher .ham:before,
	#mobile_header .sandwich_switcher .ham:after{
		background-color: $menu_font_color;
	}";
	if ( !empty($menu_bg_color) ){
		$header_styles .=  "
			#site_header,
			#mobile_header{
				background-color:rgba(" . ingenious_Hex2RGBA( $menu_bg_color, $menu_opacity_css ) . ");
		}";
	}
	$header_styles .= "
	.woo_minicart_bar_item .bar_element,
	.menu_wrapper .menu_search_button,
	#main_menu > .menu-item,
	.menu_search_button,
	.lang_bar.wpml_icon .wpml-ls-legacy-dropdown ul>.wpml-ls-item.wpml-ls-current-language:before
	{
		color: $menu_font_color;
	}

	.main_menu .lavalamp-object:after,
	.main_menu > .menu-item > a:after,
	.main_menu > .menu-item > span.mega_menu_line:after
	{
		background-color: ".esc_attr($menu_font_color).";
	}

	.main_menu .lavalamp-object:before,
	.main_menu > .menu-item > a:before,
	.main_menu > .menu-item > span.mega_menu_line:before
	{
		background-color:rgba(" . ingenious_Hex2RGBA( $menu_font_color, 0.3 ) . ");
	}	

	.main_menu > .wpml-ls-slot-main-menu:before{
		border-right-color: $menu_font_color;
	}
	";
	if ( !empty( $post_thumb_obj ) ){
		$header_background_css = ingenious_print_background($post_thumb_obj);
		$header_styles .= "
		#header_img_bg{
			".esc_attr($header_background_css)."
		}
		";
	}
/*	if (function_exists('is_woocommerce')) {
		if (is_woocommerce()) {
			if ( !empty( $woo_img_url ) ){
				$header_styles .= "
				#page_title_section{
					background-image: url($woo_img_url);
				}
				";
			}
		}
	}*/
	echo sprintf("%s", $header_styles);
}
add_action( 'ingenious_header_styles_hook', 'ingenious_header_styles' );

function ingenious_footer_widgets_styles (){
	$post_thumb_obj 	= ingenious_get_option( 'default_footer_image' );
	$post_thumb_url 	= isset( $post_thumb_obj['src'] ) ? $post_thumb_obj['src'] : "";
	$footer_bg_color 	= ingenious_get_option( 'footer_bg_color' );
	$footer_bg_color 	= esc_attr( $footer_bg_color );

	$footer_bg_opacity 	= ingenious_get_option( 'footer_bg_opacity' );
	$footer_bg_opacity 	= esc_attr( $footer_bg_opacity );
	$footer_bg_opacity = (int) $footer_bg_opacity / 100;

	$footer_font_color	= ingenious_get_option( 'footer_font_color' );
	$footer_font_color 	= esc_attr( $footer_font_color );
	$footer_title_color	= ingenious_get_option( 'footer_title_color' );
	$footer_title_color = esc_attr( $footer_title_color );
	ob_start();

	echo "
		#footer{
			background-image: url(" . esc_url($post_thumb_url) . ");
		}
		#footer_widgets_container,
		.widget_post_terms a{
			color:			$footer_font_color;		
		}
		#footer_widgets .widgettitle > span{
			color:			$footer_title_color;
		}
		#footer_widgets .footer_wrapper{
			background-color:rgba(" . ingenious_Hex2RGBA( $footer_bg_color, $footer_bg_opacity ) . ");
		}
		#footer_widgets .carousel_nav > *{
			color: 			$footer_font_color;
			border-color:	$footer_font_color;
		}
		#footer_widgets h1,
		#footer_widgets h2,
		#footer_widgets h3,
		#footer_widgets h4,
		#footer_widgets h5,
		#footer_widgets h6,
		#footer_widgets i,
		#footer_widgets .carousel_nav > *:hover,
		#footer_widgets .widget ul a,
		#footer_widgets .widget.custom_color input[type='submit']:hover,
		#footer_widgets .widget input,
		#footer_widgets .widget textarea{
			color:			$footer_title_color;
		}
		#footer_widgets .widget_icon{
			color: $footer_bg_color !important;
		}
		#footer_widgets .carousel_nav > *:hover{
			border-color:	$footer_title_color;
		}
		#footer_widgets .widget_header .carousel_nav > *:hover{
			background-color: $footer_title_color;
		}
	";
	$styles = ob_get_clean();
	if ( is_page() ){
		$footer_sb = ingenious_get_page_meta_var ( array( 'footer', 'footer_sb_top' ) );
	}
	else{
		$footer_sb = ingenious_get_option( 'footer_sb' );
	}
	if ( is_active_sidebar( $footer_sb ) ){
		echo sprintf("%s", $styles);
	}
}
add_action( 'ingenious_footer_widgets_styles_hook', 'ingenious_footer_widgets_styles' );

function ingenious_footer_copyrights_styles (){
	$copyrights_bg_color = ingenious_get_option( 'copyrights_bg_color' );
	$copyrights_bg_color = esc_attr( $copyrights_bg_color );

	$copyrights_bg_opacity 	= ingenious_get_option( 'copyrights_bg_opacity' );
	$copyrights_bg_opacity 	= esc_attr( $copyrights_bg_opacity );
	$copyrights_bg_opacity = (int) $copyrights_bg_opacity / 100;

	$copyrights_font_color = ingenious_get_option( 'copyrights_font_color' );
	$copyrights_font_color = esc_attr( $copyrights_font_color );
	ob_start();
	if (!empty($copyrights_bg_color) || !empty($copyrights_font_color)) {
		echo "
			#site_footer,
			#footer{
				background-color:rgba(" . ingenious_Hex2RGBA( $copyrights_bg_color, $copyrights_bg_opacity ) . ");
				color: $copyrights_font_color;
			}
			#footer_social .social_icon{
				color: $copyrights_font_color;
			}
		";
	}
	$styles = ob_get_clean();
	echo sprintf("%s", $styles);
}
add_action( 'ingenious_footer_copyrights_styles_hook', 'ingenious_footer_copyrights_styles' );

function ingenious_front_dynamic_styles (){
	ob_start();
	echo "
		#document > #wpadminbar{
			margin-top: auto;
		}
	";
	echo ob_get_clean();
}
add_action( 'ingenious_front_dynamic_styles_hook', 'ingenious_front_dynamic_styles' );

function ingenious_get_sidebars() {
	if ( is_home() ){
		$sidebar_pos = ingenious_get_option( 'def-home-layout' );
		$sidebar1 = ingenious_get_option( 'def-home-sidebar1' );
		$sidebar2 = ingenious_get_option( 'def-home-sidebar2' );
	}
	else if ( is_front_page() ){
		$p_id = get_queried_object_id ();
		if (function_exists('cws_core_cwsfw_get_post_meta')) {
			$ingenious_stored_meta = cws_core_cwsfw_get_post_meta( $p_id );
		}
		$sidebar1 = $sidebar2 = $sidebar_pos = $sb_block = '';
		$ingenious_stored_meta[0]['sb_layout'] =  !empty($ingenious_stored_meta[0]['sb_layout']) ? $ingenious_stored_meta[0]['sb_layout'] : '';
		if ( isset( $ingenious_stored_meta[0] ) ) {
			$sidebar_pos = $ingenious_stored_meta[0]['sb_layout'];
			if ( $sidebar_pos == 'default' ) {
				$sidebar_pos = ingenious_get_option( 'def-home-layout' );
				$sidebar1 = ingenious_get_option( 'def-home-sidebar1' );
				$sidebar2 = ingenious_get_option( 'def-home-sidebar2' );

			} else {
				$sidebar1 = isset( $ingenious_stored_meta[0]['sidebar1'] ) ? $ingenious_stored_meta[0]['sidebar1'] : '';
				$sidebar2 = isset( $ingenious_stored_meta[0]['sidebar2'] ) ? $ingenious_stored_meta[0]['sidebar2'] : '';
			}
		} else {
			$sidebar_pos = ingenious_get_option( 'def-home-layout' );
			$sidebar1 = ingenious_get_option( 'def-home-sidebar1' );
			$sidebar2 = ingenious_get_option( 'def-home-sidebar2' );
		}
	}
	else if ( is_category() || is_tag() || is_archive() ) {
		$sidebar_pos = ingenious_get_option( 'def-blog-layout' );
		$sidebar1 = ingenious_get_option( 'def-blog-sidebar1' );
		$sidebar2 = ingenious_get_option( 'def-blog-sidebar2' );
	} else if ( is_search() ) {
		$sidebar_pos = ingenious_get_option( 'def-page-layout' );
		$sidebar1 = ingenious_get_option( 'def-page-sidebar1' );
		$sidebar2 = ingenious_get_option( 'def-page-sidebar2' );
	}else if ( is_single() ) {
		$p_id = get_queried_object_id ();
		$post_type = get_post_type($p_id);
		if( in_array( $post_type, array( 'attachment', 'cwsportfolio', 'cwsstaff' ) ) ){
			$sidebar_pos = ingenious_get_option("def-page-layout");
			$sidebar1 = ingenious_get_option("def-page-sidebar1");
			$sidebar2 = ingenious_get_option("def-page-sidebar2");
		}else if ( in_array( $post_type, array( 'post', 'attachment' ) ) ){
			$sidebar_pos = ingenious_get_option("def-blog-layout");
			$sidebar1 = ingenious_get_option("def-blog-sidebar1");
			$sidebar2 = ingenious_get_option("def-blog-sidebar2");
		}else{
			$sidebar_pos = ingenious_get_option("def-page-layout");
			$sidebar1 = ingenious_get_option("def-page-sidebar1");
			$sidebar2 = ingenious_get_option("def-page-sidebar2");
		}
	}
	else if ( is_tax() ){
		$sidebar_pos = ingenious_get_option("def-page-layout");
		$sidebar1 = ingenious_get_option("def-page-sidebar1");
		$sidebar2 = ingenious_get_option("def-page-sidebar2");
	}
	else if ( is_page() ){
		$p_id = get_queried_object_id ();
		if (function_exists('cws_core_cwsfw_get_post_meta')) {
			$ingenious_stored_meta = cws_core_cwsfw_get_post_meta( $p_id );
		}
		$sidebar1 = $sidebar2 = $sidebar_pos = $sb_block = '';
		$ingenious_stored_meta[0]['sb_layout'] =  !empty($ingenious_stored_meta[0]['sb_layout']) ? $ingenious_stored_meta[0]['sb_layout'] : '';
		if ( isset( $ingenious_stored_meta[0] ) ) {
			$sidebar_pos = $ingenious_stored_meta[0]['sb_layout'];
			if ( $sidebar_pos == 'default' ) {
				$sidebar_pos = ingenious_get_option( 'def-page-layout' );
				$sidebar1 = ingenious_get_option( 'def-page-sidebar1' );
				$sidebar2 = ingenious_get_option( 'def-page-sidebar2' );

			} else {
				$sidebar1 = isset( $ingenious_stored_meta[0]['sidebar1'] ) ? $ingenious_stored_meta[0]['sidebar1'] : '';
				$sidebar2 = isset( $ingenious_stored_meta[0]['sidebar2'] ) ? $ingenious_stored_meta[0]['sidebar2'] : '';
			}
		} else {
			$sidebar_pos = ingenious_get_option( 'def-page-layout' );
			$sidebar1 = ingenious_get_option( 'def-page-sidebar1' );
			$sidebar2 = ingenious_get_option( 'def-page-sidebar2' );
		}
	}


	$ret = array();
	$ret['sb_layout'] = isset( $sidebar_pos ) ? $sidebar_pos : '';
	$ret['sidebar1'] = isset( $sidebar1 ) ? $sidebar1 : '';
	$ret['sidebar2'] = isset( $sidebar2 ) ? $sidebar2 : '';

	$sb_enabled = $ret['sb_layout'] != 'none';
	$ret['sb1_exists'] = $sb_enabled && is_active_sidebar( $ret['sidebar1'] );
	$ret['sb2_exists'] = $sb_enabled && $ret['sb_layout'] == 'both' && is_active_sidebar( $ret['sidebar2'] );

	$ret['sb_exist'] = $ret['sb1_exists'] || $ret['sb2_exists'];
	$ret['sb_layout_class'] = in_array( $sidebar_pos, array( 'left', 'right' ) ) ? 'single' : ( ( $sidebar_pos === "both" ) ? 'double' : '' );

	return $ret;
}

function ingenious_get_page_meta_var( $keys = array() ){
	$p_meta = array();
	if ( isset( $GLOBALS['ingenious_page_meta'] ) ) {
		$p_meta = $GLOBALS['ingenious_page_meta'];
	} else {
		return false;
	}
	if ( is_string( $keys ) && ! empty( $keys ) ) {
		if ( isset( $p_meta[ $keys ] ) ) {
			return  $p_meta[ $keys ];
		} else {
			return false;
		}
	} else if ( is_array( $keys ) && ! empty( $keys ) ) {
		for ( $i = 0; $i < count( $keys ); $i++ ) {
			if ( isset( $p_meta[ $keys[ $i ] ] ) ) {
				if ( $i < count( $keys ) - 1 ) {
					if ( is_array( $p_meta[ $keys[ $i ] ] ) ) {
						$p_meta = $p_meta[ $keys[ $i ] ];
					} else {
						return false;
					}
				} else {
					return $p_meta[ $keys[ $i ] ];
				}
			} else {
				return false;
			}
		}
	} else {
		return false;
	}
}

function ingenious_widgets_init (){
	global $wp_registered_sidebars;

	if ( !array_key_exists( 'page_left_sidebar', $wp_registered_sidebars ) ){
		register_sidebar( array(
			'name' => esc_html__( 'Page Left Sidebar', 'ingenious' ),
			'id' => 'page_left_sidebar',
			'before_title'	=> "<h3 class=\"widgettitle\">",
			'after_title'	=> "</h3>"
		));
	}
	if ( !array_key_exists( 'page_right_sidebar', $wp_registered_sidebars ) ){
		register_sidebar( array(
			'name' => esc_html__( 'Page Right Sidebar', 'ingenious' ),
			'id' => 'page_right_sidebar',
			'before_title'	=> "<h3 class=\"widgettitle\">",
			'after_title'	=> "</h3>"
		));
	}
	if ( !array_key_exists( 'footer_area', $wp_registered_sidebars ) ){
		register_sidebar( array(
			'name' => esc_html__( 'Footer', 'ingenious' ),
			'id' => 'footer_area',
			'before_title'	=> "<h3 class=\"widgettitle\">",
			'after_title'	=> "</h3>"
		));
	}
	$sidebars = ingenious_get_option('sidebars');
	if (!empty($sidebars) && function_exists('register_sidebars') ) {
		foreach ($sidebars as $k => $sb) {
			if ( isset( $sb['title'] ) && !empty( $sb['title'] ) ) {
				register_sidebar( array(
				'name' => $sb['title'],
				'id' => strtolower(preg_replace("/[^a-z0-9\-]+/i", "_", $sb['title'])),
				));
			}
		}
	}
}
add_action( 'widgets_init', 'ingenious_widgets_init' );

/******************** TESTIMONIAL ********************/

function ingenious_testimonial_renderer( $atts, $content = "" ) {
	extract( shortcode_atts( array(
		'thumbnail'		=> null,
		'shape'			=> 'circle',
		'quote'			=> '',
		'author_name'	=> '',
		'author_status'	=> '',
		'el_class'		=> ''
	), $atts));
	$quote        	= esc_html( $quote );
	$author_name 	= esc_html( $author_name );
	$shape 			= esc_html( $shape );
	$author_status	= esc_html( $author_status );
	$el_class    	= esc_attr( $el_class );
	$section_id = uniqid( 'ingenious_testimonial_' );

	$classes = '';

	$img_id = esc_attr($thumbnail);
	$img_url = wp_get_attachment_url( $img_id );
	$src_img = ingenious_print_img_html(array('src' => $img_url), array( 'height' => 115, 'width' => 115, 'crop' => true ), $img_id );
	$content = apply_filters( 'the_content', $content );
	$classes .= !empty($el_class) ? $el_class : '';
	$classes .= isset($shape) ? $shape : '';
	ob_start();
	if (is_single()) {
		echo "<div id='$section_id' class='testimonial single ".esc_attr($classes)."'>";
			echo "<div class='author_info_wrap'>";
				echo "<div class='testimonial_bg'  style='background:url(".esc_url($img_url).")'></div>";
				echo "<div class='testimonial_icon'><i class='fa fa-comments-o' aria-hidden='true'></i></div>";
				if (!empty($quote)) {
					echo "<div class='testimonial_quote'>$quote</div>";
				}
				if (!empty($author_name)) {
					echo "<h6 class='testimonial_name'>".esc_html($author_name)."</h6>";
				}
				if (!empty($author_status)) {
					echo "<span class='testimonial_status'>".esc_html($author_status)."</span>";
				}
			echo "</div>";
		echo "</div>";
	} else{
		echo "<div id='$section_id' class='testimonial $classes'>";
			if (!empty($img_url)) {
				echo "<div class='testimonial_img'><div class='testimonial_img_wrap'><img $src_img /></div></div>";
			}	
			if (!empty($img_url) || !empty($author_name) || !empty($author_status)) {
				echo "<div class='content_wrap'>";
					if (!empty($content)) {
						echo "<div class='quote_wrap'>$content</div>";
					}
					if (!empty($author_name)) {
						echo "<h6 class='testimonial_name'>$author_name</h6>";
					}
					if (!empty($author_status)) {
						echo "<span class='testimonial_status'>$author_status</span>";
					}
				echo "</div>";
			}
		echo "</div>";
	}
	return ob_get_clean();
}

/******************** \TESTIMONIAL ********************/

/****************** POST TIME LINE SHORTCODE *******************/
function ingenious_posts_timeline_render( $atts = array() ){
extract( shortcode_atts( array(
	'title'				=> '',
	'filter_by'			=> '',
	'cats'				=> array(),
	'tags'				=> array(),
	'post_pp'			=> '4',
	'count'				=> '99',
	'page'				=> '1',
	'hide_data'			=> array(),
	'hide_cat'			=> '',
	'type'				=> 'large_type',
	'chars_count'		=> '70'
), $atts));
$out = "";
$title 				= esc_html( $title );
$post_pp 			= (int)$post_pp;
$count 				= (int)$count;
$chars_count 		= (int)$chars_count;
$hide_cat 			= (bool)$hide_cat;
$type 				= esc_html( $type );
$page = (int)$page;

$title = apply_filters( 'latest_post_title', $title );
wp_enqueue_script( 'imagesloaded' );
$query_args = array(
	'post_type'			=> array( 'post' ),
	'post_status'		=> 'publish',
	'posts_per_page'	=> $post_pp,
	'paged'	=> $page,
	'post__not_in'		=> get_option( 'sticky_posts' )
);
$tax_query = array();
$cat_query_args = array();
$tag_query_args = array();
if ( in_array( $filter_by, array( 'cat', 'cat_tag' ) ) ){
	$cat_tax = 'category';
	$cat_terms = $cats;
	if ( !empty( $cat_terms ) ){
		array_push( $cat_query_args, array(
			'taxonomy'	=> $cat_tax,
			'field'			=> 'slug',
			'terms'			=> $cat_terms
		));
	}
}
if ( in_array( $filter_by, array( 'tag', 'cat_tag' ) ) ){
	$tag_tax = 'post_tag';
	$tag_terms = $tags;
	if ( !empty( $tag_terms ) ){
		array_push( $tag_query_args, array(
			'taxonomy'	=> $tag_tax,
			'field'			=> 'slug',
			'terms'			=> $tag_terms
		));
	}
}
if ( !empty( $cat_query_args ) && !empty( $tag_query_args ) ){
	$tax_query['relation'] = 'OR';
}
$tax_query = array_merge( $tax_query, $cat_query_args, $tag_query_args );
if ( !empty( $tax_query ) ){
	$query_args['tax_query'] = $tax_query;
}

$q = new WP_Query( $query_args );

$post_list_classes = 'post_list latest_post_post_list';
$figure_form_style = 'hexagon';
echo "<div class='$post_list_classes $type'>";
echo "<div class='latest_post_list_start'>" . ingenious_figure_style() . "</div>";
$post_pper = 0;
$canvas_height = '';
if ( $type == 'large_type'){
	if ( $figure_form_style == 'hexagon' ) {
		$canvas_height = "135";
	} else if ( $figure_form_style == 'pentagon' ) {
		$canvas_height = "110";
	} else if ( $figure_form_style == 'triangle' ) {
		$canvas_height = "115";
	}
} else if ( $type == 'small_type') {
	if ( $figure_form_style == 'hexagon' ) {
		$canvas_height = "65";
	} else if ( $figure_form_style == 'pentagon' ) {
		$canvas_height = "65";
	} else if ( $figure_form_style == 'triangle' ) {
		$canvas_height = "65";
	}
}

echo "<div class='posts_time_line_wrap'>";
while ( $q->have_posts() ):
	$q->the_post();
	$found_post = $q->found_posts;

	$max_paged = $found_post > $count ? ceil( $count / $post_pp ) : ceil( $found_post / $post_pp );

	$pid = get_the_id();
	$cur_post = get_post( $pid );
	$permalink = esc_url(get_permalink());
	echo "<article class='post latest_post_post clearfix block_show'>";
		$has_img = has_post_thumbnail( $pid );
		$thumb_props = wp_get_attachment_image_src( get_post_thumbnail_id( $pid ), 'full' );
		$thumb_id = get_post_thumbnail_id($pid); //Get thumbnail id
		$thumb = $thumb_props[0];
		$retina_thumb_exists = false;
		$retina_thumb_url = "";
		if ( $type == 'large_type') {
			$thumb_obj = ingenious_thumb( $thumb, array( 'width' => 120, 'height' => 135 , 'crop' => true ), $thumb_id );
		} else if ( $type == 'small_type') {
			$thumb_obj = ingenious_thumb( $thumb, array( 'width' => 60, 'height' => 65 , 'crop' => true  ), $thumb_id );
		}

		$thumb_url = isset( $thumb_obj[0] ) ? esc_url($thumb_obj[0]) : "";
		$thumb_url = esc_url( $thumb_url );
		$retina_thumb_url = esc_url( $retina_thumb_url );
		if ( $type == 'large_type') {
			echo "<div class='post_media latest_post_post_media'>";
				echo "<div class='figure_container small " . $figure_form_style . "'>" . ingenious_figure_style();
					echo "<a class='link fa fa-share' href='$permalink'>" . ingenious_figure_style() . "</a>";
					if ( $has_img ){
						if ( $retina_thumb_exists ) {
							echo "<img src='$thumb_url' data-at2x='$retina_thumb_url' alt /><canvas height='" . $canvas_height . "' width='120'></canvas>";
						}
						else{
							echo "<img src='$thumb_url' data-no-retina alt /><canvas height='" . $canvas_height . "' width='120'></canvas>";
						}
					} else {
						echo "<div class='figure_dummy'>" . ingenious_figure_style() . "</div>";
					}
				echo "</div>";
			echo "</div>";
		} else if ( $type == 'small_type') {
			echo "<div class='post_date latest_post_post_date'>";
				echo "<a href='$permalink' class='center_figure_wrap'>" . ingenious_figure_style();
					echo "<div class='center_figure'>" . ingenious_figure_style() . "</div>";
					$date = get_the_time( "M j, Y" );
					if ( !empty( $date ) ) {
						echo "<div class='date'>" . $date . "</div>";
					}
				echo "</a>";
			echo "</div>";
		}
		$post_data = "";
		ob_start();
		if ( $type == 'small_type' && !empty($thumb_url) ) {
			echo "<div class='post_media latest_post_post_media'>";
				echo "<div class='figure_container mini2 " . $figure_form_style . "'>";
					if ( $retina_thumb_exists ) {
						echo "<img src='$thumb_url' data-at2x='$retina_thumb_url' alt /><canvas height='" . $canvas_height . "' width='60'></canvas>";
					}
					else{
						echo "<img src='$thumb_url' data-no-retina alt /><canvas height='" . $canvas_height . "' width='60'></canvas>";
					}
				echo "</div>";
			echo "</div>";
		}
		if ( $type == 'small_type'){
			echo "<div class='post_content_wrap'>";
		}
			$post_title = esc_html( get_the_title() );
			if ( !empty( $post_title ) ){
				echo "<h5 class='post_title latest_post_post_title'>";
					echo "<a href='$permalink'>";
						echo sprintf("%s", $post_title);
					echo "</a>";
				echo "</h5>";
			}
			if ( $type == 'large_type'){
				$date = get_the_time( get_option("date_format") );
				if ( !empty( $date ) ) {
					echo "<div class='date'>" . $date . "</div>";
				}
			}
			$terms = $cats = $tags = "";
			if ( !in_array( 'cats', $hide_data ) ){
				$cats = ingenious_get_post_term_links_str( 'category' );
			}
			if ( !in_array( 'tags', $hide_data ) ){
				$tags = ingenious_get_post_term_links_str( 'post_tag' );
			}
			$terms .= $cats;
			$terms .= !empty( $cats ) && !empty( $terms ) ? "<br />" : "";
			$terms .= $tags;
			if ( !$hide_cat ) {
				echo !empty( $terms ) ? "<div class='post_terms latest_post_post_terms'>$terms</div>" : "";
			};
			if ( !in_array( 'desc', $hide_data ) ){
				$desc = !empty( $cur_post->post_excerpt ) ? $cur_post->post_excerpt : $cur_post->post_content;
				$desc = trim( preg_replace( "/[\s]{2,}/", " ", strip_shortcodes( strip_tags( $desc ) ) ) );
				$desc = substr( $desc, 0, $chars_count );
				$desc = wptexturize( $desc );
				echo !empty( $desc ) ? "<p class='post_desc latest_post_post_desc'>$desc</p>" : "";
			}
		if ( $type == 'small_type'){
			echo "</div>";
		}
		$post_data = ob_get_clean();
		echo !empty( $post_data ) ? "<div class='post_data latest_post_post_data'>$post_data</div>" : "";
	echo "</article>";
	endwhile;
	echo "</div>";
	wp_reset_postdata();
	echo "<a class='latest_post_list_more ingenious_load_more_time_line' href='#'>" . ingenious_figure_style() . "<span>MORE NEWS</span></a>";
	ingenious_loader_html();

	$ajax_data['post_type']	= 'post';
	$ajax_data['title'] =  $title;
	$ajax_data['filter_by'] =  $filter_by;
	$ajax_data['cats'] =  esc_html($cats);
	$ajax_data['tags'] =  $tags;

	$ajax_data['post_pp'] =  $post_pp;
	$ajax_data['max_paged']	= $max_paged;
	$ajax_data['count'] =  $count;
	$ajax_data['page'] =  $page;

	$ajax_data['hide_data'] =  $hide_data;
	$ajax_data['hide_cat'] =  $hide_cat;
	$ajax_data['type'] =  $type;
	$ajax_data['chars_count'] =  $chars_count;

	$ajax_data_str = json_encode( $ajax_data );
	echo "<form class='posts_grid_data'>";
		echo "<input type='hidden' class='posts_grid_ajax_data' name='timeline_ajax_data' value='".esc_attr($ajax_data_str)."' />";
	echo "</form>";
	echo "<div class='latest_post_list_end'>" . ingenious_figure_style() . "</div>";

	echo "</div>";
}

function ingenious_posts_timeline (){
	extract( wp_parse_args( $_POST['data'], array(
		'post_pp'			=> '4',
		'count'				=> '99',
		'page'				=> '1',
	)));
	ingenious_posts_timeline_render($_POST['data']);
}
add_action( 'wp_ajax_ingenious_posts_timeline', 'ingenious_posts_timeline' );
add_action( 'wp_ajax_nopriv_ingenious_posts_timeline', 'ingenious_posts_timeline' );

/****************** /POST TIME LINE SHORTCODE *******************/

function ingenious_single_portfolio_ajax_load () {
	$query_args = array('post_type'			=> 'cwsportfolio',
						'p' 				=> $_POST['post_id']
						);
	$post_query = new WP_Query( $query_args );
	while( $post_query->have_posts() ) : $post_query->the_post();
		get_template_part('single-cwsportfolioajax');
	endwhile;
	exit;
}
add_action ( 'wp_ajax_ingenious_single_portfolio_ajax_load', 'ingenious_single_portfolio_ajax_load' );
add_action ( 'wp_ajax_nopriv_ingenious_single_portfolio_ajax_load', 'ingenious_single_portfolio_ajax_load' );

function ingenious_portfolio_single(){
	$data = isset( $_POST['data'] ) ? $_POST['data'] : array();
	extract( shortcode_atts( array(
			'initial_id' => '',
			'requested_id' => ''
		), $data));
	if ( empty( $initial_id ) || empty( $requested_id ) ) die();

	echo "<div class='cws_ajax_response'>";
		$pid = $requested_id;
		echo "<article id='portfolio_post_{$pid}' class='portfolio_post post_single item clearfix'>";
		ob_start();
		ingenious_portfolio_single_post_post_media ($requested_id);
		$media = ob_get_clean();
		$floated_media = isset( $GLOBALS['cws_vc_shortcode_portfolio_single_post_floated_media'] ) ? $GLOBALS['cws_vc_shortcode_portfolio_single_post_floated_media'] : false;
		unset( $GLOBALS['cws_vc_shortcode_portfolio_single_post_floated_media'] );
		if ( $floated_media ){
			echo "<div class='floated_media portfolio_floated_media single_post_floated_media'>";
			echo "<div class='floated_media_wrapper portfolio_floated_media_wrapper single_post_floated_media_wrapper'>";
			echo sprintf("%s", $media);
			echo "</div>";
			echo "</div>";						
		}
		else{
			echo sprintf("%s", $media);
		}
		ob_start();
		echo "<div class='portfolio_single_content {$sticky}'>";
			ingenious_portfolio_single_post_title ($pid);
			ingenious_portfolio_single_post_terms ($pid);
			ingenious_portfolio_single_post_content ($pid);
		echo "</div>";
		$content_terms = ob_get_clean();
		if ( !empty( $content_terms ) ){
			if ( $floated_media ){
				echo "<div class='clearfix'>";
				echo sprintf("%s", $content_terms);
				echo "</div>";
			}
			else{
				echo sprintf("%s", $content_terms);
			}
		}
		echo "</article>";
	echo "</div>";
	die();
}

add_action( "wp_ajax_ingenious_portfolio_single", "ingenious_portfolio_single" );
add_action( "wp_ajax_nopriv_ingenious_portfolio_single", "ingenious_portfolio_single" );

/****************** POSTS GRID AJAX *******************/
function ingenious_posts_grid_dynamic_pagination (){
	extract( wp_parse_args( $_POST['data'], array(
		'section_id'				=> '',
		'post_type' 				=> '',
		'post_hide_meta'			=> array(),
		'portfolio_data_to_show'=> '',
		'staff_data_to_hide'	=> array(),
		'layout'					=> '1',
		'chars_count'				=> '200',
		'sb_layout'					=> '',
		'total_items_count'			=> get_option( 'posts_per_page' ),
		'items_pp'					=> get_option( 'posts_per_page' ),
		'page'						=> '1',
		'tax'						=> '',
		'terms'						=> array(),
		'filter'					=> false,
		'current_filter_val'		=> '',
		'req_page_url'				=> '',
		'addl_query_args'			=> array(),
		'portfolio_style' 			=> '',
		'info_pos' 					=> 'inside_img',
		'anim_style' 				=> '',
		'appear_style' 				=> '',
		'hex_layout' 				=> '4',
		'display_style' 			=> ''
	)));
	$req_page = $page;
	if ( !empty( $req_page_url ) ){
		$match = preg_match( "#paged?(=|/)(\d+)#", $req_page_url, $matches );
		$req_page = $match ? $matches[2] : '1';								// if page parameter absent show first page
	};
	$not_in = ( 1 == $req_page ) ? array() : get_option( 'sticky_posts' );
	$query_args = array('post_type'			=> array( $post_type ),
						'post_status'		=> 'publish',
						'post__not_in'		=> $not_in
						);
	$query_args['posts_per_page']		= $items_pp;
	$query_args['paged']				= $req_page;
	if ( $filter == 'true' && $current_filter_val != '_all_' && !empty( $current_filter_val ) ){
		$terms = array( $current_filter_val );
	}
	if ( !empty( $terms ) ){
		$query_args['tax_query'] = array(
			array(
				'taxonomy'		=> $tax,
				'field'			=> 'slug',
				'terms'			=> $terms
			)
		);
	}
	if ( in_array( $post_type, array( "cwsportfolio", "cwsstaff" ) ) ){
		$query_args['orderby'] 	= "menu_order date title";
		$query_args['order']	= "ASC";
	}
	$query_args = array_merge( $query_args, $addl_query_args );
	$q = new WP_Query( $query_args );
	$found_posts = $q->found_posts;
	$max_paged = $found_posts > $total_items_count ? ceil( $total_items_count / $items_pp ) : ceil( $found_posts / $items_pp );
	$GLOBALS['ingenious_posts_grid_atts'] = array(
		'post_type'					=> $post_type,
		'layout'					=> $layout,
		'sb_layout'					=> $sb_layout,
		'post_hide_meta'			=> $post_hide_meta,
		'portfolio_data_to_show'	=> $portfolio_data_to_show,
		'staff_data_to_hide'		=> $staff_data_to_hide,
		'total_items_count'			=> $total_items_count,
		'chars_count'				=> $chars_count,
		'portfolio_style'			=> $portfolio_style,
		'display_style'				=> $display_style,
		'hex_w'						=> $hex_w,
		'hex_h'						=> $hex_h,
		'full_width'				=> $full_width,
		'start_style'				=> $start_style,
		'hex_layout'				=> $hex_layout,
		'anim_style'				=> $anim_style,
		'info_pos'					=> $info_pos,
		'appear_style'				=> $appear_style,
		'item_shadow'				=> $item_shadow,
		'link_show'					=> $link_show,
		'area_link'					=> $area_link,
		'isotope_line_count'		=> $isotope_line_count,
		'isotope_col_count'			=> $isotope_col_count,
		'masonry'					=> $masonry,
		'info_align'				=> $info_align,
		'pag_type'					=> $pag_type,

	);

	switch ($post_type) {
		case 'post':
			ingenious_post_posts_grid_posts($q);
			break;
		case 'cwsportfolio':
			ingenious_portfolio_posts_grid_posts($q);
			break;
		case 'cwsstaff':
			ingenious_staff_posts_grid_posts($q);
			break;			
	}

	unset ( $GLOBALS['ingenious_posts_grid_atts'] );
	if ( $pag_type == 'load_pag' ){
		ingenious_load_more ();
	}
	else if ( $pag_type == 'num_pag' ){
		ingenious_pagination ( $req_page, $max_paged );
	}
	echo "<input type='hidden' id='{$section_id}_dynamic_pagination_page_number' name='{$section_id}_dynamic_pagination_page_number' class='ingenious_posts_grid_dynamic_pagination_page_number' value='$req_page' />";
	wp_die();
}
add_action( 'wp_ajax_ingenious_posts_grid_dynamic_pagination', 'ingenious_posts_grid_dynamic_pagination' );
add_action( 'wp_ajax_nopriv_ingenious_posts_grid_dynamic_pagination', 'ingenious_posts_grid_dynamic_pagination' );

function ingenious_posts_grid_dynamic_filter (){
	extract( wp_parse_args( $_POST['data'], array(
		'section_id'				=> '',
		'post_type' 				=> '',
		'post_hide_meta'			=> array(),
		'portfolio_data_to_show'=> '',
		'staff_data_to_hide'	=> array(),
		'layout'					=> '1',
		'chars_count'				=> '200',
		'sb_layout'					=> '',
		'total_items_count'			=> get_option( 'posts_per_page' ),
		'items_pp'					=> get_option( 'posts_per_page' ),
		'page'						=> '1',
		'portfolio_style'			=> '',
		'display_style'				=> '',
		'info_pos' 					=> 'inside_img',
		'tax'						=> '',
		'terms'						=> array(),
		'filter'					=> false,
		'current_filter_val'		=> '',
		'addl_query_args'			=> array()
	)));
	$not_in = ( 1 == $req_page ) ? array() : get_option( 'sticky_posts' );
	$query_args = array('post_type'			=> array( $post_type ),
						'post_status'		=> 'publish',
						'post__not_in'		=> $not_in
						);
	$query_args['posts_per_page']		= $items_pp;
	$query_args['paged']		= $page;
	if ( $current_filter_val != '_all_' && !empty( $current_filter_val ) ){
		$terms = array( $current_filter_val );
	}
	if ( !empty( $terms ) ){
		$query_args['tax_query'] = array(
			array(
				'taxonomy'		=> $tax,
				'field'			=> 'slug',
				'terms'			=> $terms
			)
		);
	}
	if ( in_array( $post_type, array( "cwsportfolio", "cwsstaff" ) ) ){
		$query_args['orderby'] 	= "menu_order date title";
		$query_args['order']	= "ASC";
	}
	$query_args = array_merge( $query_args, $addl_query_args );
	$q = new WP_Query( $query_args );
	$found_posts = $q->found_posts;
	$max_paged = $found_posts > $total_items_count ? ceil( $total_items_count / $items_pp ) : ceil( $found_posts / $items_pp );
	$is_pagination = $max_paged > 1;
	$GLOBALS['ingenious_posts_grid_atts'] = array(
		'post_type'					=> $post_type,
		'layout'					=> $layout,
		'sb_layout'					=> $sb_layout,
		'post_hide_meta'			=> $post_hide_meta,
		'portfolio_data_to_show'	=> $portfolio_data_to_show,
		'staff_data_to_hide'		=> $staff_data_to_hide,
		'total_items_count'			=> $total_items_count,
		'chars_count'				=> $chars_count,
		'portfolio_style'			=> $portfolio_style,
		'display_style'				=> $display_style,
		'hex_w'						=> $hex_w,
		'hex_h'						=> $hex_h,
		'full_width_s'				=> $full_width_s,
		'full_width'				=> $full_width,
		'start_style'				=> $start_style,
		'hex_layout'				=> $hex_layout,
		'anim_style'				=> $anim_style,
		'info_pos'					=> $info_pos,
		'link_show'					=> $link_show,
		'area_link'					=> $area_link,
		'appear_style'				=> $appear_style,
		'isotope_line_count'		=> $isotope_line_count,
		'isotope_col_count'			=> $isotope_col_count,
		'masonry'					=> $masonry,
		'info_align'				=> $info_align,
		'pag_type'					=> $pag_type,
	);

	switch ($post_type) {
		case 'post':
			ingenious_post_posts_grid_posts($q);
			break;
		case 'cwsportfolio':
			ingenious_portfolio_posts_grid_posts($q);
			break;
		case 'cwsstaff':
			ingenious_staff_posts_grid_posts($q);
			break;			
	}

	unset ( $GLOBALS['ingenious_posts_grid_atts'] );
	if ( $is_pagination ){
		if ( $pag_type == 'load_pag' ){
			ingenious_load_more ();
		}
		else if ( $pag_type == 'num_pag' ){
			ingenious_pagination ( $paged, $max_paged );
		}
	}
	wp_die();
}
add_action( 'wp_ajax_ingenious_posts_grid_dynamic_filter', 'ingenious_posts_grid_dynamic_filter' );
add_action( 'wp_ajax_nopriv_ingenious_posts_grid_dynamic_filter', 'ingenious_posts_grid_dynamic_filter' );

/****************** \POSTS GRID AJAX ******************/

function ingenious_get_page_title ($post_type){
	$text['home']		= esc_html__( 'Home', 'ingenious' ); // text for the 'Home' link
	$text['category']	= esc_html__( 'Category "%s"', 'ingenious' ); // text for a category page
	$text['search']		= esc_html__( 'Search for "%s"', 'ingenious' ); // text for a search results page
	$text['taxonomy']	= esc_html__( 'Archive by %s "%s"', 'ingenious' );
	$text['tag']		= esc_html__( 'Posts Tagged "%s"', 'ingenious' ); // text for a tag page
	$text['author']		= esc_html__( 'Articles Posted by %s', 'ingenious' ); // text for an author page
	$text['404']		= esc_html__( 'Error 404', 'ingenious' ); // text for the 404 page
	$page_title = "";
	if ( is_404() ) {
		$page_title = esc_html__( 'Whoops, nothing found!', 'ingenious' );
	} else if ( is_search() ) {
		$page_title = esc_html__( 'Search', 'ingenious' );
	} else if ( is_front_page() ) {
		$page_title = esc_html__( 'Home', 'ingenious' );
	} else if ( is_category() ) {
		$cat = get_category( get_query_var( 'cat' ) );
		$cat_name = isset( $cat->name ) ? $cat->name : '';
		$page_title = sprintf( $text['category'], $cat_name );
	} else if ( is_tag() ) {
		$page_title = sprintf( $text['tag'], single_tag_title( '', false ) );
	} elseif ( is_day() ) {
		echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $delimiter;
		echo sprintf( $link, get_month_link( get_the_time( 'Y' ),get_the_time( 'm' ) ), get_the_time( 'F' ) ) . $delimiter;
		$page_title = get_the_time( 'd' );
	} elseif ( is_month() ) {
		$page_title = get_the_time( 'F' );
	} elseif ( is_year() ) {
		$page_title = get_the_time( 'Y' );
	} elseif ( has_post_format() && ! is_singular() ) {
		$page_title = get_post_format_string( get_post_format() );
	} else if ( is_tax( array( 'cwsportfolio-cat', 'cwsstaff_member_department', 'cwsstaff_member_position' ) ) ) {
		$tax_slug = get_query_var( 'taxonomy' );
		$term_slug = get_query_var( $tax_slug );
		$tax_obj = get_taxonomy( $tax_slug );
		$term_obj = get_term_by( 'slug', $term_slug, $tax_slug );
		$singular_tax_label = isset( $tax_obj->labels ) && isset( $tax_obj->labels->singular_name ) ? $tax_obj->labels->singular_name : '';
		$term_name = isset( $term_obj->name ) ? $term_obj->name : '';
		$page_title = $singular_tax_label . ' ' . $term_name ;
	} elseif ( function_exists ( 'is_shop' ) && is_shop() ) {
		$page_title = woocommerce_page_title(false);		
	} elseif ( is_archive() ) {
		$post_type = get_post_type();
		$post_type_obj = get_post_type_object( $post_type );
		$post_type_name = isset( $post_type_obj->label ) ? $post_type_obj->label : '';
		$page_title = $post_type_name ;
	} else if ( is_post_type_archive( 'cwsportfolio' ) ) {
		$portfolio_slug = ingenious_get_option('portfolio_slug');
		$post_type = get_post_type();
		$post_type_obj = get_post_type_object( $post_type );
		$post_type_name = isset( $post_type_obj->labels->menu_name ) ? $post_type_obj->labels->menu_name : '';
		$page_title = !empty($portfolio_slug) ? $portfolio_slug : $post_type_name ;
	}else if ( is_post_type_archive( 'cwsstaff' ) ) {
		$stuff_slug = ingenious_get_option('staff_slug');
		$post_type = get_post_type();
		$post_type_obj = get_post_type_object( $post_type );
		$post_type_name = isset( $post_type_obj->labels->menu_name ) ? $post_type_obj->labels->menu_name : '';
		$page_title = !empty($stuff_slug) ? $stuff_slug : $post_type_name ;
	} else if (substr($post_type, 0, 4) === 'cws_' ) {
		$slug_option = substr($post_type, 4) . '_slug'; // if post_type is cwsportfolio, this will turn it into portfolio_slug option name
		$portfolio_slug = ingenious_get_option( $slug_option );
		$post_type_obj = get_post_type_object( $post_type );
		$post_type_name = $post_type_obj->labels->menu_name;
		$page_title = !empty($portfolio_slug) ? $portfolio_slug : $post_type_name ;
	} else {
		$blog_title = ingenious_get_option('blog_title');
		$page_title = (!is_page() && !empty($blog_title)) ? $blog_title : get_the_title();
	}
	return $page_title;
}

add_action( 'after_setup_theme', 'ingenious_after_setup_theme' );
function ingenious_after_setup_theme() {
	add_editor_style();
}
add_filter( 'mce_buttons_2', 'ingenious_mce_buttons_2' );
function ingenious_mce_buttons_2( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
add_filter( 'tiny_mce_before_init', 'ingenious_tiny_mce_before_init' );
function ingenious_tiny_mce_before_init( $settings ) {
	$settings['theme_advanced_blockformats'] = 'p,h1,h2,h3,h4';
	$style_formats = array(
		array( 'title' => 'Title', 'block' => 'h3', 'classes' => 'widgettitle' ),
		array( 'title' => 'Font-Size', 'items' => array(
			array( 'title' => '60px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em', 'styles' => array( 'font-size' => '60px' , 'line-height' => '0.8em') ),
			array( 'title' => '42px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em', 'styles' => array( 'font-size' => '42px' , 'line-height' => '1.2em') ),
			array( 'title' => '28px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em', 'styles' => array( 'font-size' => '28px' , 'line-height' => '1.4em') ),
			array( 'title' => '24px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em', 'styles' => array( 'font-size' => '24px' , 'line-height' => '1.4em') ),
			array( 'title' => '20px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em', 'styles' => array( 'font-size' => '20px' , 'line-height' => '1.4em') ),
			array( 'title' => '18px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em', 'styles' => array( 'font-size' => '18px' , 'line-height' => '1.4em') ),
			array( 'title' => '16px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em', 'styles' => array( 'font-size' => '16px' , 'line-height' => '1.4em') ),
			array( 'title' => '15px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em', 'styles' => array( 'font-size' => '15px' , 'line-height' => '1.6em') ),
			array( 'title' => '14px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em', 'styles' => array( 'font-size' => '14px' , 'line-height' => '1.64em') ),
			array( 'title' => '13px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em', 'styles' => array( 'font-size' => '13px' , 'line-height' => '1.54em') ),
			)
		),
		array( 'title' => 'Font-Weight', 'items' => array(
			array( 'title' => '200', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em', 'styles' => array( 'font-weight' => '200' ) ),
			array( 'title' => '300', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em', 'styles' => array( 'font-weight' => '300' ) ),
			array( 'title' => '400', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em', 'styles' => array( 'font-weight' => '400' ) ),
			array( 'title' => '500', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em', 'styles' => array( 'font-weight' => '500' ) ),
			array( 'title' => '600', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em', 'styles' => array( 'font-weight' => '600' ) ),
			array( 'title' => '700', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em', 'styles' => array( 'font-weight' => '700' ) ),
			array( 'title' => '900', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em', 'styles' => array( 'font-weight' => '900' ) ),
			)
		),
		array( 'title' => 'Margin-Top', 'items' => array(
			array( 'title' => '0px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-top' => '0' ) ),
			array( 'title' => '10px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-top' => '10px' ) ),
			array( 'title' => '15px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-top' => '15px' ) ),
			array( 'title' => '20px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-top' => '20px' ) ),
			array( 'title' => '25px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-top' => '25px' ) ),
			array( 'title' => '30px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-top' => '30px' ) ),
			array( 'title' => '40px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-top' => '40px' ) ),
			array( 'title' => '50px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-top' => '50px' ) ),
			array( 'title' => '60px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-top' => '60px' ) ),
			)
		),
		array( 'title' => 'Margin-Bottom', 'items' => array(
			array( 'title' => '0px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-bottom' => '0px' ) ),
			array( 'title' => '10px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-bottom' => '10px' ) ),
			array( 'title' => '15px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-bottom' => '15px' ) ),
			array( 'title' => '20px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-bottom' => '20px' ) ),
			array( 'title' => '25px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-bottom' => '25px' ) ),
			array( 'title' => '30px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-bottom' => '30px' ) ),
			array( 'title' => '40px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-bottom' => '40px' ) ),
			array( 'title' => '50px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-bottom' => '50px' ) ),
			array( 'title' => '60px', 'selector' => 'h1,h2,h3,h4,h5,h6,p,span,i,b,strong,em,div,hr', 'styles' => array( 'margin-bottom' => '60px' ) ),
			)
		),
		array(
			'title' => 'Horizontal line', 'block' => 'hr', 'items' => array(
				array( 'title' => 'Simple',			'selector' => 'hr:not(.thin):not(.short):not(.short_simple):not(.short_thin)', 			'classes' => 'simple' ),
				array( 'title' => 'Thin',			'selector' => 'hr:not(.simple):not(.short):not(.short_simple):not(.short_thin)', 		'classes' => 'thin' ),
				array( 'title' => 'Short', 			'selector' => 'hr:not(.simple):not(.thin):not(.short_simple):not(.short_thin)', 		'classes' => 'short' ),
				array( 'title' => 'Short Simple', 	'selector' => 'hr:not(.simple):not(.thin):not(.short):not(.short_thin)', 'classes' => 	'short_simple' ),
				array( 'title' => 'Short Thin', 	'selector' => 'hr:not(.simple):not(.thin):not(.short):not(.short_simple)', 'classes' =>	'short_thin' )
			)
		),
		array(
			'title' => 'Animate on hover', 'selector' => 'img', 'items' => array(
				array( 'title' => 'To Top', 'selector' => 'img', 'classes' => 'img_top' ),
				array( 'title' => 'To Bottom','selector' => 'img', 'classes' => 'img_bot' ),
			)
		),
	);
	// Before 3.1 you needed a special trick to send this array to the configuration.
	// See this post history for previous versions.
	$settings['style_formats'] = str_replace( '"', "'", json_encode( $style_formats ) );
	return $settings;
}

/* POSTS GRID */
function ingenious_posts_grid ( $atts = array(), $content = "" ){
	$out = "";
	$defaults = array(
		'title'									=> '',
		'title_align'							=> 'left',
		'post_type'								=> '',
		'total_items_count'						=> '',
		'portfolio_layout'						=> 'def',
		'portfolio_show_data_override'			=> false,
		'portfolio_data_to_show'				=> '',
		'staff_layout'							=> 'def',
		'staff_hide_meta_override'				=> false,
		'staff_data_to_hide'					=> '',
		'portfolio_style'						=> '',
		'display_style'							=> 'grid',
		'select_filter'							=> '',
		'carousel_pagination'					=> '',
		'items_pp'								=>  esc_html( get_option( 'posts_per_page' ) ),
		'paged'									=> 1,
		'tax'									=> '',
		'terms'									=> '',
		'chars_count'							=> '200',
		'addl_query_args'						=> array(),
		'el_class'								=> '',
		'anim_style'							=> '',
		'info_pos'								=> 'inside_img',
		'call_from'								=> '',
	);
	$atts = shortcode_atts( $defaults, $atts );
	extract( $atts );
	$portfolio_style = esc_html($portfolio_style);
	$portfolio_fig_style = ($portfolio_style == 'hex_style');
	$section_id = uniqid( 'posts_grid_' );
	$ajax_data = array();
	$total_items_count = !empty( $total_items_count ) ? (int)$total_items_count : PHP_INT_MAX;
	$items_pp = !empty( $items_pp ) ? (int)$items_pp : esc_html( get_option( 'posts_per_page' ) );
	$paged = (int)$paged;
	$select_filter = (bool)$select_filter;
	$carousel_pagination = (bool)$carousel_pagination;

	$def_portfolio_layout = ingenious_get_option( 'def_portfolio_layout' );
	$def_portfolio_layout = isset( $def_portfolio_layout ) ? $def_portfolio_layout : "";
	$portfolio_layout = ( empty( $portfolio_layout ) || $portfolio_layout === "def" ) ? $def_portfolio_layout : $portfolio_layout;
	$portfolio_show_data_override = !empty( $portfolio_show_data_override ) ? true : false;
	$portfolio_data_to_show = explode( ",", $portfolio_data_to_show );
	$portfolio_def_data_to_show = ingenious_get_option( 'def_portfolio_data_to_show' );
	$portfolio_def_data_to_show  = isset( $portfolio_def_data_to_show ) ? $portfolio_def_data_to_show : array();
	$portfolio_data_to_show = $portfolio_show_data_override ? $portfolio_data_to_show : $portfolio_def_data_to_show;

	//If function call from archive
	if ($call_from == 'archive'){
		$portfolio_def_chars_count = ingenious_get_option( 'def_portfolio_chars_count' );
		$chars_count  = isset( $portfolio_def_chars_count ) ? $portfolio_def_chars_count : $chars_count;
	}

	$def_staff_layout = ingenious_get_option( 'def_staff_layout' );
	$def_staff_layout = isset( $def_staff_layout ) ? $def_staff_layout : "";
	$staff_layout = ( empty( $staff_layout ) || $staff_layout === "def" ) ? $def_staff_layout : $staff_layout;
	$staff_hide_meta_override = !empty( $staff_hide_meta_override ) ? true : false;
	$staff_data_to_hide = explode( ",", $staff_data_to_hide );
	$staff_def_data_to_hide = ingenious_get_option( 'def_staff_data_to_hide' );
	$staff_def_data_to_hide  = isset( $staff_def_data_to_hide ) ? $staff_def_data_to_hide : array();
	$staff_data_to_hide = $staff_hide_meta_override ? $staff_data_to_hide : $staff_def_data_to_hide;

	$el_class = esc_attr( $el_class );
	$sb = ingenious_get_sidebars();
	$sb_layout = isset( $sb['sb_layout_class'] ) ? $sb['sb_layout_class'] : '';
	$layout = "1";
	$post_type_obj = get_post_type_object( $post_type );
	switch ( $post_type ){
		case "cwsportfolio":
			$layout = $portfolio_layout;
			break;
		case "cwsstaff":
			$layout = $staff_layout;
			break;
	}
	$terms = explode( ",", $terms );
	$terms_temp = array();
	foreach ( $terms as $term ) {
		if ( !empty( $term ) ){
			array_push( $terms_temp, $term );
		}
	}
	$terms = $terms_temp;
	$all_terms = array();
	$all_terms_temp = !empty( $tax ) ? get_terms( $tax ) : array();
	$all_terms_temp = !is_wp_error( $all_terms_temp ) ? $all_terms_temp : array();
	foreach ( $all_terms_temp as $term ){
		array_push( $all_terms, $term->slug );
	}
	$terms = !empty( $terms ) ? $terms : $all_terms;
	$not_in = (1 == $paged) ? array() : get_option( 'sticky_posts' );
	$query_args = array('post_type'			=> array( $post_type ),
						'post_status'		=> 'publish',
						'post__not_in'		=> $not_in
						);
	if ( in_array( $display_style, array( 'grid', 'filter' ) ) ){
		$query_args['posts_per_page']		= $items_pp;
		$query_args['paged']		= $paged;
	}
	else{
		$query_args['nopaging']				= true;
		$query_args['posts_per_page']		= -1;
	}
	if ( !empty( $terms ) ){
		$query_args['tax_query'] = array(
			array(
				'taxonomy'		=> $tax,
				'field'			=> 'slug',
				'terms'			=> $terms
			)
		);
	}
	if ( in_array( $post_type, array( "cwsportfolio", "cwsstaff" ) ) ){
		$query_args['orderby'] 	= "menu_order date title";
		$query_args['order']	= "ASC";
	}
	$query_args = array_merge( $query_args, $addl_query_args );
	$q = new WP_Query( $query_args );
	$found_posts = $q->found_posts;
	$requested_posts = $found_posts > $total_items_count ? $total_items_count : $found_posts;
	$max_paged = $found_posts > $total_items_count ? ceil( $total_items_count / $items_pp ) : ceil( $found_posts / $items_pp );
	$cols = in_array( $layout, array( 'medium', 'small' ) ) ? 1 : (int)$layout;
	$is_carousel = $display_style == 'carousel' && $requested_posts > $cols;
	wp_enqueue_script( 'fancybox' );
	$is_filter = in_array( $display_style, array( 'filter' ) ) && !empty( $terms ) ? true : false;
	$filter_vals = array();
	$use_pagination = in_array( $display_style, array( 'grid', 'filter' ) ) && $max_paged > 1;
	$pagination_type = "pagination";
	if ( !$is_filter && in_array( $layout, array( '2', '3', '4', '5' ) ) ){
		$pagination_type = "load_more";
	}
	$dynamic_content = $is_filter || $use_pagination;
	if ( $is_carousel ){
		wp_enqueue_script( 'owl_carousel' );
	}
	else if ( in_array( $layout, array( "2", "3", "4", "5" ) ) || $dynamic_content ){
		wp_enqueue_script( 'isotope' );
	}
	if ( $dynamic_content || is_single() || is_archive()){
		wp_enqueue_script( 'owl_carousel' ); // for dynamically loaded gallery posts
		wp_enqueue_script( 'imagesloaded' );
	}
	ob_start ();
	$filter = $select_filter ? " select_filter" : " simple_filter";
	$classes = $carousel_pagination ? " carousel_pagination" : "";
	$hex_class = $portfolio_fig_style ? " hexagon_grid" : "";
	$isotope_style = !$portfolio_fig_style ? " isotope" : "";

	$post_type_style = preg_replace( '/cws/', '', $post_type );
	echo "<section id='$section_id' class='posts_grid {$post_type_style}_posts_grid posts_grid_{$layout} posts_grid_{$display_style}" . ( $dynamic_content ? " dynamic_content" : "" ) . ( !empty( $el_class ) ? " $el_class" : "" ) . $hex_class . $filter . " '>";
		if ( $is_carousel ){
			echo "<div class='widget_header clearfix'>";
				echo !empty( $title ) ? "<h2 class='widgettitle'>" . esc_html( $title ) . "</h2>" : "";
				if ( !$carousel_pagination ) {
					echo "<div class='carousel_nav'>";
						echo "<span class='prev'>";
						echo "</span>";
						echo "<span class='next'>";
						echo "</span>";
					echo "</div>";
				}

			echo "</div>";
		}
		else if ( $is_filter && count( $terms ) > 1 ){
			foreach ( $terms as $term ) {
				if ( empty( $term ) ) continue;
				$term_obj = get_term_by( 'slug', $term, $tax );
				if ( empty( $term_obj ) ) continue;
				$term_name = $term_obj->name;
				$filter_vals[$term] = $term_name;
			}
			if ( $filter_vals > 1 ){
				echo !empty( $title ) ? "<h2 class='widgettitle'>" . esc_html( $title ) . "</h2>" : "";
				echo "<ul class='filter_wrap'>";
					echo "<li data-filter='_all_' class='filter active'>All</li>";
					foreach ( $filter_vals as $term_slug => $term_name ){
						echo "<li data-filter='" . esc_html( $term_slug ) . "' class='filter'>" . esc_html( $term_name ) . "</li>";
					}
				echo "</ul>";
				echo "<select class='filter'>";
					echo "<option value='_all_' selected>" . esc_html__( 'All', 'ingenious' ) . "</option>";
					foreach ( $filter_vals as $term_slug => $term_name ){
						echo "<option value='" . esc_html( $term_slug ) . "'>" . esc_html( $term_name ) . "</option>";
					}
				echo "</select>";
			}
			else{
				echo !empty( $title ) ? "<h2 class='widgettitle text_align{$title_align}'>" . esc_html( $title ) . "</h2>" : "";
			}
		}
		else{
			echo !empty( $title ) ? "<h2 class='widgettitle text_align{$title_align}'>" . esc_html( $title ) . "</h2>" : "";
		}
		echo "<div class='ingenious_wrapper'>";
			echo "<div class='" . ( $is_carousel ? "ingenious_carousel" : "ingenious_grid" . ( ( in_array( $layout, array( "2", "3", "4", "5" ) ) || $dynamic_content ) ? $isotope_style : "" ) ) . $classes .  "'" . ( $is_carousel ? " data-cols='" . ( !is_numeric( $layout ) ? "1" : $layout ) . "'" : "" ) . ">";
				$GLOBALS['ingenious_posts_grid_atts'] = array(
					'layout'						=> $layout,
					'sb_layout'						=> $sb_layout,
					'portfolio_data_to_show'		=> $portfolio_data_to_show,
					'staff_data_to_hide'			=> $staff_data_to_hide,
					'portfolio_style'				=> $portfolio_style,
					'display_style'					=> $display_style,
					'total_items_count'				=> $total_items_count,
					'chars_count'					=> $chars_count,
					'title_divider'					=> false,
					'crop_img'						=> false,
					'area_link'						=> true,
					'link_show'						=> 'popup_link',
					'info_pos'						=> $info_pos,
					'call_from'						=> $call_from,
				);

				switch ($post_type) {
					case 'post':
						ingenious_post_posts_grid_posts($q);
						break;
					case 'cwsportfolio':
						ingenious_portfolio_posts_grid_posts($q);
						break;
					case 'cwsstaff':
						ingenious_staff_posts_grid_posts($q);
						break;			
				}

				unset( $GLOBALS['ingenious_posts_grid_atts'] );
			echo "</div>";
			if ( $dynamic_content ){
				ingenious_loader_html();
			}
		echo "</div>";
		if ( $use_pagination ){
			if ( $pagination_type == 'load_more' ){
				ingenious_load_more ();
			}
			else{
				ingenious_pagination ( $paged, $max_paged );
			}
		}
		if ( $dynamic_content ){
			$ajax_data['section_id']						= $section_id;
			$ajax_data['post_type']							= $post_type;
			$ajax_data['portfolio_data_to_show']			= $portfolio_data_to_show;
			$ajax_data['staff_data_to_hide']				= $staff_data_to_hide;
			$ajax_data['layout']							= $layout;
			$ajax_data['chars_count']						= $chars_count;
			$ajax_data['sb_layout']							= $sb_layout;
			$ajax_data['total_items_count']					= $total_items_count;
			$ajax_data['items_pp']							= $items_pp;
			$ajax_data['page']								= $paged;
			$ajax_data['max_paged']							= $max_paged;
			$ajax_data['tax']								= $tax;
			$ajax_data['terms']								= $terms;
			$ajax_data['filter']							= $is_filter;
			$ajax_data['current_filter_val']				= '_all_';
			$ajax_data['addl_query_args']					= $addl_query_args;
			$ajax_data['portfolio_style']					= $portfolio_style;
			$ajax_data['display_style']						= $display_style;
			$ajax_data_str = json_encode( $ajax_data );
			echo "<form id='{$section_id}_data' class='posts_grid_data'>";
				echo "<input type='hidden' id='{$section_id}_ajax_data' class='posts_grid_ajax_data' name='{$section_id}_ajax_data' value='$ajax_data_str' />";
			echo "</form>";
		}
	echo "</section>";
	$out = ob_get_clean();
	return $out;
}
/* \POSTS GRID */

/*	Visual Composer Overrides */

if ( !function_exists( 'vc_theme_before_vc_row' ) ) {
	function vc_theme_before_vc_row($atts, $content = null) {
		$GLOBALS['ingenious_row_fw_atts'] = $atts;
		return VC_CWS_Background::cws_open_vc_shortcode($atts, $content);
	}
}

if ( !function_exists( 'vc_theme_before_vc_column' ) ) {
	function vc_theme_before_vc_column($atts, $content = null) {
		new VC_CWS_Background();
		return VC_CWS_Background::cws_open_vc_shortcode_column($atts, $content);
	}
}	
if ( !function_exists( 'vc_theme_after_vc_column' ) ) {
	function vc_theme_after_vc_column($atts, $content = null) {
		new VC_CWS_Background();
		return VC_CWS_Background::cws_close_vc_shortcode_column($atts, $content);
	}
}
if ( !function_exists( 'vc_theme_after_vc_row' ) ) {
	function vc_theme_after_vc_row($atts, $content = null) {
		unset($GLOBALS['ingenious_row_fw_atts']);
		 return VC_CWS_Background::cws_close_vc_shortcode($atts, $content);
	}
}

/*	\Visual Composer Overrides */

function ingenious_loader_html ( $args = array() ){
	extract( wp_parse_args( $args, array(
		'holder_id'		=> '',
		'holder_class' 	=> '',
		'loader_id'		=> '',
		'loader_class'	=> ''
	)));
	$holder_class 	.= " cws_loader_holder";
	$loader_class 	.= " cws_loader";
	$holder_id		= esc_attr( $holder_id );
	$holder_class 	= esc_attr( trim( $holder_class ) );
	$loader_id		= esc_attr( $loader_id );
	$loader_class 	= esc_attr( trim( $loader_class ) );
	echo "<div " . ( !empty( $holder_id ) ? " id='$holder_id'" : "" ) . " class='$holder_class'>";
		echo "<div " . ( !empty( $loader_id ) ? " id='$loader_id'" : "" ) . " class='$loader_class'>";
			?>
			<svg width='104px' height='104px' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="uil-default"><rect x="0" y="0" width="100" height="100" fill="none" class="bk"></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#000000' transform='rotate(0 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#000000' transform='rotate(30 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.08333333333333333s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#000000' transform='rotate(60 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.16666666666666666s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#000000' transform='rotate(90 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.25s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#000000' transform='rotate(120 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.3333333333333333s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#000000' transform='rotate(150 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.4166666666666667s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#000000' transform='rotate(180 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.5s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#000000' transform='rotate(210 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.5833333333333334s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#000000' transform='rotate(240 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.6666666666666666s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#000000' transform='rotate(270 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.75s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#000000' transform='rotate(300 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.8333333333333334s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#000000' transform='rotate(330 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.9166666666666666s' repeatCount='indefinite'/></rect></svg>
			<?php
		echo "</div>";
	echo "</div>";
}

function ingenious_figure_style( $custom_color = '', $custom_color_bg = '' ) {
	$figure_style = 'hexagon';
	$theme_custom_color = esc_attr( ingenious_get_option( 'theme_color' ) );
	ob_start();
	if ( $figure_style == 'hexagon' ) {
		echo "<div class='figure_wrap " . $figure_style . "'>
			<svg " . ( !empty( $custom_color ) ? "style='fill: $custom_color_bg; stroke: $custom_color;'" : "" ) . " viewBox='0 0 110.74 123.18'><path d='M307.58,232.84l-40.2-23.21a14.17,14.17,0,0,1-7.09-12.27V150.94a14.17,14.17,0,0,1,7.09-12.27l40.2-23.21a14.17,14.17,0,0,1,14.17,0L362,138.67A14.17,14.17,0,0,1,369,150.94v46.42A14.17,14.17,0,0,1,362,209.63l-40.2,23.21A14.17,14.17,0,0,1,307.58,232.84Z' transform='translate(-259.29 -112.56)'/></svg>
		</div>";
	} else if( $figure_style == 'triangle' ) {
		echo "<div class='figure_wrap " . $figure_style ."'>
			<svg " . ( !empty( $custom_color ) ? "style='fill: $custom_color; stroke: transparent;'" : "" ) . ( !empty( $custom_color )  ? "style='fill: transparent; stroke: $custom_color;'" : "" ) . " viewBox='0 0 120.11 108.04'><path d='M43.91,134l44.86-77.7a14.17,14.17,0,0,1,24.55,0L158.17,134a14.17,14.17,0,0,1-12.27,21.26H56.18A14.17,14.17,0,0,1,43.91,134Z' transform='translate(-40.99 -48.2)'/></svg>
		</div>";
	} else if( $figure_style == 'pentagon' ) {
		echo "<div class='figure_wrap " . $figure_style ."'>
			<svg " . ( !empty( $custom_color ) ? "style='fill: $custom_color; stroke: transparent;'" : "" ) . ( !empty( $custom_color ) ? "style='fill: transparent; stroke: $custom_color;'" : "" ) . " viewBox='0 0 115.56 111.38'><path d='M60.68,147.05L44.4,97a14.17,14.17,0,0,1,5.15-15.85l42.6-31a14.17,14.17,0,0,1,16.66,0l42.6,31A14.17,14.17,0,0,1,156.57,97L140.3,147.05a14.17,14.17,0,0,1-13.48,9.79H74.16A14.17,14.17,0,0,1,60.68,147.05Z' transform='translate(-42.71 -46.46)'/></svg>
		</div>";
	}
	return ob_get_clean();
}

if (!function_exists('ingenious_shape')) {
	function ingenious_shape( $type = '', $shadow = '') {
		$shape_id = uniqid('shape_');
		$classes = '';
		$classes .= $shadow ? ' shadow' : '';
		ob_start();
		if ($type == 'circle') {
			echo "<div class='icon_shape $classes'><svg viewBox='-1 0 68 67'><linearGradient gradientTransform='rotate(65)' id='shape-gradient'><stop offset='0%' stop-color='#fefefe'/><stop offset='100%' stop-color='#f9f8f8'/></linearGradient><defs><filter id='".$shape_id."'>";
				if ($shadow) {
					echo "<feGaussianBlur in='SourceAlpha' stdDeviation='4'/> <feOffset dx='2' dy='2'/><feComponentTransfer><feFuncA type='gamma' amplitude='4' exponent='7' offset='0'/></feComponentTransfer>";
				}
			echo "<feMerge><feMergeNode/><feMergeNode in='SourceGraphic'/></feMerge></filter></defs><path filter='url(#".$shape_id.")' d='M215,159.45A29.92,29.92,0,1,1,185,189.37,29.92,29.92,0,0,1,215,159.45Z' transform='translate(-183 -156.99)'/></svg></div>";
		} else if ($type == 'triangle') {
			echo "<div class='icon_shape $classes'><svg viewBox='0 0 67 60'><defs><filter id='".$shape_id."'>";
				if ($shadow) {
					echo "<feGaussianBlur in='SourceAlpha' stdDeviation='2'/> <feOffset dx='1' dy='1'/><feComponentTransfer><feFuncA type='linear' slope='0.6'/></feComponentTransfer>";
				} 
			echo "<feMerge><feMergeNode/><feMergeNode in='SourceGraphic'/></feMerge></filter></defs><path filter='url(#".$shape_id.")' d='M36.7,5.7L64,52.8a2.8,2.8,0,0,1-2.4,4.2H7a2.8,2.8,0,0,1-2.4-4.2L31.9,5.7A2.8,2.8,0,0,1,36.7,5.7Z' transform='translate(-1.5 -2.5)'/></svg></div>";
		} else if ($type == 'triangle_2') {
			echo "<div class='icon_shape $classes'><svg viewBox='0 0 67 60'><defs><filter id='".$shape_id."'>";
				if ($shadow) {
					echo "<feGaussianBlur in='SourceAlpha' stdDeviation='2'/> <feOffset dx='1' dy='1'/><feComponentTransfer><feFuncA type='linear' slope='0.6'/></feComponentTransfer>";
				}
			echo "<feMerge><feMergeNode/><feMergeNode in='SourceGraphic'/></feMerge></filter></defs><path filter='url(#".$shape_id.")' d='M201.3,326.54L174,279.41a2.81,2.81,0,0,1,2.44-4.22H231a2.81,2.81,0,0,1,2.44,4.22l-27.29,47.13A2.82,2.82,0,0,1,201.3,326.54Z' transform='translate(-171 -272.25)'/></svg></div>";
		} else if ($type == 'rhomb') {
			echo "<div class='icon_shape $classes'><svg viewBox='0 0 91 91'><defs><filter id='".$shape_id."'>";
				if ($shadow) {
					echo "<feGaussianBlur in='SourceAlpha' stdDeviation='2'/> <feOffset dx='1' dy='1'/><feComponentTransfer><feFuncA type='linear' slope='0.6'/></feComponentTransfer>";
				}
			echo "<feMerge><feMergeNode/><feMergeNode in='SourceGraphic'/></feMerge></filter></defs><path filter='url(#".$shape_id.")' d='M169.92,316l38.45,38.45a3.67,3.67,0,0,1,0,5.2l-38.45,38.45a3.67,3.67,0,0,1-5.2,0l-38.45-38.45a3.67,3.67,0,0,1,0-5.2L164.73,316A3.67,3.67,0,0,1,169.92,316Z' transform='translate(-123 -312.68)'/></svg></div>";
		} else if ($type == 'shield') {
			echo "<div class='icon_shape $classes'><svg viewBox='0 0 73 86'><defs><filter id='".$shape_id."'>";
				if ($shadow) {
					echo "<feGaussianBlur in='SourceAlpha' stdDeviation='2'/> <feOffset dx='1' dy='1'/><feComponentTransfer><feFuncA type='linear' slope='0.6'/></feComponentTransfer>";
				}
			echo "<feMerge><feMergeNode/><feMergeNode in='SourceGraphic'/></feMerge></filter></defs><path filter='url(#".$shape_id.")' d='M167.52,434.43a0.85,0.85,0,0,1-.28,0c-23.87-8.32-32.34-23.22-32.34-33.44V367.53a0.85,0.85,0,0,1,.57-0.81l31.78-10.56a0.85,0.85,0,0,1,.54,0l31.77,10.57a0.85,0.85,0,0,1,.6.8v33.41c0,10.23-8.47,25.13-32.34,33.45A0.86,0.86,0,0,1,167.52,434.43Z' transform='translate(-132 -353.43)'/></svg></div>";
		} 
		return ob_get_clean();
	}
}

function ingenious_post_gallery( $output, $attr, $instance ) {

	// Initialize
	global $post, $wp_locale;

	// Gallery instance counter
	static $instance = 0;
	$instance++;

	// Validate the author's orderby attribute
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( ! $attr['orderby'] ) unset( $attr['orderby'] );
	}

	// Get attributes from shortcode
	extract( shortcode_atts( array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'div',
		'icontag'    => 'div',
		'captiontag' => 'div',
		'columns'    => 3,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => '',
		'img_figure_form'    => 'default',
		'img_align'    => 'center',
		'link'    => 'file',
	), $attr ) );

	// Initialize
	$id = intval( $id );
	$attachments = array();
	$img_figure_form = esc_html($img_figure_form);
	$img_align = esc_html($img_align);
	$link_to = esc_html($link);
	$img_figure_form = 'default';
	$img_align = 'center';
	if ( $order == 'RAND' ) $orderby = 'none';

	if ( ! empty( $include ) ) {

		// Include attribute is present
		$include = preg_replace( '/[^0-9,]+/', '', $include );
		$_attachments = get_posts( array( 'include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );

		// Setup attachments array
		foreach ( $_attachments as $key => $val ) {
			$attachments[ $val->ID ] = $_attachments[ $key ];
		}

	} else if ( ! empty( $exclude ) ) {

		// Exclude attribute is present
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );

		// Setup attachments array
		$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
	} else {
		// Setup attachments array
		$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
	}

	if ( empty( $attachments ) ) return '';

	// Filter gallery differently for feeds
	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment ) $output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
		return $output;
	}
	// Filter tags and attributes
	$itemtag = tag_escape( $itemtag );
	$captiontag = tag_escape( $captiontag );
	$columns = intval( $columns );
	$itemwidth = $columns > 0 ? floor( 100 / $columns ) : 100;
	$float = is_rtl() ? 'right' : 'left';
	$selector = "gallery-{$instance}";

	// Filter gallery CSS
	$styles = "";
	$styles = apply_filters( 'gallery_style', "
		<style type='text/css'>
			#{$selector} {
				margin: auto;
				justify-content: {$img_align};
			}
			#{$selector} .gallery-item {
				float: {$float};
				margin-top: 10px;
				text-align: center;
				width: {$itemwidth}%;
			}
			#{$selector} .gallery-caption {
				margin-left: 0;
			}
		</style>"
	);
	$styles = json_encode($styles);
	$output .= "<div id='$selector' data-style='".esc_attr($styles)."' class='gallery galleryid-{$id} render_styles'>";

	$hex_size = '';
	if ( $img_figure_form == 'hexagon' ) {
		if ( $columns == 1 || $columns == 2 || $columns == 3 ) {
			if ( $size == 'large' || $size == 'full' ) {
				$img_size_w = '280';
				$img_size_h = '310';
				$hex_size .= ' big';
			} else if ( $size == 'medium') {
				$img_size_w = '200';
				$img_size_h = '225';
				$hex_size .= ' medium';
			} else if ( $size == 'thumbnail') {
				$img_size_w = '140';
				$img_size_h = '155';
				$hex_size .= ' thumbnail';
			}
		} else if ( $columns == 4 ) {
			if ( $size == 'medium' || $size == 'large' || $size == 'full') {
				$img_size_w = '200';
				$img_size_h = '225';
				$hex_size .= ' medium';
			} else if ( $size == 'thumbnail') {
				$img_size_w = '140';
				$img_size_h = '155';
				$hex_size .= ' thumbnail';
			}
		} else if ( $columns == 5 ) {
			if ( $size == 'thumbnail' || $size == 'medium' || $size == 'large' || $size == 'full') {
				$img_size_w = '140';
				$img_size_h = '155';
				$hex_size .= ' thumbnail';
			}
		} else if ( $columns == 6 ) {
			if ( $size == 'thumbnail' || $size == 'medium' || $size == 'large' || $size == 'full') {
				$img_size_w = '140';
				$img_size_h = '155';
				$hex_size .= ' thumbnail';
			}
		} else if ( $columns == 7 ) {
			if ( $size == 'thumbnail' || $size == 'medium' || $size == 'large' || $size == 'full') {
				$img_size_w = '80';
				$img_size_h = '90';
				$hex_size .= ' mini';
			}
		} else if ( $columns == 8 ) {
			if ( $size == 'thumbnail' || $size == 'medium' || $size == 'large' || $size == 'full') {
				$img_size_w = '80';
				$img_size_h = '90';
				$hex_size .= ' mini';
			}
		} else if ( $columns == 9 ) {
			if ( $size == 'thumbnail' || $size == 'medium' || $size == 'large' || $size == 'full') {
				$img_size_w = '80';
				$img_size_h = '90';
				$hex_size .= ' mini';
			}
		}
	}

	// Iterate through the attachments in this gallery instance
	$i = 0;

	foreach ( $attachments as $id => $attachment ) {
		// Attachment link
		$link = isset( $attr['link'] ) && 'file' == $attr['link'] ? wp_get_attachment_link( $id, $size, false, false ) : wp_get_attachment_link( $id, $size, true, false );
		// Start itemtag
		$gallery_size = $hex_size.'_size';
		$gallery_col = ' col_'.$columns;
		$output .= "<div class='gallery-item " . $gallery_size . $gallery_col . "'>";
		// icontag
		$repl = "<div class='gallery-icon-link'></div>";
		if ( $img_figure_form == 'hexagon' ) {
			$img_id = $attachments[$id]->ID;
			$img_src = $attachments[$id]->guid;
			$img_thumb = ingenious_thumb( $img_src, array( 'width'=>$img_size_w, 'height'=>$img_size_h , 'crop' => true ), $img_id );
			$thumb_url = isset( $img_thumb[0] ) ? esc_url($img_thumb[0]) : "";
			$repl .= "<canvas height='" . $img_size_h ."' width='" . $img_size_w . "'></canvas>";
			$link = preg_replace("/(<a[^>]*>)(.*)(<\/a>)/", "$1<div class='figure_container " . $hex_size . " hexagon'>$repl$2</div>$3", $link);
			$link = preg_replace("/(src=\").*(\")/", "$1" . $thumb_url . "$2 alt", $link );
		} else {
			$link = preg_replace("/(<a[^>]*>)(.*)/", "$1$repl$2", $link);
		}
		if ( $link_to == 'none') {
			$link = preg_replace("/<a[^>]*>([^|]*)<\/a>/", "<div>$1</div>", $link);
		}

		$output .= "
		<div class='gallery-icon'>
			$link
		</div>";

		if ( $captiontag && trim( $attachment->post_excerpt ) ) {

			// captiontag
			$output .= "
			<{$captiontag} class='gallery-caption'>
				" . wptexturize($attachment->post_excerpt) . "
			</{$captiontag}>";

		}

		// End itemtag
		$output .= "</div>";

		// Line breaks by columns set
		if($columns > 0 && ++$i % $columns == 0) $output .= '<br style="clear: both">';

	}

	// End gallery output
	$output .= "
	</div>\n";

	return $output;

}

// Apply filter to default gallery shortcode
add_filter( 'post_gallery', 'ingenious_post_gallery', 10, 3 );

/*	Slider Overlaying body class */

function ingenious_slider_overlaying_body_class ( $classes ){
	$header_page_meta_vars 	= ingenious_get_page_meta_var( array( 'header' ) );
	$page_override_header 	= !empty( $header_page_meta_vars );
	$sticky_sidebars = ingenious_get_option('sticky_sidebars');
	$header_covers_slider 	= false;
	if ( $page_override_header ){
		$header_covers_slider 	= isset( $header_page_meta_vars['header_covers_slider'] ) ? (bool)$header_page_meta_vars['header_covers_slider'] : $header_covers_slider;
	}
	else{
		$header_covers_slider 	= (bool)ingenious_get_option( 'header_covers_slider' );
	}
	if (function_exists('is_woocommerce')) {
		if (is_woocommerce()) {
			$header_covers_slider 	= ingenious_get_option( 'woo_header_covers_slider' );
		}
	}
	$classes[] = '';
	if ( $header_covers_slider ){
		$classes[] .= 'header_covers_slider';
	}
	if ($sticky_sidebars == 1) {
		$classes[] .= 'sticky_sidebar';
	}
	return $classes;
}

add_filter( 'body_class', 'ingenious_slider_overlaying_body_class' );

function ingenious_background_color_default() {
	update_option ("background-color","#ffffff");
}
add_action ("after_switch_theme","ingenious_background_color_default");

function ingenious_merge_arrs ( $arrs = array() ){
	$r = array();
	for ( $i = 0; $i < count( $arrs ); $i++ ){
		$r = array_merge( $r, $arrs[$i] );
	}
	return $r;
}

/**/
/**/
/* Composer Icon Params Group */
/**/
function ingenious_icon_vc_sc_config_params ( $dep_el = "", $dep_val = false ){
	$libs_param = array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'Icon library', 'ingenious' ),
		'value' => array(
			esc_html__( 'Font Awesome', 'ingenious' ) => 'fontawesome',
			esc_html__( 'Open Iconic', 'ingenious' ) => 'openiconic',
			esc_html__( 'Typicons', 'ingenious' ) => 'typicons',
			esc_html__( 'Entypo', 'ingenious' ) => 'entypo',
			esc_html__( 'Linecons', 'ingenious' ) => 'linecons',
			esc_html__( 'Mono Social', 'ingenious' ) => 'monosocial',
		),
		'param_name' => 'icon_lib',
		'description' => esc_html__( 'Select icon library.', 'ingenious' ),
	);
	if ( !empty( $dep_el ) ){
		$libs_param['dependency'] = array(
			"element"	=> $dep_el
		);
		if ( is_bool( $dep_val ) ){
			$libs_param['dependency']['not_empty'] = $dep_val;
		}
		else{
			$libs_param['dependency']['value'] = $dep_val;
		}
	}
	$iconpickers = array(
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'ingenious' ),
			'param_name' => 'icon_fontawesome',
			'value' => '', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => true,
				// default true, display an "EMPTY" icon?
				'iconsPerPage' => 4000,
				// default 100, how many icons per/page to display, we use (big number) to display all icons in single page
			),
			'dependency' => array(
				'element' => 'icon_lib',
				'value' => 'fontawesome',
			),
			'description' => esc_html__( 'Select icon from library.', 'ingenious' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'ingenious' ),
			'param_name' => 'icon_openiconic',
			'value' => '', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => true, // default true, display an "EMPTY" icon?
				'type' => 'openiconic',
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'icon_lib',
				'value' => 'openiconic',
			),
			'description' => esc_html__( 'Select icon from library.', 'ingenious' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'ingenious' ),
			'param_name' => 'icon_typicons',
			'value' => '', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => true, // default true, display an "EMPTY" icon?
				'type' => 'typicons',
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'icon_lib',
				'value' => 'typicons',
			),
			'description' => esc_html__( 'Select icon from library.', 'ingenious' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'ingenious' ),
			'param_name' => 'icon_entypo',
			'value' => '', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => true, // default true, display an "EMPTY" icon?
				'type' => 'entypo',
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'icon_lib',
				'value' => 'entypo',
			),
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'ingenious' ),
			'param_name' => 'icon_linecons',
			'value' => '', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => true, // default true, display an "EMPTY" icon?
				'type' => 'linecons',
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'icon_lib',
				'value' => 'linecons',
			),
			'description' => esc_html__( 'Select icon from library.', 'ingenious' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'ingenious' ),
			'param_name' => 'icon_monosocial',
			'value' => '', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => true, // default true, display an "EMPTY" icon?
				'type' => 'monosocial',
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'icon_lib',
				'value' => 'monosocial',
			),
			'description' => esc_html__( 'Select icon from library.', 'ingenious' ),
		)
	);

	$fi_icons = ingenious_get_all_flaticon_icons();
	$fi_firsticon = "";
	$fi_exists = is_array( $fi_icons ) && !empty( $fi_icons );
	$fi_lib_key = esc_html__( 'CWS Flaticons', 'ingenious' );
	if ( $fi_exists ){
		$fi_firsticon = $fi_icons[0];
		$libs_param['value'][$fi_lib_key] = 'cws_flaticons';
		array_push( $iconpickers, array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'ingenious' ),
			'param_name' => 'icon_cws_flaticons',
			'value' => '', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => true, // default true, display an "EMPTY" icon?
				'type' => 'cws_flaticons',
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'icon_lib',
				'value' => 'cws_flaticons',
			),
			'description' => esc_html__( 'Select icon from library.', 'ingenious' ),
		));
	}
	$svg_lib_key = esc_html__( 'CWS SVG', 'ingenious' );
	$libs_param['value'][$svg_lib_key] = 'cws_svg';
	array_push( $iconpickers, array(
		"type"			=> "cws_svg",
		"heading"		=> esc_html__( 'SVG Icon', 'ingenious' ),
		"param_name"	=> "cws_svg_icon",
		'dependency' => array(
			'element' => 'icon_lib',
			'value' => 'cws_svg',
		),
		'description' => esc_html__( 'Select icon from library.', 'ingenious' ),
	));


	$params = array_merge( array( $libs_param ), $iconpickers );
	return $params;
}
/**/
/* \Composer Icon Params Group */
/**/
/**/
/* Get Selected Icons from Composer Attributes */
/**/
function ingenious_vc_sc_get_icon ( $atts ){
	$defaults = array(
		'icon_lib' 				=> 'fontawesome',
		'icon_fontawesome'		=> '',
		'icon_openiconic'		=> '',
		'icon_typicons'			=> '',
		'icon_entypo'			=> '',
		'icon_linecons'			=> '',
		'icon_monosocial'		=> '',
		'icon_cws_flaticons'	=> ''
	);
	$proc_atts 	= wp_parse_args( $atts, $defaults );
	$lib 		= $proc_atts['icon_lib'];
	$icon_key 	= "icon_$lib";
	$icon 		= isset( $atts[$icon_key] ) ? $atts[$icon_key] : "";
	return $icon;
}
/**/
/* \Get Selected Icons from Composer Attributes */
/**/

if (!function_exists('ingenious_page_loader')) {
	function ingenious_page_loader (){
		if (ingenious_get_option('show_loader') == '1'){
			echo '
				<div id="cws_page_loader_container" class="cws_loader_container">
					<div id="cws_page_loader" class="cws_loader">
						<span>' . esc_html__( "LOADING...", "ingenious" ) . '</span>
						<div class="hex"></div>
						<div class="hex"></div>
						<div class="hex"></div>
						<div class="hex"></div>
						<div class="hex"></div>
						<div class="hex"></div>
						<div class="hex"></div>
					</div>
			</div>';
		}
	}
}

function ingenious_woo_columns (){
	$woo_columns = ingenious_get_option('woo_column');
}
function ingenious_render_builder_gradient_rules( $options ) {
	extract(shortcode_atts(array(
		'cws_gradient_color_from' => INGENIOUS_THEME_COLOR,
		'cws_gradient_color_to' => INGENIOUS_THEME_COLOR,
		'cws_gradient_type' => 'linear',
		'cws_gradient_angle' => '45',
		'cws_gradient_shape_variant_type' => 'simple',
		'cws_gradient_shape_type' => 'ellipse',
		'cws_gradient_size_keyword_type' => 'farthest-corner',
		'cws_gradient_size_type' => '',
	), $options));
	$out = '';
	if ( $cws_gradient_type == 'linear' ) {
		$out .= "background: -webkit-linear-gradient(" . $cws_gradient_angle . "deg, $cws_gradient_color_from, $cws_gradient_color_to);";
		$out .= "background: -o-linear-gradient(" . $cws_gradient_angle . "deg, $cws_gradient_color_from, $cws_gradient_color_to);";
		$out .= "background: -moz-linear-gradient(" . $cws_gradient_angle . "deg, $cws_gradient_color_from, $cws_gradient_color_to);";
		$out .= "background: linear-gradient(" . $cws_gradient_angle . "deg, $cws_gradient_color_from, $cws_gradient_color_to);";
	}
	else if ( $cws_gradient_type == 'radial' ) {
		if ( $cws_gradient_shape_variant_type == 'simple' ) {
			$out .= "background: -webkit-radial-gradient(" . ( !empty( $cws_gradient_shape_type ) ? " " . $cws_gradient_shape_type . "," : "" ) . " $cws_gradient_color_from, $cws_gradient_color_to);";
			$out .= "background: -o-radial-gradient(" . ( !empty( $cws_gradient_shape_type ) ? " " . $cws_gradient_shape_type . "," : "" ) . " $cws_gradient_color_from, $cws_gradient_color_to);";
			$out .= "background: -moz-radial-gradient(" . ( !empty( $cws_gradient_shape_type ) ? " " . $cws_gradient_shape_type . "," : "" ) . " $cws_gradient_color_from, $cws_gradient_color_to);";
			$out .= "background: radial-gradient(" . ( !empty( $cws_gradient_shape_type ) ? " " . $cws_gradient_shape_type . "," : "" ) . " $cws_gradient_color_from, $cws_gradient_color_to);";
		}
		else if ( $cws_gradient_shape_variant_type == 'extended' ) {
		
			$out .= "background: -webkit-radial-gradient(" . ( !empty( $cws_gradient_size_type ) ? " " . $cws_gradient_size_type . "," : "" ) . ( !empty( $cws_gradient_size_keyword_type ) ? " " . $cws_gradient_size_keyword_type . "," : "" ) . " $cws_gradient_color_from, $cws_gradient_color_to);";
			$out .= "background: -o-radial-gradient(" . ( !empty( $cws_gradient_size_type ) ? " " . $cws_gradient_size_type . "," : "" ) . ( !empty( $cws_gradient_size_keyword_type ) ? " " . $cws_gradient_size_keyword_type . "," : "" ) . " $cws_gradient_color_from, $cws_gradient_color_to);";
			$out .= "background: -moz-radial-gradient(" . ( !empty( $cws_gradient_size_type ) ? " " . $cws_gradient_size_type . "," : "" ) . ( !empty( $cws_gradient_size_keyword_type ) ? " " . $cws_gradient_size_keyword_type . "," : "" ) . " $cws_gradient_color_from, $cws_gradient_color_to);";
			$out .= "background: radial-gradient(" . ( !empty( $cws_gradient_size_keyword_type ) && !empty( $cws_gradient_size_type ) ? " $cws_gradient_size_keyword_type at $cws_gradient_size_type" : "" ) . " $cws_gradient_color_from, $cws_gradient_color_to);";
		}
	}
	$out .= "border-color: transparent;-webkit-background-clip: border;-moz-background-clip: border;background-clip: border-box;-webkit-background-origin: border;-moz-background-origin: border;background-origin: border-box;";
	return preg_replace('/\s+/',' ', $out);
}

if(!function_exists('ingenious_print_img_html')){
	function ingenious_print_img_html($img, $img_args, $img_id, &$img_height = null) {
		$src = '';
		$img_h = 0;
		if ($img && !is_array($img) ) {
			$attach = wp_get_attachment_image_src( $img, 'full' );
			if ($attach) {
				list($src, $width, $height) = $attach;
				$img = array('src'=> $src, 'width' => $width, 'height' => $height, 'is_high_dpi' => '1');
			} else {
				return $src;
			}
		} else if ($img && !isset($img['is_high_dpi'] ) ) {
			$img['is_high_dpi'] = '1';
		} else if (empty($img['width']) && empty($img['height'])) {
			$attach = wp_get_attachment_image_src( $img['id'], 'full' );
			if ($attach) {
				list($src, $width, $height) = $attach;
				$img['width'] = $width;
				$img['height'] = $height;
			}
		}
		$is_high_dpi = (isset($img['is_high_dpi']) && $img['is_high_dpi'] == '1');
		if ( $is_high_dpi ) {
			if ( empty($img_args['width']) && empty($img_args['height']) ) {
				if (isset($img['width']) && isset($img['height'])) {
					$img_args = array(
						'width' => floor( (int) $img['width'] / 2 ),
						'height' => floor( (int) $img['height'] / 2 ),
						'crop' => true,
						);
				}
			}
			$thumb_obj = ingenious_thumb( $img['src'],$img_args, $img_id );
			if ($thumb_obj) {
				$img_h = !empty($img_args["height"]) ? $img_args["height"] : '';
				$thumb_path_hdpi = !empty($thumb_obj[3]) ? " src='". esc_url( $thumb_obj[0] ) ."' data-at2x='" . esc_attr( $thumb_obj[3] ) ."'" : " src='". esc_url( $thumb_obj[0] ) . "' data-no-retina";
				$src = $thumb_path_hdpi;
			}
		} else {
			$img_h = $img['height'];
			$src = " src='".esc_url( $img['src'] )."' data-no-retina";
		}
		if ($img_height) {
			$img_height = $img_h;
		}
		$src .= ' alt';
		return $src;
	}
}

?>