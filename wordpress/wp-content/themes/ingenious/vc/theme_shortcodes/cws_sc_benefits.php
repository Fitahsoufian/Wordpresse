<?php
	// Map Shortcode in Visual Composer

	$icon_params = ingenious_icon_vc_sc_config_params ();
	$params = ingenious_merge_arrs( array(
		$icon_params,
		array(
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Icon Size', 'ingenious' ),
				"param_name"	=> "icon_size",
				"value"			=> array(
					esc_html__( 'Small', 'ingenious' )			=> 'small',
					esc_html__( 'Medium', 'ingenious' )			=> 'medium',
					esc_html__( 'Regular', 'ingenious' )		=> 'regular',
					esc_html__( 'Large', 'ingenious' )			=> 'large',
					esc_html__( 'Extra Large', 'ingenious' )	=> 'extra_large',
				),
				"std"			=> 'regular'
			),			
			array(
				"type"			=> "checkbox",
				"param_name"	=> "custom_icon_color",
				"value"			=> array( esc_html__( 'Customize Icon Background Color', 'ingenious' ) => true )
			),
			array(
				"type"			=> "colorpicker",
				"param_name"	=> "icon_color",
				"dependency"	=> array(
					"element"	=> "custom_icon_color",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "attach_image",
				"param_name"	=> "benefit_img",
				"heading"		=> esc_html__( 'Add Benefit Image', 'ingenious' )
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "add_sec_desc",
				"value"			=> array( esc_html__( 'Add Secondary Description', 'ingenious' ) => true )
			),
			array(
				"type"			=> "textarea",
				"heading"		=> esc_html__( 'Secondary Description', 'ingenious' ),
				"param_name"	=> "sec_desc",
				"dependency"	=> array(
					"element"	=> "add_sec_desc",
					"not_empty"	=> true
				),
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "custom_desc_bg",
				"dependency"	=> array(
					"element"	=> "add_sec_desc",
					"not_empty"	=> true
				),
				"value"			=> array( esc_html__( 'Custom Color Hover Background', 'ingenious' ) => true )			
			),
			array(
				"type"			=> "colorpicker",
				"param_name"	=> "desc_bg_color",
				"dependency"	=> array(
					"element"	=> "custom_desc_bg",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "add_button",
				"value"			=> array( esc_html__( 'Add Button', 'ingenious' ) => true )
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Title', 'ingenious' ),
				"param_name"	=> "button_text",
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				),
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Url', 'ingenious' ),
				"param_name"	=> "button_url",
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				)
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "button_new_tab",
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				),
				"value"			=> array( esc_html__( 'Open Link in New Tab', 'ingenious' ) => true )
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "button_customize_colors",
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				),
				"value"			=> array( esc_html__( 'Edit Color', 'ingenious' ) => true )			
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Button Font Color', 'ingenious' ),
				"param_name"	=> "buttom_font_color",
				"dependency"	=> array(
					"element"	=> "button_customize_colors",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Button Background Color', 'ingenious' ),
				"param_name"	=> "buttom_bg_color",
				"dependency"	=> array(
					"element"	=> "button_customize_colors",
					"not_empty"	=> true
				),
				"value"			=> 'transparent'
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Button Border Color', 'ingenious' ),
				"param_name"	=> "buttom_border_color",
				"dependency"	=> array(
					"element"	=> "button_customize_colors",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Button Hover Font Color', 'ingenious' ),
				"param_name"	=> "buttom_hover_font_color",
				"dependency"	=> array(
					"element"	=> "button_customize_colors",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Button Hover Background Color', 'ingenious' ),
				"param_name"	=> "buttom_hover_bg_color",
				"dependency"	=> array(
					"element"	=> "button_customize_colors",
					"not_empty"	=> true
				),
				"value"			=> 'transparent'
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Button Hover Border Color', 'ingenious' ),
				"param_name"	=> "buttom_hover_border_color",
				"dependency"	=> array(
					"element"	=> "button_customize_colors",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html__( 'Extra class name', 'ingenious' ),
				"description"		=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'ingenious' ),
				"param_name"		=> "el_class",
				"value"				=> ""
			),			
			array(
				"type"			=> "textarea_html",
				"heading"		=> esc_html__( 'Description', 'ingenious' ),
				"param_name"	=> "content",
			)
		)
	));
	vc_map( array(
		"name"				=> esc_html__( 'CWS Benefits', 'ingenious' ),
		"base"				=> "cws_sc_benefits",
		'category'			=> "By CWS",
		"weight"			=> 80,
		"params"			=> $params
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_CWS_Sc_Benefits extends WPBakeryShortCode {
	    }
	}
?>