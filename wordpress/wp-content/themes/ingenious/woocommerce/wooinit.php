<?php

class Ingenious_WooExt{

	public $def_args;
	public $args;
	public $def_img_sizes;

	public function __construct ( $args = array() ){
		$this->args = wp_parse_args( $args, $this->def_args );
		add_theme_support( 'woocommerce' );	// Declare Woo Support
		add_action( 'activate_woocommerce/woocommerce.php', array( $this, 'on_woo_activation' ), 10 );
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$this->def_args = array(
				'shop_catalog_image_size' 		=> array(),
				'shop_single_image_size'		=> array(),
				'shop_thumbnail_image_size'		=> array(),
				'shop_thumbnail_image_spacings'	=> array(),
				'shop_single_image_spacings'	=> array()
			);
			add_action( 'after_switch_theme', array( $this, 'after_switch_theme' ) );
			add_action( 'woocommerce_init', array( $this, 'woo_init' ) );
			add_filter( 'woocommerce_enqueue_styles', '__return_false' );
			add_filter( 'woocommerce_show_page_title', '__return_false' );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_script' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_style' ), 11 );
			add_action( 'ingenious_custom_colors_hook',  array( $this, 'custom_colors_styles' ) );
			add_action( 'ingenious_body_font_hook',  array( $this, 'body_font_styles' ) );
			add_action( 'ingenious_header_font_hook',  array( $this, 'header_font_styles' ) );
			if ( in_array( 'woocommerce-grid-list-toggle/woocommerce-grid-list-toggle.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
				$this->gridlist_init();
			}
		}	
	}
	public function on_woo_activation (){
		/* set product images dimensions */
		update_option( 'shop_catalog_image_size', $this->args['shop_catalog_image_size'] ); 
		update_option( 'shop_single_image_size', $this->args['shop_single_image_size'] ); 
		update_option( 'shop_thumbnail_image_size', $this->args['shop_thumbnail_image_size'] ); 
		/* set product images dimensions */
	}
	public function after_switch_theme (){
		/* set product images dimensions */
		update_option( 'shop_catalog_image_size', $this->args['shop_catalog_image_size'] ); 
		update_option( 'shop_single_image_size', $this->args['shop_single_image_size'] ); 
		update_option( 'shop_thumbnail_image_size', $this->args['shop_thumbnail_image_size'] ); 
		/* set product images dimensions */
	}
	public function woo_init (){
		/* loop */
		remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10, 0 ); 
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5, 0 ); 
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10, 0 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 ); 
		
		add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_rating', 5, 0 ); 
		add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'after_shop_loop_item_title_wrapper_open' ), 1 );
		add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'after_shop_loop_item_title_wrapper_close' ), 20 );
		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'after_shop_loop_item_wrapper_open' ), 1 );
		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'after_shop_loop_item_wrapper_close' ), 20 );
		add_action( 'woocommerce_before_shop_loop_item', array( $this, 'shop_loop_item_content_wrapper_open' ), 1 );
		add_action( 'woocommerce_before_subcategory', array( $this, 'shop_loop_item_content_wrapper_open' ), 1 );
		add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'shop_loop_item_content_wrapper_close' ), 28 );
		add_action( 'woocommerce_after_subcategory', array( $this, 'shop_loop_item_content_wrapper_close' ), 28 );
		add_action( 'woocommerce_after_subcategory', array( $this, 'divider' ), 30, 0 );
		add_filter( 'loop_shop_per_page', array( $this, 'loop_products_per_page' ), 20 );	
		/* \loop */
		/* single */
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10, 0 );
		remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_rating', 5, 0 ); 
		add_filter( 'ingenious_woo_single_product_thumbnail_section_classes', array( $this, 'product_thumbnails_carousel_init' ) );	
		add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 ); 
		add_action( 'ingenious_woo_single_before_product_thumbnails', array( $this, 'single_product_thumbnails_carousel_nav' ) );
		add_action( 'woocommerce_cart_collaterals', array( $this, 'divider' ), 1 );
		
		add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_products_args' ) );				
		/* single */
		/* widgets */
		add_action( 'woocommerce_before_mini_cart', array( $this, 'minicart_wrapper_open' ) );
		add_action( 'woocommerce_after_mini_cart', array( $this, 'minicart_wrapper_close' ) );
		add_action( 'wp_ajax_woocommerce_remove_from_cart', array( $this, 'ajax_remove_from_cart' ), 1000 );
		add_action( 'wp_ajax_nopriv_woocommerce_remove_from_cart', array( $this, 'ajax_remove_from_cart' ), 1000 );
		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'header_add_to_cart_fragment' ) );
		/* \widgets */
		$this->set_img_dims();
		add_filter( 'woocommerce_breadcrumb_defaults', array( $this, 'change_breadcrumb_delimiter' ) );
	}

	public function gridlist_init (){
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
		add_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 40 );
		add_action( 'woocommerce_before_shop_loop', array( $this, 'remove_excess_gridlist_actions' ), 40 );	
		add_action( 'wp', array( $this, 'remove_excess_gridlist_actions' ), 30 );
	}

	public function set_img_dims (){
		global $pagenow;
	 	if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
			return;
		}
		if ( isset( $this->args['shop_catalog_image_size'] ) && !empty( $this->args['shop_catalog_image_size'] ) ){
			update_option( 'shop_catalog_image_size', $this->args['shop_catalog_image_size'] );		
		}
		if ( isset( $this->args['shop_single_image_size'] ) && !empty( $this->args['shop_single_image_size'] ) ){
			update_option( 'shop_single_image_size', $this->args['shop_single_image_size'] );		
		}
		if ( isset( $this->args['shop_thumbnail_image_size'] ) && !empty( $this->args['shop_thumbnail_image_size'] ) ){
			update_option( 'shop_thumbnail_image_size', $this->args['shop_thumbnail_image_size'] );		
		}
	}

	public function divider (){
		echo "<hr />";
	}

	static function get_wc_placeholder_img_src (){
		$image_link = wc_placeholder_img_src();
		$has_ext = preg_match( "#\.[^(\.)]*$#", $image_link, $matches );
		if ( $has_ext ){
			$ext = $has_ext ? $matches[0] : "";
			$wc_placeholder_img_name = "wc_placeholder_img";
			$wp_upload_dir = wp_upload_dir();
			$wp_upload_base_dir = isset( $wp_upload_dir['basedir'] ) ? $wp_upload_dir['basedir'] : "";
			$woo_upload_dir = trailingslashit( $wp_upload_base_dir ) . "woocommerce_uploads";
			$wc_placeholder_img_src = trailingslashit( $woo_upload_dir ) . "{$wc_placeholder_img_name}{$ext}";
			if ( !file_exists( $wc_placeholder_img_src ) ){
				$image_editor = wp_get_image_editor( $image_link );
				if ( ! is_wp_error( $image_editor ) ) {
					$image_editor->save( $wc_placeholder_img_src );
					return $wc_placeholder_img_src;
				}
			}
			else{
				return $wc_placeholder_img_src;
			}
		}
		return false;
	}

	public function change_breadcrumb_delimiter( $defaults ) {
		$defaults['delimiter'] = ' > ';
		return $defaults;
	}

	/**/
	/* STYLES */
	/**/
	public function enqueue_style() {
		if ( class_exists( 'woocommerce' ) ) {
			$is_rtl = is_rtl();
			wp_register_style( 'woocommerce', INGENIOUS_THEME_URI . '/woocommerce/css/woocommerce.css', array( 'main' ) );
			wp_enqueue_style( 'woocommerce' );
			if ( in_array( 'woocommerce-grid-list-toggle/woocommerce-grid-list-toggle.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {		
				wp_register_style( 'woocommerce_gridlist', INGENIOUS_THEME_URI . '/woocommerce/css/woocommerce_gridlist.css', array( 'grid-list-layout', 'grid-list-button' ) );	
				wp_enqueue_style( 'woocommerce_gridlist' );
			}
			if ( $is_rtl ){
				wp_register_style( 'woocommerce-rtl', INGENIOUS_THEME_URI . '/woocommerce/css/woocommerce-rtl.css', array( 'main', 'woocommerce' ) );
				wp_enqueue_style( 'woocommerce-rtl' );
				if ( in_array( 'woocommerce-grid-list-toggle/woocommerce-grid-list-toggle.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {		
					wp_register_style( 'woocommerce_gridlist-rtl', INGENIOUS_THEME_URI . '/woocommerce/css/woocommerce_gridlist-rtl.css', array( 'grid-list-layout', 'grid-list-button', 'woocommerce_gridlist' ) );	
					wp_enqueue_style( 'woocommerce_gridlist-rtl' );
				}				
			}
			$this->custom_styles();
		}
	}
	public function custom_styles(){
		$product_thumb_dims = get_option( 'shop_single_image_size' );
		$product_thumb_width = isset( $product_thumb_dims['width'] ) ? $product_thumb_dims['width'] : $this->args['shop_single_image_size']['width'];	
		ob_start();
		var_dump( $this->args['shop_thumbnail_image_spacings'] );
		if ( isset( $this->args['shop_thumbnail_image_spacings'] ) && !empty( $this->args['shop_thumbnail_image_spacings'] ) ){
			echo ".woo_product_post_thumbnail.post_single_post_thumbnail{";
			foreach ( $this->args['shop_thumbnail_image_spacings'] as $key => $value) {
				echo "padding-{$key}: {$value}px;";		
			}
			echo "}";
			echo ".woo_product_post_media.post_single_post_media .thumbnails{";
			foreach ( $this->args['shop_thumbnail_image_spacings'] as $key => $value) {
				echo "margin-{$key}: -{$value}px;";		
			}
			echo "}";
		}
		if ( isset( $this->args['shop_single_image_spacings'] ) && !empty( $this->args['shop_single_image_spacings'] ) ){
			echo ".woo_product_post_media_wrapper.post_single_post_media_wrapper > .pic:not(:only-child){";
			foreach ( $this->args['shop_single_image_spacings'] as $key => $value) {
				echo "margin-{$key}: {$value}px;";		
			}
			echo "}";
		}
		$custom_styles = ob_get_clean();
		if ( !empty( $custom_styles ) ){
			wp_add_inline_style( 'woocommerce', $custom_styles );
		}
	}
	public function custom_colors_styles() {
		$theme_custom_color = ingenious_get_option( 'theme_color' );
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
		if ( class_exists( 'woocommerce' ) ) {
			ob_start();
			if ( !empty( $theme_custom_color ) ){
				echo "ul.products .product:hover hr,
						.woo_banner.sale_bunner:before,
						.woo_banner.sale_bunner:after,
						.woo_banner.sale_bunner .woo_banner_text:before,
						.woo_banner.sale_bunner .woo_banner_text:after,
						.shop_table.cart .product-remove a:before,
						.woocommerce .button:hover,
						.woocommerce .cart-collaterals h2:before,
						.woocommerce a.checkout-button:hover,
						.woocommerce-billing-fields h3:before,
						.woocommerce-shipping-fields h3:before,
						.woocommerce #place_order:hover,
						.woocommerce .woocommerce-Button.button,
						.product_list_widget .mini_cart_item .remove:hover:before,
						.product_list_widget .mini_cart_item .remove:hover:after,
						.woocommerce-error,
						.woocommerce-thankyou-order-failed,
						.woo_banner_wrapper,
						.products:not(.list) .added_to_cart,
						ul li.widget.widget_price_filter:after,
						.shop_table.cart .coupon .button:hover{
							background-color: $theme_custom_color;
						}
						.product .price,
						.cws_woo_single_product_thumbnails .carousel_nav:hover,
						.woocommerce.add_to_cart_inline,
						div.product .comment-text .meta strong,
						.product_list_widget li > a,
						.woocommerce .shipping-calculator-button:hover,
						.widget_top_rated_products li > span,
						.widget_top_rated_products li > ins,
						.mini_cart_item span.quantity,
						.woocommerce-error:after,
						.woocommerce-thankyou-order-failed:after,
						.products:not(.list) .added_to_cart:hover,
						a.woocommerce-product-gallery__trigger:before,
						.woocommerce .coupon .button,
						.shop_table.cart input[name=\"update_cart\"]:hover,
						.shop_table.cart button[name=\"update_cart\"]:hover,
						.woocommerce .cart_totals .shop_table .order-total td,
						table.woocommerce-checkout-review-order-table .order-total{
							color: $theme_custom_color;
						}
						.woocommerce .checkout-button:hover,
						.woocommerce .button,
						.woocommerce #place_order:hover,
						.woocommerce .woocommerce-Button.button,
						.products:not(.list) .added_to_cart,
						.top_panel_woo_minicart .buttons .button.checkout{
							border-color: $theme_custom_color;
						}
						.wc-tabs > li.active,
						.woocommerce-MyAccount-navigation ul li.is-active{
							border-bottom-color: $theme_custom_color;
						}";
			}
			if ( !empty( $theme_custom_color ) ){
				echo ".woo_panel .gridlist-toggle > a.active,
						.woo_panel .gridlist-toggle > a:hover,
						.price_slider .ui-slider-handle,
						.product .summary form.cart .quantity ~ .single_add_to_cart_button,
						.checkout_coupon input[name=\"apply_coupon\"],
						.widget_shopping_cart_content .buttons .button.wc-forward:hover,
						.woocommerce-info,
						.top_panel_woo_minicart .buttons .button,
						.widget_shopping_cart_content .buttons .button.wc-forward{
							background-color: $theme_custom_color;
						}
						.woocommerce .shipping-calculator-button,
						.product_meta span > a,
						.woocommerce-info:after{
							color: $theme_custom_color;
						}
						.woo_panel .gridlist-toggle > a.active,
						.woo_panel .gridlist-toggle > a:hover,
						.product .summary form.cart .quantity ~ .single_add_to_cart_button,
						.woocommerce .coupon .button,
						.checkout_coupon input[name=\"apply_coupon\"],
						.widget_shopping_cart_content .buttons .button.wc-forward,
						.top_panel_woo_minicart .buttons .button{
							border-color: $theme_custom_color;
						}
						.price_slider span.ui-slider-handle:after{
							border-top-color: $theme_custom_color;
						}
						.price_slider span.ui-slider-handle:before{
							border-bottom-color: $theme_custom_color;
						}";
			}
			if ( !empty( $theme_custom_color ) ){
				echo ".added_to_cart,
						.shop_table.cart input[name=\"update_cart\"],
						.widget_shopping_cart_content .buttons .button.checkout:hover,
						.top_panel_woo_minicart .buttons .button.checkout,
						.widget .woocommerce-product-search .screen-reader-text,
						.woocommerce input[name=\"update_cart\"],
						.woocommerce button[name=\"update_cart\"].button,
						.woocommerce .cart_totals .shop_table .shipping-calculator-form .button{
							border-color: $theme_custom_color;
						}
						.added_to_cart:hover,
						.woocommerce-message,
						.myaccount_user,
						.shop_table.cart input[name=\"update_cart\"],
						.widget_shopping_cart_content .buttons .button.checkout:hover,
						.top_panel_woo_minicart .buttons .button.checkout,
						.widget .woocommerce-product-search .screen-reader-text,
						.woocommerce input[name=\"update_cart\"],
						.woocommerce button[name=\"update_cart\"].button,
						.woocommerce .cart_totals .shop_table .shipping-calculator-form .button,
						.woocommerce-thankyou-order-received{
							background-color: $theme_custom_color;
						}
						.wc-tabs > li.active{
							border-top-color: $theme_custom_color;
						}
						.woocommerce-message:after,
						.myaccount_user:after,
						.widget .woocommerce-product-search .screen-reader-text.hover,
						.products:not(.list) .gridlist-buttonwrap .added_to_cart.wc-forward,
						.woocommerce-thankyou-order-received:after{
							color:  $theme_custom_color;
						}";
			}
			if ( !empty( $theme_helper_color ) ){
				echo ".widget_shopping_cart_content .buttons .button.checkout,
					  .widget_shopping_cart_content .buttons .button.wc-forward:not(.checkout):hover,
					  .woocommerce .checkout-button,
					  .woocommerce #place_order,
					  .woocommerce .woocommerce-Button.button,
					  .price_slider_wrapper .price_slider_amount .button{
							background: $theme_helper_color;					  	
							border-color: $theme_helper_color;
						}
						.mini_cart_item .remove:before,
						.mini_cart_item .remove:after{
							background-color: $theme_helper_color;
						}
						.price_slider .ui-slider-handle:before{
							background: $theme_helper_color;
						}";
			}			
			$styles = ob_get_clean();
			echo sprintf("%s", $styles);
		}
	}
	public function body_font_styles (){
		$font_options = ingenious_get_option( 'body_font' );
		$font_family = $font_options['font-family'];
		$font_size = $font_options['font-size'];
		$line_height = $font_options['line-height'];
		$font_color = $font_options['color'];
		if ( class_exists( 'woocommerce' ) ) {
			ob_start();
			if ( !empty( $font_size ) ){
				echo ".widget .woocommerce-product-search .screen-reader-text:before{
					font-size: $font_size;
				}";
			}
			if ( !empty( $font_color ) ){
				echo ".top_panel_woo_minicart,
						.woocommerce .button,
						.woocommerce .shipping-calculator-button:hover,
						.woocommerce .checkout-button:hover,
						.checkout_coupon input[name=\"apply_coupon\"]:hover{
					color: $font_color;
				}";
			}
			$styles = ob_get_clean();
			echo sprintf("%s", $styles);
		}
	}
	public function header_font_styles (){
		$font_options = ingenious_get_option( 'header_font' );
		$font_family = $font_options['font-family'];
		$font_size = $font_options['font-size'];
		$line_height = $font_options['line-height'];
		$font_color = $font_options['color'];
		if ( class_exists( 'woocommerce' ) ) {
			ob_start();
			if ( !empty( $font_size ) ){
				echo "";
			}
			if ( !empty( $font_family ) ){
				echo "ul.products.list li.product .woo_product_post_title.posts_grid_post_title{
					font-family: $font_family;
				}";
			}
			if ( !empty( $font_color ) ){
				echo ".top_panel_woo_minicart.widget ul,
						ul.products.list li.product .woo_product_post_title.posts_grid_post_title{
					color: $font_color;
				}";
			}
			$styles = ob_get_clean();
			echo sprintf("%s", $styles);
		}
	}
	/**/
	/* \STYLES */
	/**/

	/**/
	/* SCRIPTS */
	/**/
	public function enqueue_script() {
		wp_register_script( 'ingenious_woo', INGENIOUS_THEME_URI . '/woocommerce/js/woocommerce.js' );
		wp_enqueue_script('ingenious_woo_single', INGENIOUS_THEME_URI . '/woocommerce/js/single-product.js', array('jquery','wc-single-product') );
		if ( class_exists( 'woocommerce' ) ) {
			wp_enqueue_script( 'ingenious_woo' );
		}
	}
	/**/
	/* SCRIPTS */
	/**/

	/**/
	/* LOOP */
	/**/
	public function loop_products_per_page() {
		return (int) ingenious_get_option( 'woo_num_products' );
	}
	public function after_shop_loop_item_title_wrapper_open (){
		echo "<div class='ingenious_after_shop_loop_item_title_wrapper clearfix'>";
	}
	public function after_shop_loop_item_title_wrapper_close (){
		echo "</div>";
	}
	public function after_shop_loop_item_wrapper_open (){
		echo "<div class='ingenious_after_shop_loop_item_wrapper clearfix'>";
	}
	public function after_shop_loop_item_wrapper_close (){
		echo "</div>";
	}
	public function shop_loop_item_content_wrapper_open (){
		echo "<div class='ingenious_shop_loop_item_content_wrapper'>";
	}
	public function shop_loop_item_content_wrapper_close (){
		echo "</div>";
	}
	public function remove_excess_gridlist_actions (){
		$actions = array(
			'woocommerce_after_shop_loop_item'	=> array( 'gridlist_buttonwrap_open', 'gridlist_buttonwrap_close', 'gridlist_hr'/*, 'woocommerce_template_single_excerpt'*/ )
		);
		global $wp_filter;
		foreach ( $actions as $hook => $functions ) {
			if ( array_key_exists( $hook, $wp_filter ) ){
				$reg_functions = &$wp_filter[$hook];
				foreach ( $reg_functions as $reg_id => $reg_atts ){
					foreach ( $reg_atts as $reg_method_id => $reg_method_atts) {
						$reg_method = $reg_method_atts['function'];
						$reg_method_name = "";
						if ( is_array( $reg_method ) && isset( $reg_method[1] ) ){
							$reg_method_name = $reg_method[1];
						}else{
							$reg_method_name = $reg_method;
						}
						if ( in_array( $reg_method_name, $functions ) ){
							if ( empty( $wp_filter[$hook][$reg_id] ) ) unset( $wp_filter[$hook][$reg_id] );
							break 1;
						}
					}
				}
			}
		}
	}
	/**/
	/* \LOOP */
	/**/

	/**/
	/* SINGLE */
	/**/
	public function product_thumbnails_carousel_init ( $classes ){
		global $product;
		if ( !isset( $product ) ) return $classes;
		$attachment_ids = $product->get_gallery_attachment_ids();
		$product_thumb_dims = get_option( 'shop_single_image_size' );
		$product_thumb_width = isset( $product_thumb_dims['width'] ) ? $product_thumb_dims['width'] : $this->args['shop_single_image_size']['width'];
		$thumb_dims = get_option( 'shop_thumbnail_image_size' );
		$thumb_width = isset( $thumb_dims['width'] ) ? $thumb_dims['width'] : $this->args['shop_thumbnail_image_size']['width'];
		$visible_items = (int)floor( $product_thumb_width / $thumb_width );
		if ( count( $attachment_ids ) > $visible_items ){
			$classes[] = "carousel";
			$classes[] = "woo_product_thumbnail_carousel";
			$classes[] = "carousel_cols_$visible_items";
		}	
		return $classes;
	}
	public function single_product_thumbnails_carousel_nav (){
		global $product;
		if ( !isset( $product ) ) return $classes;
		$attachment_ids = $product->get_gallery_attachment_ids();
		$product_thumb_dims = get_option( 'shop_single_image_size' );
		$product_thumb_width = isset( $product_thumb_dims['width'] ) ? $product_thumb_dims['width'] : $this->args['shop_single_image_size']['width'];
		$thumb_dims = get_option( 'shop_thumbnail_image_size' );
		$thumb_width = isset( $thumb_dims['width'] ) ? $thumb_dims['width'] : $this->args['shop_thumbnail_image_size']['width'];
		$visible_items = (int)floor( $product_thumb_width / $thumb_width );
		if ( count( $attachment_ids ) > $visible_items ){
			?>
				<div class='carousel_nav prev'></div>
				<div class='carousel_nav next'></div>
			<?php
		}		
	}
	public function related_products_args( $args ) {
		global $product;
		$ppp_cols = ingenious_get_option( 'woo_related_columns' );
		$ppp = ingenious_get_option( 'woo_related_num_products' );
		$args['posts_per_page'] = $ppp;
		$args['columns'] = $ppp_cols;
		return $args;
	}
	/**/
	/* \SINGLE */
	/**/

	/**/
	/* WIDGETS */
	/**/
	public function ajax_remove_from_cart() {
		global $woocommerce;

		$woocommerce->cart->set_quantity( $_POST['remove_item'], 0 );

		$ver = explode( '.', WC_VERSION );

		if ( $ver[1] == 1 && $ver[2] >= 2 ) :
			$wc_ajax = new WC_AJAX();
			$wc_ajax->get_refreshed_fragments();
		else :
			woocommerce_get_refreshed_fragments();
		endif;

		die();
	}
	public function header_add_to_cart_fragment( $fragments ) {
		global $woocommerce;
		ob_start();
			?>
				<span class='woo_mini_count'><?php echo ( (WC()->cart->cart_contents_count > 0) ? esc_html( WC()->cart->cart_contents_count ) : '' ) ?></span>
			<?php
			$fragments['.woo_mini_count'] = ob_get_clean();

			ob_start();
			woocommerce_mini_cart();
			$fragments['.cws_woo_minicart_wrapper'] = ob_get_clean();

			return $fragments;
	}
	public function minicart_wrapper_open (){
		echo "<div class='cws_woo_minicart_wrapper'>";
	}
	public function minicart_wrapper_close (){
		echo "</div>";
	}
	/**/
	/* \WIDGETS */
	/**/
}

/**/
/* Config and enable extension */
/**/
$ingenious_woo_args = array(
	'shop_catalog_image_size'		=> array(
		'width'	=> 400,
		'height'=> 400,
		'crop'	=> 1
	),
	'shop_single_image_size'		=> array(
		'width'	=> 430,
		'height'=> 430,
		'crop'	=> 1
	),
	'shop_thumbnail_image_size'		=> array(
		'width'	=> 150,
		'height'=> 150,
		'crop'	=> 1
	),
	'shop_thumbnail_image_spacings' => array(
		'left'	=> 6,
		'right'	=> 5,
		'top'	=> 11
	),
	'shop_single_image_spacings'	=> array(
		'bottom'=> 20
	),
);
$ingenious_woo_ext = new Ingenious_WooExt ( $ingenious_woo_args );
/**/
/* \Config and enable extension */
/**/

/**/
/* Overriden functions */
/**/
function woocommerce_template_loop_product_title(){
	$title = get_the_title();
	$permalink = get_the_permalink();
	echo !empty( $title ) ? "<h3 class='post_title woo_product_post_title posts_grid_post_title'><a href='$permalink'>$title</a></h3>" : "";
}
function woocommerce_template_loop_product_thumbnail (){
	$pid = get_the_id();
	$post_thumb_exists = has_post_thumbnail( $pid );
	$permalink = esc_url( get_the_permalink() );
	$img_url = "";
	if ( $post_thumb_exists ){
		$img_obj = wp_get_attachment_image_src( get_post_thumbnail_id( $pid ), 'full' );
		$img_url = isset( $img_obj[0] ) ? esc_url( $img_obj[0] ) : '';
	}
	else{
		$wc_placeholder_img_src = Ingenious_WooExt::get_wc_placeholder_img_src();
		$img_url = $wc_placeholder_img_src ? $wc_placeholder_img_src : $img_url;
	}
	if ( empty( $img_url ) ) return false;
	$lightbox_en = get_option( 'woocommerce_enable_lightbox' ) == 'yes' ? true : false;	
	ob_start();
	echo "<a href='$permalink' class='cws_overlay'></a>";
	$lightbox = ob_get_clean();	
	$thumb_dims = array( 'width' => '400' . 'px', 'height' => '400' . 'px' , 'crop' => true);
	$thumb_id = get_post_thumbnail_id( $pid );
	$thumb_obj = ingenious_thumb( $img_url, $thumb_dims, $thumb_id );
	$thumb_url = isset( $thumb_obj[0] ) ? esc_url( $thumb_obj[0] ) : "";
    $thumb_url_retina = isset( $thumb_obj[3] ) ? esc_url($thumb_obj[3]) : "";
	$thumb_url_retina = $thumb_url_retina == null ? "data-no-retina" : "data-at2x='$thumb_url_retina'";
	ob_start();
	woocommerce_show_product_loop_sale_flash();
	$sale = ob_get_clean();
	$sale_banner = !empty( $sale ) ? "<div class='woo_banner_wrapper'>$sale</div>" : "";
	echo "<div class='post_media woo_product_post_media posts_grid_post_media'>";
		echo !empty( $sale_banner ) ? $sale_banner : "";
		echo "<div class='pic'>";
			echo "<img src='$thumb_url' $thumb_url_retina alt />";
			echo "<div class='hover-effect'></div>";
			echo sprintf("%s", $lightbox);
		echo "</div>";
	echo '</div>';
}
/**/
/* \Overriden functions */
/**/

// Reposition WooCommerce breadcrumb
function ingenious_remove_woo_breadcrumb() {
	remove_action(
	'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
}
add_action(
	'woocommerce_before_main_content', 'ingenious_remove_woo_breadcrumb'
);


?>
