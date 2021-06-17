<?php
	if ( !class_exists( 'Ingenious_VC_Config' ) ){
		class Ingenious_VC_Config{

			public function __construct ( $args = array() ){
				add_action( 'admin_init', array( $this, 'remove_meta_boxes' ) );
				add_action( 'admin_menu', array( $this, 'remove_grid_elements_menu' ) );
				add_action( 'vc_iconpicker-type-cws_flaticons', array( $this, 'add_cws_flaticons' ) );
				add_action( 'init', array( $this, 'remove_vc_elements' ) );
				add_action( 'init', array( $this, 'modify_vc_elements' ) );
				add_action( 'init', array( $this, 'config' ) );
				add_action( 'init', array( $this, 'extend_shortcodes' ) );
				add_action( 'init', array( $this, 'extend_params' ) );
			}
			public function config (){
				vc_set_default_editor_post_types( array(
					'page',					
					'megamenu_item'
				));
				vc_set_shortcodes_templates_dir( trailingslashit( get_template_directory() ) . 'vc/templates' );
			}
			public function get_defaults (){
				$this->args = wp_parse_args( $this->args, $this->defaults );
			}
			// Extend Composer with Theme Shortcodes
			public function extend_shortcodes (){
				if(function_exists('cws_load_shortc_textdomain')){
					get_template_part('vc/theme_shortcodes/cws_sc_portfolio_posts_grid' );
					get_template_part('vc/theme_shortcodes/cws_sc_staff_posts_grid' );
					get_template_part('vc/theme_shortcodes/cws_sc_vc_blog' );
					get_template_part('vc/theme_shortcodes/cws_sc_icon' );
					get_template_part('vc/theme_shortcodes/cws_sc_button' );
					get_template_part('vc/theme_shortcodes/cws_sc_embed' );
					get_template_part('vc/theme_shortcodes/cws_sc_carousel' );
					get_template_part('vc/theme_shortcodes/cws_sc_banner' );
					get_template_part('vc/theme_shortcodes/cws_sc_call_to_action' );			
					get_template_part('vc/theme_shortcodes/cws_sc_msg_box' );	
					get_template_part('vc/theme_shortcodes/cws_sc_progress_bar' );
					get_template_part('vc/theme_shortcodes/cws_sc_milestone' );			
					get_template_part('vc/theme_shortcodes/cws_sc_services' );
					get_template_part('vc/theme_shortcodes/cws_sc_benefits' );
					get_template_part('vc/theme_shortcodes/cws_sc_testimonial' );
					get_template_part('vc/theme_shortcodes/cws_sc_pricing_plan' );	
					get_template_part('vc/theme_shortcodes/cws_sc_divider' );
					get_template_part('vc/theme_shortcodes/cws_sc_twitter' );
					get_template_part('vc/theme_shortcodes/cws_sc_spacing' );
					get_template_part('vc/theme_shortcodes/cws_sc_time_line' );
					get_template_part('vc/theme_shortcodes/cws_sc_processes' );
					get_template_part('vc/theme_shortcodes/cws_sc_process' );

					get_template_part('vc/theme_widgets/cws_widget_text' );						
					get_template_part('vc/theme_widgets/cws_widget_social' );
					get_template_part('vc/theme_widgets/cws_widget_twitter' );
					get_template_part('vc/theme_widgets/cws_widget_latest_posts' );
					get_template_part('vc/theme_widgets/cws_widget_staff' );
				}
											
			}
			// Extend Composer with Custom Parametres
			public function extend_params (){
				require_once( trailingslashit( get_template_directory() ) . 'vc/params/cws_dropdown.php' );
				require_once( trailingslashit( get_template_directory() ) . 'vc/params/cws_svg.php' );
			}
			// Modify VC Elements
			public function modify_vc_elements (){
				vc_remove_param( 'vc_row', 'full_height' );
				vc_remove_param( 'vc_row', 'columns_placement' );
				vc_remove_param( 'vc_tta_accordion', 'style' );
				vc_remove_param( 'vc_tta_accordion', 'shape' );
				vc_remove_param( 'vc_tta_accordion', 'color' );
				vc_remove_param( 'vc_tta_accordion', 'no_fill' );
				vc_remove_param( 'vc_tta_accordion', 'spacing' );
				vc_remove_param( 'vc_tta_accordion', 'gap' );
				vc_remove_param( 'vc_tta_accordion', 'c_icon' );
				vc_remove_param( 'vc_tta_tabs', 'style' );
				vc_remove_param( 'vc_tta_tabs', 'shape' );
				vc_remove_param( 'vc_tta_tabs', 'color' );
				vc_remove_param( 'vc_tta_tabs', 'no_fill_content_area' );
				vc_remove_param( 'vc_tta_tabs', 'spacing' );
				vc_remove_param( 'vc_tta_tabs', 'gap' );
				vc_remove_param( 'vc_tta_tabs', 'pagination_style' );
				vc_remove_param( 'vc_tta_tabs', 'pagination_color' );
				vc_remove_param( 'vc_toggle', 'style' );
				vc_remove_param( 'vc_toggle', 'color' );
				vc_remove_param( 'vc_toggle', 'size' );
				vc_remove_param( 'vc_images_carousel', 'partial_view' );	
			}
			
			// Remove VC Elements
			public function remove_vc_elements (){
				if ( function_exists( 'vc_remove_element' ) ) {
					vc_remove_element( 'vc_separator' );
					vc_remove_element( 'vc_text_separator' );
					vc_remove_element( 'vc_message' );
					vc_remove_element( 'vc_gallery' );
					vc_remove_element( 'vc_tta_tour' );
					vc_remove_element( 'vc_tta_pageable' );
					vc_remove_element( 'vc_custom_heading' );
					vc_remove_element( 'vc_cta' );
					vc_remove_element( 'vc_posts_slider' );
					vc_remove_element( 'vc_progress_bar' );
					vc_remove_element( 'vc_basic_grid' );
					vc_remove_element( 'vc_media_grid' );
					vc_remove_element( 'vc_masonry_grid' );
					vc_remove_element( 'vc_masonry_media_grid' );
					vc_remove_element( 'vc_widget_sidebar' );
				}
			}
			public function add_cws_flaticons ( $icons ){
				$icon_id = "";
				$fi_array = array();
				$fi_icons = ingenious_get_all_flaticon_icons();
				$fi_exists = is_array( $fi_icons ) && !empty( $fi_icons );				
				if ( !is_array( $fi_icons ) || empty( $fi_icons ) ){
					return $icons;
				}
				for ( $i = 0; $i < count( $fi_icons ); $i++ ){
					$icon_id = $fi_icons[$i];
					$icon_class = "flaticon-{$icon_id}";
					array_push( $fi_array, array( "$icon_class" => $icon_id ) );
				}
				$icons = array_merge( $icons, $fi_array );
				return $icons;
			}
			// Remove teaser metabox
			public function remove_meta_boxes() {
				remove_meta_box( 'vc_teaser', 'page', 		'side' );
				remove_meta_box( 'vc_teaser', 'post', 		'side' );
				remove_meta_box( 'vc_teaser', 'portfolio', 	'side' );
				remove_meta_box( 'vc_teaser', 'product', 	'side' );
			}
			// Remove 'Grid Elements' from Admin menu
			public function remove_grid_elements_menu(){
			  remove_menu_page( 'edit.php?post_type=vc_grid_item' );
			}
		}
	}
	/**/
	/* Config and enable extension */
	/**/
	$vc_config = new Ingenious_VC_Config ();
	/**/
	/* \Config and enable extension */
	/**/
	if(!class_exists('VC_CWS_Background')){
		class VC_CWS_Background extends Ingenious_VC_Config{
			static public $columns = 0;
			static public $row_atts = '';
			function __construct(){
				add_action('admin_init',array($this,'cws_bg_init'));
			}
			public static function cws_open_vc_shortcode($atts, $content){
				$theme_color 		= esc_attr( ingenious_get_option( "theme_color" ) );
				$bg_image_position = $bg_cws_size = $bg_cws_attachment = $customize_colors_overlay = $cws_overlay_color = $bg_cws_repeat = $html = "";
				extract( shortcode_atts( array(
				    "gap" => "",
				    "bg_cws_repeat" => "",		   
				    "bg_image_position" => "",
				    "customize_colors_overlay" => "",
				    "full_width" => "",
				    "bg_cws_size" => "",
				    "bg_cws_attachment" => "",
				    "cws_overlay_color" => $theme_color,
				), $atts ) );	
				$over_section = !empty($atts['over_section']) ? $atts['over_section'] : '';
				$output = '<!-- CWS Row -->';
				$el_style_bg = isset($bg_cws_repeat) && !empty($bg_cws_repeat) ? 'background-repeat:'.$bg_cws_repeat.';' : '';
				$el_style_bg .= isset($bg_cws_size) && !empty($bg_cws_size) ? 'background-size:'.$bg_cws_size.';' : '';
				$el_style_bg .= isset($bg_cws_attachment) && !empty($bg_cws_attachment) ? 'background-attachment:'.$bg_cws_attachment.';' : '';
				if ($over_section == 1) {
					$el_style_bg .= 'z-index:3;';
				}
				if(isset($bg_image_position) && !empty($bg_image_position)){
					switch ($bg_image_position) {
						case 'left_top':
							$el_style_bg .= 'background-position:0% 0%;';
							break;
						case 'left_center':
							$el_style_bg .= 'background-position:0% 50%;';
							break;
						case 'left_bottom':
							$el_style_bg .= 'background-position:0% 100%;';
							break;
						case 'right_top':
							$el_style_bg .= 'background-position:100% 0%;';
							break;
						case 'right_center':
							$el_style_bg .= 'background-position:100% 50%;';
							break;
						case 'right_bottom':
							$el_style_bg .= 'background-position:100% 100%;';
							break;
						case 'center_top':
							$el_style_bg .= 'background-position:50% 0%;';
							break;
						case 'center_center':
							$el_style_bg .= 'background-position:50% 50%;';
							break;
						case 'center_bottom':
							$el_style_bg .= 'background-position:50% 100%;';
							break;
					}
				}
				$output .= '<div class="cws-content"'.(!empty($el_style_bg) ? ' style="'.esc_attr($el_style_bg).'"' : "").'>';
				self::$row_atts = $atts;
				if (!empty($el_style_bg)){
					self::$row_atts['img_style'] = $el_style_bg;
				}
				return $output;
			}

			public static function cws_open_vc_shortcode_column($atts, $content){
				$sc_obj = Vc_Shortcodes_Manager::getInstance()->getElementClass( 'vc_row' );
				$row_class_vc = vc_map_get_attributes( $sc_obj->getShortcode(), self::$row_atts );
				extract( $row_class_vc );
				$theme_color = esc_attr( ingenious_get_option( "theme_color" ) );
				$output = '';
				$clip_bg = '';
				$img_style = !empty(self::$row_atts['img_style']) ? self::$row_atts['img_style'] : '';
				// custom indents
				$default_top_indent = !empty(self::$row_atts['ingenious_default_top_indent']) ? self::$row_atts['ingenious_default_top_indent'] : 100;
				$landscape_top_indent = !empty(self::$row_atts['ingenious_landscape_top_indent']) ? self::$row_atts['ingenious_landscape_top_indent'] : 100;
				$portrait_top_indent = !empty(self::$row_atts['ingenious_portrait_top_indent']) ? self::$row_atts['ingenious_portrait_top_indent'] : 100;
				$mobile_top_indent = !empty(self::$row_atts['ingenious_mobile_top_indent']) ? self::$row_atts['ingenious_mobile_top_indent'] : 90;
				// row step
				$row_step = !empty(self::$row_atts['row_step']) ? self::$row_atts['row_step'] : false;
				$row_step_text = !empty(self::$row_atts['row_step_text']) ? self::$row_atts['row_step_text'] : '';
				$row_step_number = !empty(self::$row_atts['row_step_number']) ? self::$row_atts['row_step_number'] : '';
				$row_step_link_en = !empty(self::$row_atts['row_step_link_en']) ? self::$row_atts['row_step_link_en'] : false;
				$row_step_link = !empty(self::$row_atts['row_step_link']) ? self::$row_atts['row_step_link'] : '';
				$row_step_custom_colors = !empty(self::$row_atts['row_step_custom_colors']) ? self::$row_atts['row_step_custom_colors'] : false;
				$row_step_color = !empty(self::$row_atts['row_step_color']) ? self::$row_atts['row_step_color'] : '#ffffff';
				$row_step_color_gradient = !empty(self::$row_atts['row_step_color_gradient']) ? self::$row_atts['row_step_color_gradient'] : 'color';
				$row_step_bg_color = !empty(self::$row_atts['row_step_bg_color']) ? self::$row_atts['row_step_bg_color'] : $theme_color;
				$row_step_gradient_from = !empty(self::$row_atts['row_step_gradient_from']) ? self::$row_atts['row_step_gradient_from'] : $theme_color;
				$row_step_gradient_to = !empty(self::$row_atts['row_step_gradient_to']) ? self::$row_atts['row_step_gradient_to'] : $theme_color;
				$row_step_gradient_angle = !empty(self::$row_atts['row_step_gradient_angle']) ? self::$row_atts['row_step_gradient_angle'] : '45';
				$row_step = (bool)$row_step;
				$row_step_text = esc_html( $row_step_text );
				$row_step_number = esc_html( $row_step_number );
				$row_step_link_en = (bool)$row_step_link_en;
				$row_step_link = esc_url( $row_step_link );
				$row_step_custom_colors = (bool)$row_step_custom_colors;
				$row_step_uniqid = uniqid( 'row_step_' );
				$row_step_url = $row_step_link_en && !empty($row_step_link) ? "href='$row_step_link'" : "href='#" . $row_step_uniqid . "'";
				$row_step_color = ( $row_step_custom_colors && !empty($row_step_color)) ? "style='color:$row_step_color;'" : '';
				if ($row_step_color_gradient == 'color') {
					$row_step_bg_color = ($row_step_custom_colors && !empty($row_step_bg_color)) ? "style='background:$row_step_bg_color;'" : '';
				} else if($row_step_color_gradient == 'gradient'){
					$row_step_bg_color = ($row_step_custom_colors && !empty($row_step_bg_color)) ? "style='background:linear-gradient(" . $row_step_gradient_angle . "deg, $row_step_gradient_from, $row_step_gradient_to);'" : '';
				}
				// \row step
				$top_crop = !empty(self::$row_atts['top_crop']) ? self::$row_atts['top_crop'] : 'left_crop';
				$bot_crop = !empty(self::$row_atts['bot_crop']) ? self::$row_atts['bot_crop'] : 'left_crop';

				$top_left_overlay_color = !empty(self::$row_atts['top_left_overlay_color']) ? self::$row_atts['top_left_overlay_color'] : $theme_color;
				$top_right_overlay_color = !empty(self::$row_atts['top_right_overlay_color']) ? self::$row_atts['top_right_overlay_color'] : $theme_color;
				$bot_left_overlay_color = !empty(self::$row_atts['bot_left_overlay_color']) ? self::$row_atts['bot_left_overlay_color'] : $theme_color;
				$bot_right_overlay_color = !empty(self::$row_atts['bot_right_overlay_color']) ? self::$row_atts['bot_right_overlay_color'] : $theme_color;
				$top_crossing = !empty(self::$row_atts['top_crossing']) ? self::$row_atts['top_crossing'] : '50';
				$bot_crossing = !empty(self::$row_atts['bot_crossing']) ? self::$row_atts['bot_crossing'] : '50';
				if (!empty(self::$row_atts['top_sep']) || !empty(self::$row_atts['bot_sep'])) {
					if (!empty(self::$row_atts['top_sep'])) {
						$top_crop = explode( ",", $top_crop );
						$p_1 = '0% 0%';
						$p_2 = $top_crossing . '% 60px';
						$p_3 = '100% 0%';
						if (in_array( 'left_crop', $top_crop)){
							$p_1 = '0% 120px';
							$p_3 = '100% 0%';
						}
						if (in_array( 'right_crop', $top_crop)){
							$p_1 = '0% 0%';
							$p_3 = '100% 120px';
						}
						if (in_array( 'left_crop', $top_crop) && in_array( 'right_crop', $top_crop) ) {
							$p_1 = '0% 120px';
							$p_3 = '100% 120px';
						}
					} else {
						$p_1 = '0% 0%';
						$p_2 = '50% 0%';
						$p_3 = '100% 0%';
					}
					if (!empty(self::$row_atts['bot_sep'])) {
						$bot_crop = explode( ",", $bot_crop );
						$p_4 = '100% 100%';
						$p_5 = $bot_crossing . '% calc(100% - 60px)';
						$p_6 = '0% 100%';
						if (in_array( 'left_crop', $bot_crop)){
							$p_4 = '100% 100%';
							$p_6 = '0% calc(100% - 120px)';
						}
						if (in_array( 'right_crop', $bot_crop)){
							$p_4 = '100% calc(100% - 120px)';
							$p_6 = '0% 100%';
						}
						if (in_array( 'left_crop', $bot_crop) && in_array( 'right_crop', $bot_crop) ) {
							$p_4 = '100% calc(100% - 120px)';
							$p_6 = '0% calc(100% - 120px)';
						}
					} else {
						$p_4 = '100% 100%';
						$p_5 = '50% 100%';
						$p_6 = '0% 100%';
					}
					$clip_bg = "clip-path: polygon($p_1, $p_2, $p_3, $p_4, $p_5, $p_6); -webkit-clip-path: polygon($p_1, $p_2, $p_3, $p_4, $p_5, $p_6);";
				}
				if (!empty(self::$row_atts['top_left_overlay'])) {
					$clip_top_left = "clip-path: polygon(0% 0%, " . $top_crossing . "% 60px, 0% 120px); -webkit-clip-path: polygon(0% 0%, " . $top_crossing . "% 60px, 0% 120px);";
					$clip_top_left_color = " background: $top_left_overlay_color";
				}
				if (!empty(self::$row_atts['top_right_overlay'])) {
					$clip_top_right = "clip-path: polygon(" . $top_crossing . "% 60px, 100% 0%, 100% 120px); -webkit-clip-path: polygon(" . $top_crossing . "% 60px, 100% 0%, 100% 120px);";
					$clip_top_right_color = " background: $top_right_overlay_color";
				}
				if (!empty(self::$row_atts['bot_left_overlay'])) {
					$clip_bot_left = "clip-path: polygon(0% calc(100% - 120px), " . $bot_crossing . "% calc(100% - 60px), 0% 100%); -webkit-clip-path: polygon(0% calc(100% - 120px), " . $bot_crossing . "% calc(100% - 60px), 0% 100%);";
					$clip_bot_left_color = " background: $bot_left_overlay_color";
				}
				if (!empty(self::$row_atts['bot_right_overlay'])) {
					$clip_bot_right = "clip-path: polygon(" . $bot_crossing . "% calc(100% - 60px), 100% calc(100% - 120px), 100% 100%); -webkit-clip-path: polygon(" . $bot_crossing . "% calc(100% - 60px), 100% calc(100% - 120px), 100% 100%);";
					$clip_bot_right_color = " background: $bot_right_overlay_color";
				}
				$top_left_crossing_x = $top_right_crossing_x = $top_crossing;
				$bot_left_crossing_x = $bot_right_crossing_x = $bot_crossing;
				$top_left_crossing_y = $top_right_crossing_y = '60px';
				$bot_left_crossing_y = $bot_right_crossing_y = 'calc(100% - 60px)';
				/*left*/
				if (!empty(self::$row_atts['left_points'])) {
					$top_left_crossing_x = !empty(self::$row_atts['left_bg_top_point']) ? self::$row_atts['left_bg_top_point'] : $top_crossing;
					$bot_left_crossing_x = !empty(self::$row_atts['left_bg_bot_point']) ? self::$row_atts['left_bg_bot_point'] : $bot_crossing;
					$top_left_crossing_y = '0';
					$bot_left_crossing_y = '100%';
				}
				/*right*/
				if (!empty(self::$row_atts['right_points'])) {
					$top_right_crossing_x = !empty(self::$row_atts['right_bg_top_point']) ? self::$row_atts['right_bg_top_point'] : $top_crossing;
					$bot_right_crossing_x = !empty(self::$row_atts['right_bg_bot_point']) ? self::$row_atts['right_bg_bot_point'] : $bot_crossing;
					$top_right_crossing_y = '0';
					$bot_right_crossing_y = '100%';
				}
				/*left*/
				$crop_left_color = !empty(self::$row_atts['crop_left_color']) ? self::$row_atts['crop_left_color'] : $theme_color;
				$crop_left_gradient_from = !empty(self::$row_atts['crop_left_gradient_from']) ? self::$row_atts['crop_left_gradient_from'] : $theme_color;
				$crop_left_gradient_to = !empty(self::$row_atts['crop_left_gradient_to']) ? self::$row_atts['crop_left_gradient_to'] : $theme_color;
				$crop_left_bg = !empty(self::$row_atts['crop_left_bg']) ? self::$row_atts['crop_left_bg'] : 'color';
				$crop_left_gradient_angle = !empty(self::$row_atts['crop_left_gradient_angle']) ? self::$row_atts['crop_left_gradient_angle'] : '45';
				/*right*/
				$crop_right_color = !empty(self::$row_atts['crop_right_color']) ? self::$row_atts['crop_right_color'] : $theme_color;
				$crop_right_gradient_from = !empty(self::$row_atts['crop_right_gradient_from']) ? self::$row_atts['crop_right_gradient_from'] : $theme_color;
				$crop_right_gradient_to = !empty(self::$row_atts['crop_right_gradient_to']) ? self::$row_atts['crop_right_gradient_to'] : $theme_color;
				$crop_right_bg = !empty(self::$row_atts['crop_right_bg']) ? self::$row_atts['crop_right_bg'] : 'color';
				$crop_right_gradient_angle = !empty(self::$row_atts['crop_right_gradient_angle']) ? self::$row_atts['crop_right_gradient_angle'] : '45';
				/*left*/
				if ($crop_left_bg == 'color') {
					$clip_bg_left_color = "background: " . $crop_left_color .";";
				} else if ($crop_left_bg == 'gradient') {
					$clip_bg_left_color = "background:linear-gradient(" . $crop_left_gradient_angle . "deg, $crop_left_gradient_from, $crop_left_gradient_to)";
				}
				/*right*/
				if ($crop_right_bg == 'color') {
					$clip_bg_right_color = "background: " . $crop_right_color .";";
				} else if ($crop_right_bg == 'gradient') {
					$clip_bg_right_color = "background:linear-gradient(" . $crop_right_gradient_angle . "deg, $crop_right_gradient_from, $crop_right_gradient_to)";
				}
				/*left*/
				$clip_bg_left = "clip-path: polygon( 0 0, " . $top_left_crossing_x . "% " . $top_left_crossing_y . ", " . $bot_left_crossing_x . "% " . $bot_left_crossing_y . ", 0 100% ); -webkit-clip-path: polygon( 0 0, " . $top_left_crossing_x . "% " . $top_left_crossing_y . ", " . $bot_left_crossing_x . "% " . $bot_left_crossing_y . ", 0 100% );";
				/*right*/
				$clip_bg_right = "clip-path: polygon( 100% 0, " . $top_right_crossing_x . "% " . $top_right_crossing_y . ", " . $bot_right_crossing_x . "% " . $bot_right_crossing_y . ", 100% 100% ); -webkit-clip-path: polygon( 100% 0, " . $top_right_crossing_x . "% " . $top_right_crossing_y . ", " . $bot_right_crossing_x . "% " . $bot_right_crossing_y . ", 100% 100% );";
				$css_class = vc_shortcode_custom_css_class($css);
				self::$columns++;	
				if(self::$columns == 1){
					$custom_class = !empty($css_class) ? $css_class : '';
					$el_style = '';
					if (!empty(self::$row_atts['top_sep'])) {
						$output .= '<div class="cws_spacing">';
							$output .= '<div class="cws_spacing cws_spacing_default" style="height:'.$default_top_indent.'px;"></div>';
							$output .= '<div class="cws_spacing cws_spacing_size_sm_desctop" style="height:'.$landscape_top_indent.'px;"></div>';
							$output .= '<div class="cws_spacing cws_spacing_tablet" style="height:'.$portrait_top_indent.'px;"></div>';
							$output .= '<div class="cws_spacing cws_spacing_mobile" style="height:'.$mobile_top_indent.'px;"></div>';
						$output .= '</div>';
					}
					if(isset(self::$row_atts['bg_cws_color']) && !empty(self::$row_atts['bg_cws_color'])){
						if(self::$row_atts['bg_cws_color'] == 'gradient'){
							$el_style = ingenious_render_builder_gradient_rules(self::$row_atts);
						} elseif(self::$row_atts['bg_cws_color'] == 'color'){
							if (!empty(self::$row_atts['cws_overlay_color'])){
								$el_style =  "background-color:". self::$row_atts['cws_overlay_color'].";"; 
							} elseif(!isset(self::$row_atts['cws_overlay_color'])) {
								$el_style =  "background-color:". esc_attr( ingenious_get_option( "theme_color" ) ).";"; 
							}
						}
					}
					if (!empty(self::$row_atts['top_left_overlay'])) {
						$output .= "<div class='cws-triangle-overlay' style='$clip_top_left $clip_top_left_color'></div>";
					}
					if (!empty(self::$row_atts['top_right_overlay'])) {
						$output .= "<div class='cws-triangle-overlay' style='$clip_top_right $clip_top_right_color'></div>";
					}
					$img_bg_styles = $img_style.$clip_bg;
					$output .= "<div class='cws-image-bg $custom_class'".(!empty($img_bg_styles) ? " style='".esc_attr($img_bg_styles)."' " : "").">"; 
						if (!empty(self::$row_atts['crop_left'])) {
							$output .= "<div class='cws-triangle-overlay' style='$clip_bg_left $clip_bg_left_color'></div>";
						}
						if(isset(self::$row_atts['cws_pattern_image']) && !empty(self::$row_atts['cws_pattern_image'])){
							$src = wp_get_attachment_image_src(self::$row_atts['cws_pattern_image']);
							$output .= "<div class='cws-overlay-bg' style='background-image:url(".esc_attr($src[0]).")'></div>";
						}
						if(!empty($el_style)){
							$output .= "<div class='cws-overlay-bg ' style='".esc_attr($el_style)."'></div>";
						}
						if (!empty(self::$row_atts['crop_right'])) {
							$output .= "<div class='cws-triangle-overlay' style='$clip_bg_right $clip_bg_right_color'></div>";
						}
					$output .= "</div>"; 
					if (!empty(self::$row_atts['bot_left_overlay'])) {
						$output .= "<div class='cws-triangle-overlay' style='$clip_bot_left $clip_bot_left_color'></div>";
					}
					if (!empty(self::$row_atts['bot_right_overlay'])) {
						$output .= "<div class='cws-triangle-overlay' style='$clip_bot_right $clip_bot_right_color'></div>";
					}
					if ($row_step) {
						$output .= "<div class='row_step " . ($row_step_link_en ? 'custom_link' : '') . "' $row_step_color>";
							$output .= "<a class='row_step_link' $row_step_url>";
								$output .= "<div class='row_step_bg' $row_step_bg_color></div>";
								$output .= "<h6 class='row_step_text'>$row_step_text</h6>";
								$output .= "<h1 class='row_step_number'>$row_step_number</h1>";
								$output .= "<i class='row_step_icon fa fa-arrow-down'></i>";
							$output .= "</a>";
						$output .= "</div>";
					}
				}
				return $output;
			} 
			/* end parallax_shortcode */

			public static function cws_close_vc_shortcode_column($atts, $content){
				$output = '';
				if (!empty(self::$row_atts['bot_sep'])) {
					$output = '<div class="cws_spacing">';
						$output .= '<div class="cws_spacing cws_spacing_default" style="height:'.(!empty(self::$row_atts['ingenious_default_bottom_indent']) ? self::$row_atts['ingenious_default_bottom_indent'] : 100).'px;"></div>';
						$output .= '<div class="cws_spacing cws_spacing_size_sm_desctop" style="height:'.(!empty(self::$row_atts['ingenious_landscape_bottom_indent']) ? self::$row_atts['ingenious_landscape_bottom_indent'] : 85).'px;"></div>';
						$output .= '<div class="cws_spacing cws_spacing_tablet" style="height:'.(!empty(self::$row_atts['ingenious_portrait_bottom_indent']) ? self::$row_atts['ingenious_portrait_bottom_indent'] : 85).'px;"></div>';
						$output .= '<div class="cws_spacing cws_spacing_mobile" style="height:'.(!empty(self::$row_atts['ingenious_mobile_bottom_indent']) ? self::$row_atts['ingenious_mobile_bottom_indent'] : 50).'px;"></div>';
					$output .= '</div>';
				}
				return $output;
			}

			public static function cws_close_vc_shortcode($atts, $content){		
				self::$row_atts = '';
				if(isset(self::$columns) && !empty(self::$columns)){
					self::$columns = 0;
				}

				return $output = "</div>";
			}

			function cws_bg_init(){
				$group_name = esc_html__('Design Options', 'ingenious');
				$group_name_sep = esc_html__('CWS Row Separator', 'ingenious');
				$group_name_step = esc_html__('CWS Row Step', 'ingenious');
				$theme_color = esc_attr( ingenious_get_option( "theme_color" ) );
				if(function_exists('vc_add_param')){
					vc_add_param('vc_row',array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Background Image Repeat", 'ingenious'),
							"param_name" => "bg_cws_repeat",
							"value" => array(							
									__("Repeat", 'ingenious') => "repeat",
									__("No Repeat", 'ingenious') => "no-repeat",
									__("Repeat X", 'ingenious') => "repeat-x",
									__("Repeat Y", 'ingenious') => "repeat-y",
								),
							"description" => esc_html__("Options to control repeatation of the background image. Learn on <a href='http://www.w3schools.com/cssref/playit.asp?filename=playcss_background-repeat' target='_blank'>W3School</a>", 'ingenious'),
							"group" => $group_name,
						)
					);
					vc_add_param('vc_row',array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Background Attachment", 'ingenious'),
							"param_name" => "bg_cws_attachment",
							"value" => array(
									__("Scroll", 'ingenious') => "scroll",
									__("Fixed", 'ingenious') => "fixed",
								),
							"group" => $group_name,
						)
					);
					vc_add_param('vc_row',array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Background Image Size", 'ingenious'),
							"param_name" => "bg_cws_size",
							"value" => array(
									__("Initial", 'ingenious') => "initial",
									__("Cover", 'ingenious') => "cover",
									__("Contain", 'ingenious') => "contain",
								),
							"group" => $group_name,
						)
					);
					vc_add_param('vc_row',array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Background Image Position", 'ingenious'),
							"param_name" => "bg_image_position",
							"value" => array(
									__("Left Top", 'ingenious') => "left_top",
									__("Left Center", 'ingenious') => "left_center",
									__("Left Bottom", 'ingenious') => "left_bottom",
									__("Right Top", 'ingenious') => "right_top",
									__("Right Center", 'ingenious') => "right_center",
									__("Right Bottom", 'ingenious') => "right_bottom",
									__("Center Top", 'ingenious') => "center_top",
									__("Center Center", 'ingenious') => "center_center",
									__("Center Bottom", 'ingenious') => "center_bottom",
								),	
							"group" => $group_name,
						)
					);
					vc_add_param('vc_row',array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Background Color", 'ingenious'),
							"param_name"		=> "bg_cws_color",
							"value" => array(
									__("None", 'ingenious') => "none",
									__("Color", 'ingenious') => "color",
									__("Gradient", 'ingenious') => "gradient",
								),
							"group" => $group_name,
						)
					);
					vc_add_param('vc_row',array(
							"type" => "colorpicker",
							"class" => "",
							"heading"		=> esc_html__( 'Color', 'ingenious' ),
							"param_name" => "cws_overlay_color",
							"group" => $group_name,
							"dependency"	=> array(
								"element"	=> "bg_cws_color",
								'value' => 'color',
								
							),
							"value"			=> $theme_color
						)
					);						
					vc_add_param('vc_row',array(
							"type" => "colorpicker",
							"class" => "",
							"heading"		=> esc_html__( 'From', 'ingenious' ),
							"param_name" => "cws_gradient_color_from",
							"group" => $group_name,
							"dependency"	=> array(
								"element"	=> "bg_cws_color",
								'value' => 'gradient',
								
							),
							"value"			=> $theme_color
						)
					);					
					vc_add_param('vc_row',array(
							"type" => "colorpicker",
							"class" => "",
							"heading"		=> esc_html__( 'To', 'ingenious' ),
							"param_name" => "cws_gradient_color_to",
							"group" => $group_name,
							"dependency"	=> array(
								"element"	=> "bg_cws_color",
								'value' => 'gradient',
								
							),
							"value"			=> $theme_color
						)
					);
					vc_add_param('vc_row',array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Type", 'ingenious'),
							"param_name"		=> "cws_gradient_type",
							"value" => array(
									__("Linear", 'ingenious') => "linear",
									__("Radial", 'ingenious') => "radial",
								),
							"group" => $group_name,
							"dependency"	=> array(
								"element"	=> "bg_cws_color",
								'value' => 'gradient',
								
							),
						)
					);	
					vc_add_param('vc_row',array(
							"type"			=> "textfield",
							"class" => "",
							"heading"		=> esc_html__( 'Angle', 'ingenious' ),
							"param_name"	=> "cws_gradient_angle",
							"value" => '45',
							"description"	=> esc_html__( 'Degrees: -360 to 360', 'ingenious' ),
							"group" => $group_name,
							"dependency"	=> array(
								"element"	=> "cws_gradient_type",
								'value' => 'linear',						
							),
						)
					);
					vc_add_param('vc_row',array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Shape variant", 'ingenious'),
							"param_name"		=> "cws_gradient_shape_variant_type",
							"value" => array(
									__("Simple", 'ingenious') => "simple",
									__("Extended", 'ingenious') => "extended",
								),
							"group" => $group_name,
							"dependency"	=> array(
								"element"	=> "cws_gradient_type",
								'value' => 'radial',	
							),
						)
					);					
					vc_add_param('vc_row',array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Shape", 'ingenious'),
							"param_name"		=> "cws_gradient_shape_type",
							"value" => array(
									__("Ellipse", 'ingenious') => "ellipse",
									__("Circle", 'ingenious') => "circle",
								),
							"group" => $group_name,
							"dependency"	=> array(
								"element"	=> "cws_gradient_shape_variant_type",
								'value' => 'simple',	
							),
						)
					);						
					vc_add_param('vc_row',array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Size keyword", 'ingenious'),
							"param_name"		=> "cws_gradient_size_keyword_type",
							"value" => array(
									__("Closest side", 'ingenious') => "closest_side",
									__("Farthest side", 'ingenious') => "farthest_side",
									__("Closest corner", 'ingenious') => "closest_corner",
									__("Farthest corner", 'ingenious') => "farthest_corner",
								),
							"group" => $group_name,
							"dependency"	=> array(
								"element"	=> "cws_gradient_shape_variant_type",
								'value' => 'extended',	
							),
						)
					);						
					vc_add_param('vc_row',array(
							"type" => "textfield",
							"class" => "",
							"heading" => esc_html__("Size", 'ingenious'),
							"param_name"		=> "cws_gradient_size_type",
							"value" => '60% 55%',
							"description"	=> esc_html__( 'Two space separated percent values, for example (60% 55%)', 'ingenious' ),
							"group" => $group_name,
							"dependency"	=> array(
								"element"	=> "cws_gradient_shape_variant_type",
								'value' => 'extended',	
							),
						)
					);					
					vc_add_param('vc_row',array(
							"type" => "attach_image",
							"class" => "",
							"heading" => esc_html__("Pattern", 'ingenious'),
							"param_name"		=> "cws_pattern_image",
							"group" => $group_name,
						)
					);							
					vc_add_param('vc_row',array(
							"type" 				=> "checkbox",
							"value"				=> array( esc_html__( 'Row Over Section', 'ingenious' ) => true ),
							"param_name"		=> "over_section",
							"group" 			=> $group_name,
						)
					);							
					vc_add_param('vc_row',array(
							"type" 				=> "checkbox",
							"value"				=> array( esc_html__( 'Crop Row Background', 'ingenious' ) => true ),
							"param_name"		=> "crop_row",
							"group" 			=> $group_name,
						)
					);							
					vc_add_param('vc_row',array(
							"type" 				=> "checkbox",
							"value"				=> array( esc_html__( 'Enable Left Part', 'ingenious' ) => true ),
							"param_name"		=> "crop_left",
							"dependency"	=> array(
								"element"	=> "crop_row",
								'not_empty' => true,
							),
							"group" 			=> $group_name,
						)
					);		
					vc_add_param('vc_row',array(
							"type" => "dropdown",
							"edit_field_class"	=> 'inside-box',
							"heading" => esc_html__("Background Type Color", 'ingenious'),
							"param_name"		=> "crop_left_bg",
							"value" => array(
									esc_html__("Color", 'ingenious') => "color",
									esc_html__("Gradient", 'ingenious') => "gradient",
								),
							"dependency"	=> array(
								"element"	=> "crop_left",
								'not_empty' => true,
							),
							"group" => $group_name,
						)
					);
					vc_add_param('vc_row',array(
							"type" => "colorpicker",
							"edit_field_class"	=> 'inside-box',
							"heading"		=> esc_html__( 'Color', 'ingenious' ),
							"param_name" => "crop_left_color",
							"group" => $group_name,
							"dependency"	=> array(
								"element"	=> "crop_left_bg",
								'value' => 'color',
							),
							"value"			=> $theme_color
						)
					);						
					vc_add_param('vc_row',array(
							"type" => "colorpicker",
							"edit_field_class"	=> 'inside-box',
							"heading"		=> esc_html__( 'From', 'ingenious' ),
							"param_name" => "crop_left_gradient_from",
							"group" => $group_name,
							"dependency"	=> array(
								"element"	=> "crop_left_bg",
								'value' => 'gradient',
								
							),
							"value"			=> $theme_color
						)
					);					
					vc_add_param('vc_row',array(
							"type" => "colorpicker",
							"edit_field_class"	=> 'inside-box',
							"heading"		=> esc_html__( 'To', 'ingenious' ),
							"param_name" => "crop_left_gradient_to",
							"group" => $group_name,
							"dependency"	=> array(
								"element"	=> "crop_left_bg",
								'value' => 'gradient',
							),
							"value"			=> $theme_color
						)
					);
					vc_add_param('vc_row',array(
							"type"			=> "textfield",
							"edit_field_class"	=> 'inside-box',
							"heading"		=> esc_html__( 'Angle', 'ingenious' ),
							"param_name"	=> "crop_left_gradient_angle",
							"value" => '45',
							"description"	=> esc_html__( 'Degrees: -360 to 360', 'ingenious' ),
							"group" => $group_name,
							"dependency"	=> array(
								"element"	=> "crop_left_bg",
								'value' => 'gradient',						
							),
						)
					);						
					vc_add_param('vc_row',array(
							"type" 				=> "checkbox",
							"value"				=> array( esc_html__( 'Custom Points', 'ingenious' ) => true ),
							"param_name"		=> "left_points",
							"edit_field_class"	=> 'inside-box',
							"group" 			=> $group_name,
							"dependency"	=> array(
								"element"	=> "crop_left",
								'not_empty' => true,
							),
						)
					);		
					vc_add_param('vc_row',array(
							"type" 				=> "textfield",
							"edit_field_class"	=> 'inside-box',
							"heading" 			=> esc_html__("Top Point (in percentages)", 'ingenious'),
							"param_name"		=> "left_bg_top_point",
							"value" 			=> '50',
							"group" 			=> $group_name,
							"dependency"		=> array(
								"element"	=> "left_points",
								"not_empty"	=> true	
							),
						)
					);	
					vc_add_param('vc_row',array(
							"type" 				=> "textfield",
							"edit_field_class"	=> 'inside-box',
							"heading" 			=> esc_html__("Bottom Point (in percentages)", 'ingenious'),
							"param_name"		=> "left_bg_bot_point",
							"value" 			=> '50',
							"group" 			=> $group_name,
							"dependency"		=> array(
								"element"	=> "left_points",
								"not_empty"	=> true	
							),
						)
					);		
					vc_add_param('vc_row',array(
							"type" 				=> "checkbox",
							"value"				=> array( esc_html__( 'Enable Right Part', 'ingenious' ) => true ),
							"param_name"		=> "crop_right",
							"group" 			=> $group_name,
							"dependency"	=> array(
								"element"	=> "crop_row",
								"not_empty"	=> true							
							),
						)
					);	
					vc_add_param('vc_row',array(
							"type" => "dropdown",
							"edit_field_class"	=> 'inside-box',
							"heading" => esc_html__("Background Type Color", 'ingenious'),
							"param_name"		=> "crop_right_bg",
							"value" => array(
									esc_html__("Color", 'ingenious') => "color",
									esc_html__("Gradient", 'ingenious') => "gradient",
								),
							"dependency"	=> array(
								"element"	=> "crop_right",
								"not_empty"	=> true							
							),
							"group" => $group_name,
						)
					);
					vc_add_param('vc_row',array(
							"type" => "colorpicker",
							"edit_field_class"	=> 'inside-box',
							"heading"		=> esc_html__( 'Color', 'ingenious' ),
							"param_name" => "crop_right_color",
							"group" => $group_name,
							"dependency"	=> array(
								"element"	=> "crop_right_bg",
								'value' => 'color',
							),
							"value"			=> $theme_color
						)
					);						
					vc_add_param('vc_row',array(
							"type" => "colorpicker",
							"edit_field_class"	=> 'inside-box',
							"heading"		=> esc_html__( 'From', 'ingenious' ),
							"param_name" => "crop_right_gradient_from",
							"group" => $group_name,
							"dependency"	=> array(
								"element"	=> "crop_right_bg",
								'value' => 'gradient',
								
							),
							"value"			=> $theme_color
						)
					);					
					vc_add_param('vc_row',array(
							"type" => "colorpicker",
							"edit_field_class"	=> 'inside-box',
							"heading"		=> esc_html__( 'To', 'ingenious' ),
							"param_name" => "crop_right_gradient_to",
							"group" => $group_name,
							"dependency"	=> array(
								"element"	=> "crop_right_bg",
								'value' => 'gradient',
								
							),
							"value"			=> $theme_color
						)
					);
					vc_add_param('vc_row',array(
							"type"			=> "textfield",
							"edit_field_class"	=> 'inside-box',
							"heading"		=> esc_html__( 'Angle', 'ingenious' ),
							"param_name"	=> "crop_right_gradient_angle",
							"value" => '45',
							"description"	=> esc_html__( 'Degrees: -360 to 360', 'ingenious' ),
							"group" => $group_name,
							"dependency"	=> array(
								"element"	=> "crop_right_bg",
								'value' => 'gradient',						
							),
						)
					);				
					vc_add_param('vc_row',array(
							"type" 				=> "checkbox",
							"value"				=> array( esc_html__( 'Custom Points', 'ingenious' ) => true ),
							"param_name"		=> "right_points",
							"edit_field_class"	=> 'inside-box',
							"group" 			=> $group_name,
							"dependency"	=> array(
								"element"	=> "crop_right",
								'not_empty' => true,
							),
						)
					);		
					vc_add_param('vc_row',array(
							"type" 				=> "textfield",
							"edit_field_class"	=> 'inside-box',
							"heading" 			=> esc_html__("Top Point (in percentages)", 'ingenious'),
							"param_name"		=> "right_bg_top_point",
							"value" 			=> '50',
							"group" 			=> $group_name,
							"dependency"		=> array(
								"element"	=> "right_points",
								"not_empty"	=> true	
							),
						)
					);	
					vc_add_param('vc_row',array(
							"type" 				=> "textfield",
							"edit_field_class"	=> 'inside-box',
							"heading" 			=> esc_html__("Bottom Point (in percentages)", 'ingenious'),
							"param_name"		=> "right_bg_bot_point",
							"value" 			=> '50',
							"group" 			=> $group_name,
							"dependency"		=> array(
								"element"	=> "right_points",
								"not_empty"	=> true	
							),
						)
					);				
					vc_add_param('vc_row',array(
							"type" 				=> "checkbox",
							"class" 			=> "",
							"value"				=> array( esc_html__( 'Top Separator', 'ingenious' ) => true ),
							"param_name"		=> "top_sep",
							"group" 			=> $group_name_sep,	
							"dependency"		=> array(
								"element"	=> "crop_row",
								"not_empty"	=> true	
							),
						)
					);		
					vc_add_param('vc_row',array(
							'type'				=> 'cws_dropdown',
							'multiple'			=> "true",
							'param_name'		=> 'top_crop',
							"heading" 			=> esc_html__("Top Crop Background", 'ingenious'),
							"group" 			=> $group_name_sep,		
							"dependency"		=> array(
								"element"	=> "top_sep",
								"not_empty"	=> true	
							),
							'edit_field_class'	=> 'inside-box',
							'value'				=> array(
								esc_html__( 'Left Crop', 'ingenious' )			=> 'left_crop',
								esc_html__( 'Right Crop', 'ingenious' )		=> 'right_crop',
								esc_html__( 'Center Crop', 'ingenious' )		=> 'center_crop',
							)
						)
					);
					vc_add_param('vc_row',array(
							"type" 				=> "textfield",
							"edit_field_class"	=> 'inside-box',
							"heading" 			=> esc_html__("Crossing (in percentages)", 'ingenious'),
							"param_name"		=> "top_crossing",
							"value" 			=> '50',
							"description"		=> esc_html__( 'description ....', 'ingenious' ),
							"group" 			=> $group_name_sep,
							"dependency"		=> array(
								"element"	=> "top_sep",
								"not_empty"	=> true	
							),
						)
					);							
					vc_add_param('vc_row',array(
							"type" 				=> "checkbox",
							"edit_field_class"	=> 'inside-box',
							"value"				=> array( esc_html__( 'Left Triangle Overlay', 'ingenious' ) => true ),
							"param_name"		=> "top_left_overlay",
							"group" 			=> $group_name_sep,
							"dependency"		=> array(
								"element"	=> "top_sep",
								"not_empty"	=> true	
							),
						)
					);					
					vc_add_param('vc_row',array(
							"type" => "colorpicker",
							"edit_field_class"	=> 'inside-box',
							"heading"		=> esc_html__( 'Overlay Color', 'ingenious' ),
							"param_name" => "top_left_overlay_color",
							"group" => $group_name_sep,
							"dependency"		=> array(
								"element"	=> "top_left_overlay",
								"not_empty"	=> true	
							),
							"value"			=> $theme_color
						)
					);					
					vc_add_param('vc_row',array(
							"type" 				=> "checkbox",
							"edit_field_class"	=> 'inside-box',
							"value"				=> array( esc_html__( 'Right Triangle Overlay', 'ingenious' ) => true ),
							"param_name"		=> "top_right_overlay",
							"group" 			=> $group_name_sep,
							"dependency"		=> array(
								"element"	=> "top_sep",
								"not_empty"	=> true	
							),
						)
					);					
					vc_add_param('vc_row',array(
							"type" => "colorpicker",
							"edit_field_class"	=> 'inside-box',
							"heading"		=> esc_html__( 'Overlay Color', 'ingenious' ),
							"param_name" => "top_right_overlay_color",
							"group" => $group_name_sep,
							"dependency"		=> array(
								"element"	=> "top_right_overlay",
								"not_empty"	=> true	
							),
							"value"			=> $theme_color
						)
					);
					vc_add_param('vc_row',array(
							"type" => "textfield",
							"edit_field_class"	=> 'vc_col-sm-6 vc_column',
							"heading"		=> esc_html__( 'Default Top Indent', 'ingenious' ),
							"param_name" => "ingenious_default_top_indent",
							"group" => $group_name_sep,
							"dependency"		=> array(
								"element"	=> "top_sep",
								"not_empty"	=> true	
							),
						)
					);
					vc_add_param('vc_row',array(
							"type" => "textfield",
							"edit_field_class"	=> 'vc_col-sm-6 vc_column',
							"heading"		=> esc_html__( 'Landscape Tablet Top Indent', 'ingenious' ),
							"param_name" => "ingenious_landscape_top_indent",
							"group" => $group_name_sep,
							"value"	=> '0',
							"dependency"		=> array(
								"element"	=> "top_sep",
								"not_empty"	=> true	
							),
						)
					);
					vc_add_param('vc_row',array(
							"type" => "textfield",
							"edit_field_class"	=> 'vc_col-sm-6 vc_column',
							"heading"		=> esc_html__( 'Portrait Tablet Top Indent', 'ingenious' ),
							"param_name" => "ingenious_portrait_top_indent",
							"group" => $group_name_sep,
							"value"	=> '0',
							"dependency"		=> array(
								"element"	=> "top_sep",
								"not_empty"	=> true	
							),
						)
					);
					vc_add_param('vc_row',array(
							"type" => "textfield",
							"edit_field_class"	=> 'vc_col-sm-6 vc_column',
							"heading"		=> esc_html__( 'Mobile Top Indent', 'ingenious' ),
							"param_name" => "ingenious_mobile_top_indent",
							"group" => $group_name_sep,
							"value"	=> '0',
							"dependency"		=> array(
								"element"	=> "top_sep",
								"not_empty"	=> true	
							),
						)
					);				
					vc_add_param('vc_row',array(
							"type" 				=> "checkbox",
							"class" 			=> "",
							"value"				=> array( esc_html__( 'Bottom Separator', 'ingenious' ) => true ),
							"param_name"		=> "bot_sep",
							"group" 			=> $group_name_sep,
							"dependency"		=> array(
								"element"	=> "crop_row",
								"not_empty"	=> true	
							),
						)
					);
					vc_add_param('vc_row',array(
							'type'				=> 'cws_dropdown',
							'multiple'			=> "true",
							'param_name'		=> 'bot_crop',
							"heading" 			=> esc_html__("Bottom Crop Background", 'ingenious'),
							"group" 			=> $group_name_sep,		
							"dependency"		=> array(
								"element"	=> "bot_sep",
								"not_empty"	=> true	
							),
							'edit_field_class'	=> 'inside-box',
							'value'				=> array(
								esc_html__( 'Left Crop', 'ingenious' )			=> 'left_crop',
								esc_html__( 'Right Crop', 'ingenious' )		=> 'right_crop',
								esc_html__( 'Center Crop', 'ingenious' )		=> 'center_crop',
							)
						)
					);
					vc_add_param('vc_row',array(
							"type" 				=> "textfield",
							"edit_field_class"	=> 'inside-box',
							"heading" 			=> esc_html__("Crossing (in percentages)", 'ingenious'),
							"param_name"		=> "bot_crossing",
							"value" 			=> '50',
							"description"		=> esc_html__( 'description ....', 'ingenious' ),
							"group" 			=> $group_name_sep,
							"dependency"		=> array(
								"element"	=> "bot_sep",
								"not_empty"	=> true	
							),
						)
					);							
					vc_add_param('vc_row',array(
							"type" 				=> "checkbox",
							"edit_field_class"	=> 'inside-box',
							"value"				=> array( esc_html__( 'Left Triangle Overlay', 'ingenious' ) => true ),
							"param_name"		=> "bot_left_overlay",
							"group" 			=> $group_name_sep,
							"dependency"		=> array(
								"element"	=> "bot_sep",
								"not_empty"	=> true	
							),
						)
					);						
					vc_add_param('vc_row',array(
							"type" => "colorpicker",
							"edit_field_class"	=> 'inside-box',
							"heading"		=> esc_html__( 'Overlay Color', 'ingenious' ),
							"param_name" => "bot_left_overlay_color",
							"group" => $group_name_sep,
							"dependency"		=> array(
								"element"	=> "bot_left_overlay",
								"not_empty"	=> true	
							),
							"value"			=> $theme_color
						)
					);					
					vc_add_param('vc_row',array(
							"type" 				=> "checkbox",
							"edit_field_class"	=> 'inside-box',
							"value"				=> array( esc_html__( 'Right Triangle Overlay', 'ingenious' ) => true ),
							"param_name"		=> "bot_right_overlay",
							"group" 			=> $group_name_sep,
							"dependency"		=> array(
								"element"	=> "bot_sep",
								"not_empty"	=> true	
							),
						)
					);					
					vc_add_param('vc_row',array(
							"type" => "colorpicker",
							"edit_field_class"	=> 'inside-box',
							"heading"		=> esc_html__( 'Overlay Color', 'ingenious' ),
							"param_name" => "bot_right_overlay_color",
							"group" => $group_name_sep,
							"dependency"		=> array(
								"element"	=> "bot_right_overlay",
								"not_empty"	=> true	
							),
							"value"			=> $theme_color
						)
					);
					vc_add_param('vc_row',array(
							"type" => "textfield",
							"edit_field_class"	=> 'vc_col-sm-6 vc_column',
							"heading"		=> esc_html__( 'Default Bottom Indent', 'ingenious' ),
							"param_name" => "ingenious_default_bottom_indent",
							"group" => $group_name_sep,
							"value"	=> '0',
							"dependency"		=> array(
								"element"	=> "bot_sep",
								"not_empty"	=> true	
							),
						)
					);
					vc_add_param('vc_row',array(
							"type" => "textfield",
							"edit_field_class"	=> 'vc_col-sm-6 vc_column',
							"heading"		=> esc_html__( 'Landscape Tablet Bottom Indent', 'ingenious' ),
							"param_name" => "ingenious_landscape_bottom_indent",
							"group" => $group_name_sep,
							"value"	=> '0',
							"dependency"		=> array(
								"element"	=> "bot_sep",
								"not_empty"	=> true	
							),
						)
					);
					vc_add_param('vc_row',array(
							"type" => "textfield",
							"edit_field_class"	=> 'vc_col-sm-6 vc_column',
							"heading"		=> esc_html__( 'Portrait Tablet Bottom Indent', 'ingenious' ),
							"param_name" => "ingenious_portrait_bottom_indent",
							"group" => $group_name_sep,
							"value"	=> '0',
							"dependency"		=> array(
								"element"	=> "bot_sep",
								"not_empty"	=> true	
							),
						)
					);
					vc_add_param('vc_row',array(
							"type" => "textfield",
							"edit_field_class"	=> 'vc_col-sm-6 vc_column',
							"heading"		=> esc_html__( 'Mobile Bottom Indent', 'ingenious' ),
							"param_name" => "ingenious_mobile_bottom_indent",
							"group" => $group_name_sep,
							"value"	=> '0',
							"dependency"		=> array(
								"element"	=> "bot_sep",
								"not_empty"	=> true	
							),
						)
					);
					vc_add_param('vc_row',array(
							"type" 				=> "checkbox",
							"value"				=> array( esc_html__( 'Add Row Step', 'ingenious' ) => true ),
							"param_name"		=> "row_step",
							"group" 			=> $group_name_step,
						)
					);
					vc_add_param('vc_row',array(
							"type"			=> "textfield",
							"heading"		=> esc_html__( 'Text Step', 'ingenious' ),
							"param_name"	=> "row_step_text",
							"group" 		=> $group_name_step,
							"dependency"	=> array(
								"element"	=> "row_step",
								"not_empty"	=> true,						
							),
							"edit_field_class"	=> 'inside-box',
						)
					);	
					vc_add_param('vc_row',array(
							"type"			=> "textfield",
							"heading"		=> esc_html__( 'Step Number', 'ingenious' ),
							"param_name"	=> "row_step_number",
							"group" 		=> $group_name_step,
							"dependency"	=> array(
								"element"	=> "row_step",
								"not_empty"	=> true,						
							),
							"edit_field_class"	=> 'inside-box',
						)
					);							
					vc_add_param('vc_row',array(
							"type" 				=> "checkbox",
							"value"				=> array( esc_html__( 'Custom Step Link', 'ingenious' ) => true ),
							"param_name"		=> "row_step_link_en",
							"group" 			=> $group_name_step,
							"dependency"		=> array(
								"element"	=> "row_step",
								"not_empty"	=> true,						
							),
							"edit_field_class"	=> 'inside-box',
						)
					);
					vc_add_param('vc_row',array(
							"type"			=> "textfield",
							"param_name"	=> "row_step_link",
							"group" 		=> $group_name_step,
							"dependency"	=> array(
								"element"	=> "row_step_link_en",
								"not_empty"	=> true,						
							),
							"edit_field_class"	=> 'inside-box',
						)
					);							
					vc_add_param('vc_row',array(
							"type" 				=> "checkbox",
							"value"				=> array( esc_html__( 'Custom Colors', 'ingenious' ) => true ),
							"param_name"		=> "row_step_custom_colors",
							"group" 			=> $group_name_step,
							"dependency"		=> array(
								"element"	=> "row_step",
								"not_empty"	=> true,						
							),
							"edit_field_class"	=> 'inside-box',
						)
					);
					vc_add_param('vc_row',array(
							"type" 			=> "colorpicker",
							"heading"		=> esc_html__( 'Font Color', 'ingenious' ),
							"param_name" 	=> "row_step_color",
							"group" 		=> $group_name_step,
							"dependency"	=> array(
								"element"	=> "row_step_custom_colors",
								'not_empty' 	=> true,
							),
							"value"			=> '#ffffff'
						)
					);
					vc_add_param('vc_row',array(
							"type" 			=> "dropdown",
							"heading" 		=> esc_html__("Background Color", 'ingenious'),
							"param_name"	=> "row_step_color_gradient",
							"value" 		=> array(
									__("Color", 'ingenious') => "color",
									__("Gradient", 'ingenious') => "gradient",
								),
							"group" 		=> $group_name_step,
							"dependency"	=> array(
								"element"	=> "row_step_custom_colors",
								"not_empty"	=> true,
							),
						)
					);
					vc_add_param('vc_row',array(
							"type" 			=> "colorpicker",
							"heading"		=> esc_html__( 'Background Color', 'ingenious' ),
							"param_name" 	=> "row_step_bg_color",
							"group" 		=> $group_name_step,
							"dependency"	=> array(
								"element"	=> "row_step_color_gradient",
								'value' 	=> 'color',
							),
							"value"			=> '#ffffff'
						)
					);		
					vc_add_param('vc_row',array(
							"type" 			=> "colorpicker",
							"heading"		=> esc_html__( 'Background From', 'ingenious' ),
							"param_name" 	=> "row_step_gradient_from",
							"group" 		=> $group_name_step,
							"dependency"	=> array(
								"element"	=> "row_step_color_gradient",
								'value' 	=> 'gradient',
							),
							"value"			=> $theme_color
						)
					);					
					vc_add_param('vc_row',array(
							"type" 			=> "colorpicker",
							"heading"		=> esc_html__( 'Background To', 'ingenious' ),
							"param_name"	=> "row_step_gradient_to",
							"group" 		=> $group_name_step,
							"dependency"	=> array(
								"element"	=> "row_step_color_gradient",
								'value' 	=> 'gradient',
							),
							"value"			=> $theme_color
						)
					);
					vc_add_param('vc_row',array(
							"type"			=> "textfield",
							"heading"		=> esc_html__( 'Angle', 'ingenious' ),
							"param_name"	=> "row_step_gradient_angle",
							"value" 		=> '45',
							"dependency"	=> array(
								"element"	=> "row_step_color_gradient",
								'value' 	=> 'gradient',
							),
							"description"	=> esc_html__( 'Degrees: -360 to 360', 'ingenious' ),
							"group" 		=> $group_name_step,
						)
					);
				}
			} 
		}
		new VC_CWS_Background;
	}
?>