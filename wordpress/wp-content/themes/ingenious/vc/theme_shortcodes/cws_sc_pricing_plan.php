<?php
	// Map Shortcode in Visual Composer
	$icon_params = ingenious_icon_vc_sc_config_params ();
	$params = ingenious_merge_arrs( array(
		$icon_params,
		array(
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
					esc_html__( 'None', 'ingenious' )				=> '',
				) 
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"heading"		=> esc_html__( 'Title', 'ingenious' ),
				"param_name"	=> "title",
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Currency', 'ingenious' ),
				"param_name"	=> "currency",
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Price', 'ingenious' ),
				"description"	=> esc_html__( 'Split integer and decimal part by dot symbol', 'ingenious' ),
				"param_name"	=> "price",
				"value"			=> "29.00",
				"save_always"	=> true
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Description', 'ingenious' ),
				"param_name"	=> "price_desc",
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "highlighted",
				"value"			=> array( esc_html__( 'Highlight this Cell', 'ingenious' ) => true )			
			),			
			array(
				"type"			=> "checkbox",
				"param_name"	=> "use_custom_color",
				"value"			=> array( esc_html__( 'Edit Color', 'ingenious' ) => true )			
			),
			array(
				"type"			=> "colorpicker",
				"param_name"	=> "custom_color",
				"dependency"	=> array(
					"element"	=> "use_custom_color",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR,
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "add_button",
				"value"			=> array( esc_html__( 'Add Button', 'ingenious' ) => true )
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"heading"		=> esc_html__( 'Title', 'ingenious' ),
				"param_name"	=> "button_text",
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
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
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Button Size', 'ingenious' ),
				"param_name"	=> "button_size",
				"dependency"	=> array(
					"element"	=> "add_button",
					"not_empty"	=> true
				),
				"value"			=> array(
					esc_html__( 'Regular', 'ingenious' )		=> 'regular',
					esc_html__( 'Mini', 'ingenious' )		=> 'mini',
					esc_html__( 'Small', 'ingenious' )		=> 'small',
					esc_html__( 'Large', 'ingenious' )		=> 'large'
				) 
			),
			array(
				"type"			=> "textarea_html",
				"heading"		=> esc_html__( 'Content', 'ingenious' ),
				"param_name"	=> "content",
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
	vc_map( array(
		"name"				=> esc_html__( 'CWS Pricing Plan', 'ingenious' ),
		"base"				=> "cws_sc_pricing_plan",
		'category'			=> "By CWS",
		"weight"			=> 80,
		"params"			=> $params
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_CWS_Sc_Pricing_Plan extends WPBakeryShortCode {
	    }
	}
?>