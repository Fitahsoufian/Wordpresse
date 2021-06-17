<?php
	// Map Shortcode in Visual Composer
	$font_options = function_exists( 'ingenious_get_option' ) ? ingenious_get_option( 'body_font' ) : array();
	$font_color = isset( $font_options['color'] ) ? $font_options['color'] : "";
	vc_map( array(
		"name"				=> esc_html__( 'CWS Button', 'ingenious' ),
		"base"				=> "cws_sc_button",
		'category'			=> "By CWS",
		"weight"			=> 80,
		"params"			=> array(
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"heading"		=> esc_html__( 'Title', 'ingenious' ),
				"param_name"	=> "title",
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Link', 'ingenious' ),
				"param_name"	=> "url",
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "new_tab",
				"value"			=> array( esc_html__( 'Open in New Tab', 'ingenious' ) => true )
			),
			array(
				"type"			=> "iconpicker",
				"heading"		=> esc_html__( 'Icon', 'ingenious' ),
				"param_name"	=> "icon",
				"value"			=> ""
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Icon Position', 'ingenious' ),
				"param_name"	=> "icon_pos",
				"value"			=> array(
					esc_html__( 'Right', 'ingenious' )		=> 'right',
					esc_html__( 'Left', 'ingenious' )		=> 'left'
				) 
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Size', 'ingenious' ),
				"param_name"	=> "size",
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"value"			=> array(
					esc_html__( 'Regular', 'ingenious' )		=> 'regular',
					esc_html__( 'Small', 'ingenious' )			=> 'small',
					esc_html__( 'Large', 'ingenious' )			=> 'large',
				) 
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Hover Animation', 'ingenious' ),
				"param_name"	=> "anim_style",
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"value"			=> array(
					esc_html__( 'Default', 'ingenious' )				=> 'def_anim',
					esc_html__( 'Swipe Left', 'ingenious' )			=> 'swipe_left',
					esc_html__( 'Swipe Right', 'ingenious' )			=> 'swipe_right',
					esc_html__( 'Swipe Top', 'ingenious' )				=> 'swipe_top',
					esc_html__( 'Swipe Bottom', 'ingenious' )			=> 'swipe_bot',
					esc_html__( 'Diagonal Swipe', 'ingenious' )		=> 'swipe_diagonal',
					esc_html__( 'Close Diagonal', 'ingenious' )		=> 'close_diagonal',
					esc_html__( 'Slice', 'ingenious' )					=> 'slice',
					esc_html__( 'Smoosh', 'ingenious' )				=> 'smoosh',
					esc_html__( 'Collision', 'ingenious' )				=> 'collision',
					esc_html__( 'Position Aware', 'ingenious' )		=> 'pos_aware',
					esc_html__( 'Width Shadow', 'ingenious' )			=> 'shadow',
					esc_html__( 'Width Shadow Alternative', 'ingenious' )	=> 'shadow_alt',
					esc_html__( 'None', 'ingenious' )					=> 'none_anim',
				),
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "alt",
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"value"			=> array( esc_html__( 'Fill with Color', 'ingenious' ) => true ),
				"dependency"	=> array(
					"element"	=> "anim_style",
					"value"		=> array('def_anim', 'none_anim')
				),
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "customize_colors",
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"value"			=> array( esc_html__( 'Edit Colors', 'ingenious' ) => true )
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Font Color', 'ingenious' ),
				"param_name"	=> "custom_color",
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"dependency"	=> array(
					"element"	=> "customize_colors",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Background Color', 'ingenious' ),
				"param_name"	=> "custom_color_bg",
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"dependency"	=> array(
					"element"	=> "customize_colors",
					"not_empty"	=> true
				),
				"value"			=> '#fff'
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Border Color', 'ingenious' ),
				"param_name"	=> "custom_color_border",
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"dependency"	=> array(
					"element"	=> "customize_colors",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Font Hover Color', 'ingenious' ),
				"param_name"	=> "custom_hover_color",
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"dependency"	=> array(
					"element"	=> "customize_colors",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Background Hover Color', 'ingenious' ),
				"param_name"	=> "custom_hover_color_bg",
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"dependency"	=> array(
					"element"	=> "customize_colors",
					"not_empty"	=> true
				),
				"value"			=> '#fff'
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Border Hover Color', 'ingenious' ),
				"param_name"	=> "custom_hover_color_border",
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"dependency"	=> array(
					"element"	=> "customize_colors",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Left/Right Padding', 'ingenious' ),
				"param_name"	=> "ofs",
				"group"			=> esc_html__( "Customize", "ingenious" ),
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Button Aligning', 'ingenious' ),
				"param_name"	=> "aligning",
				"value"			=> array(
					esc_html__( 'None', 'ingenious' )		=> '',
					esc_html__( 'Left', 'ingenious' )		=> 'left',
					esc_html__( 'Right', 'ingenious' )		=> 'right',
					esc_html__( 'Center', 'ingenious' )		=> 'center'
				),
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html__( 'Extra class name', 'ingenious' ),
				"description"		=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'ingenious' ),
				"param_name"		=> "el_class",
				"value"				=> ""
			)
		)
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_CWS_Sc_Button extends WPBakeryShortCode {
	    }
	}
?>