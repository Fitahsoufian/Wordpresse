<?php
	// Map Shortcode in Visual Composer

	$icon_params = ingenious_icon_vc_sc_config_params ();
	$params = ingenious_merge_arrs( array(
		$icon_params,
		array(
			array(
				"type"			=> "checkbox",
				"param_name"	=> "add_hover",
				"value"			=> array( esc_html__( 'Add Hover', 'ingenious' ) => true )				
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
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Title', 'ingenious' ),
				"param_name"	=> "title",
			),
			array(
				"type"			=> "dropdown",
				"group"			=> esc_html__( "Customize", "ingenious" ),
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
				"type"			=> "checkbox",
				"param_name"	=> "shape_shadow",
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"value"			=> array( esc_html__( 'Add Shadow', 'ingenious' ) => true ),
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "custom_shape_color",
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"value"			=> array( esc_html__( 'Customize Shape Colors', 'ingenious' ) => true )
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Fill Color', 'ingenious' ),
				"group"			=> esc_html__( "Customize", "ingenious" ),
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
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"param_name"	=> "stroke_color",
				"dependency"	=> array(
					"element"	=> "custom_shape_color",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Size', 'ingenious' ),
				"param_name"	=> "size",
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"value"			=> array(
					esc_html__( 'Mini', 'ingenious' )			=> 'mini',
					esc_html__( 'Small', 'ingenious' )			=> 'small',
					esc_html__( 'Medium', 'ingenious' )		=> 'medium',
					esc_html__( 'Large', 'ingenious' )			=> 'large',
					esc_html__( 'Extra Large', 'ingenious' )	=> 'extra_large',
				),
				"std"			=> 'medium'
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Title aligning', 'ingenious' ),
				"param_name"	=> "aligning",
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"value"			=> array(	
					esc_html__( 'None', 'ingenious' )			=> '',
					esc_html__( 'Left', 'ingenious' )			=> 'left',
					esc_html__( 'Right', 'ingenious' )			=> 'right',
					esc_html__( 'Center', 'ingenious' )		=> 'center'
				) 
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "row_icon",
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"value"			=> array( esc_html__( 'Row icon', 'ingenious' ) => true ),
			),			
			array(
				"type"			=> "checkbox",
				"param_name"	=> "custom_color",
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"value"			=> array( esc_html__( 'Icon Color', 'ingenious' ) => true )				
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Icon Color', 'ingenious' ),
				"param_name"	=> "font_color",
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"dependency"	=> array(
					"element"	=> "custom_color",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "custom_title_color",
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"value"			=> array( esc_html__( 'Title Color', 'ingenious' ) => true )				
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Title Color', 'ingenious' ),
				"param_name"	=> "title_color",
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"dependency"	=> array(
					"element"	=> "custom_title_color",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "custom_hover_color",
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"value"			=> array( esc_html__( 'Customize Hover Colors', 'ingenious' ) => true ),
				"dependency"	=> array(
					"element"	=> "add_hover",
					"not_empty"	=> true
				),
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Icon Hover Color', 'ingenious' ),
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"param_name"	=> "hover_font_color",
				"dependency"	=> array(
					"element"	=> "custom_hover_color",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Fill Hover Color', 'ingenious' ),
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"param_name"	=> "hover_fill_color",
				"dependency"	=> array(
					"element"	=> "custom_hover_color",
					"not_empty"	=> true
				),
				"value"			=> '#ffffff'
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Stroke Hover Color', 'ingenious' ),
				"group"			=> esc_html__( "Customize", "ingenious" ),
				"param_name"	=> "hover_stroke_color",
				"dependency"	=> array(
					"element"	=> "custom_hover_color",
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
			)
		)
	));
	vc_map( array(
		"name"				=> esc_html__( 'CWS Icon', 'ingenious' ),
		"base"				=> "cws_sc_icon",
		'category'			=> "By CWS",
		"weight"			=> 80,
		"params"			=> $params
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_CWS_Sc_Icon extends WPBakeryShortCode {
	    }
	}
?>