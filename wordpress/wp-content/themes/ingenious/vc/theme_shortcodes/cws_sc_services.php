<?php
	// Map Shortcode in Visual Composer

	$icon_params = ingenious_icon_vc_sc_config_params ();
	$params = ingenious_merge_arrs( array(
		$icon_params,
		array(
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"heading"		=> esc_html__( 'Title', 'ingenious' ),
				"param_name"	=> "title",
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"heading"		=> esc_html__( 'Title Top padding (px)', 'ingenious' ),
				"param_name"	=> "title_top_padding",
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Url', 'ingenious' ),
				"param_name"	=> "button_url",
				"dependency"	=> array(
					"not_empty"	=> true
				)
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "custom_title_color",
				"value"			=> array( esc_html__( 'Customize Title Color', 'ingenious' ) => true )
			),
			array(
				"type"			=> "colorpicker",
				"param_name"	=> "title_color",
				"dependency"	=> array(
					"element"	=> "custom_title_color",
					"not_empty"	=> true
				),
				"value"			=> "#000"
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Icon Shape Type', 'ingenious' ),
				"param_name"	=> "icon_shape",
				"value"			=> array(
					esc_html__( 'Circle', 'ingenious' )			=> 'circle',
					esc_html__( 'Triangle', 'ingenious' )			=> 'triangle',
					esc_html__( 'Triangle Rotate', 'ingenious' )	=> 'triangle_2',
					esc_html__( 'Rhomb', 'ingenious' )				=> 'rhomb',
					esc_html__( 'Shield', 'ingenious' )			=> 'shield',
					esc_html__( 'None', 'ingenious' )				=> 'none',
				) 
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "shape_shadow",
				"value"			=> array( esc_html__( 'Add Shadow', 'ingenious' ) => true ),
				"std"			=> true
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "without_stroke",
				"value"			=> array( esc_html__( 'Shape Without Stroke', 'ingenious' ) => true ),
				"std"			=> true
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "custom_shape_color",
				"value"			=> array( esc_html__( 'Customize Shape Colors', 'ingenious' ) => true )
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Fill Color', 'ingenious' ),
				"param_name"	=> "fill_color",
				"dependency"	=> array(
					"element"	=> "custom_shape_color",
					"not_empty"	=> true
				),
				"value"			=> '#ffffff'
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Stroke Color', 'ingenious' ),
				"param_name"	=> "stroke_color",
				"dependency"	=> array(
					"element"	=> "custom_shape_color",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Icon Position', 'ingenious' ),
				"param_name"	=> "icon_pos",
				"value"			=> array(
					esc_html__( 'Center', 'ingenious' )	=> 'icon_center',
					esc_html__( 'Left', 'ingenious' )		=> 'icon_left',
					esc_html__( 'Right', 'ingenious' )		=> 'icon_right'
				) 
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Icon Size', 'ingenious' ),
				"param_name"	=> "icon_size",
				"value"			=> array(
					esc_html__( 'Small', 'ingenious' )			=> 'small',
					esc_html__( 'Medium', 'ingenious' )		=> 'medium',
					esc_html__( 'Regular', 'ingenious' )		=> 'regular',
					esc_html__( 'Large', 'ingenious' )			=> 'large',
					esc_html__( 'Extra Large', 'ingenious' )	=> 'extra_large',
				),
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "custom_icon_color",
				"value"			=> array( esc_html__( 'Customize Icon Color', 'ingenious' ) => true )
			),
			array(
				"type"			=> "colorpicker",
				"param_name"	=> "font_color",
				"dependency"	=> array(
					"element"	=> "custom_icon_color",
					"not_empty"	=> true
				),
				"value"			=> "#000"
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
				"type"			=> "checkbox",
				"param_name"	=> "button_new_tab",
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				),
				"value"			=> array( esc_html__( 'Open Link in New Tab', 'ingenious' ) => true )
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Button Size', 'ingenious' ),
				"param_name"	=> "button_size",
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				),
				"value"			=> array(
					esc_html__( 'Regular', 'ingenious' )		=> 'regular',
					esc_html__( 'Small', 'ingenious' )		=> 'small',
					esc_html__( 'Large', 'ingenious' )		=> 'large'
				) 
			),
			array(
				"type"			=> "iconpicker",
				"heading"		=> esc_html__( 'Button Icon', 'ingenious' ),
				"param_name"	=> "button_icon",
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				),
				"value"			=> ""
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "button_alt",
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				),
				"value"			=> array( esc_html__( 'Fill with Color', 'ingenious' ) => true )			
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "button_customize_colors",
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				),
				"value"			=> array( esc_html__( 'Edit Colors', 'ingenious' ) => true )			
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Font Color', 'ingenious' ),
				"param_name"	=> "buttom_custom_color",
				"dependency"	=> array(
					"element"	=> "button_customize_colors",
					"not_empty"	=> true
				),
				"value"			=> '#fff'
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Background Color', 'ingenious' ),
				"param_name"	=> "button_custom_color_bg",
				"dependency"	=> array(
					"element"	=> "button_customize_colors",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Border Color', 'ingenious' ),
				"param_name"	=> "button_custom_color_border",
				"dependency"	=> array(
					"element"	=> "button_customize_colors",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Hover Font Color', 'ingenious' ),
				"param_name"	=> "button_custom_color_hover",
				"dependency"	=> array(
					"element"	=> "button_customize_colors",
					"not_empty"	=> true
				),
				"value"			=> '#fff'
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Hover Background Color', 'ingenious' ),
				"param_name"	=> "button_custom_color_bg_hover",
				"dependency"	=> array(
					"element"	=> "button_customize_colors",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Hover Border Color', 'ingenious' ),
				"param_name"	=> "button_custom_color_border_hover",
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
		"name"				=> esc_html__( 'CWS Services Column', 'ingenious' ),
		"base"				=> "cws_sc_services",
		'category'			=> "By CWS",
		"weight"			=> 80,
		"params"			=> $params
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_CWS_Sc_Services extends WPBakeryShortCode {
	    }
	}
?>