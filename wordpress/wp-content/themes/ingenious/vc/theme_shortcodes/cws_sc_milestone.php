<?php
	// Map Shortcode in Visual Composer

	$icon_params = ingenious_icon_vc_sc_config_params ();
	$params = ingenious_merge_arrs( array(
		$icon_params,
		array(
			array(
				"type"			=> "checkbox",
				"param_name"	=> "add_icon",
				"value"			=> array( esc_html__( 'Add Icon', 'ingenious' ) => true )
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "custom_icon_color",
				"dependency"	=> array(
					"element"	=> "add_icon",
					"not_empty"	=> true
				),
				"value"			=> array( esc_html__( 'Customize Icon Colors', 'ingenious' ) => true )
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Icon Color', 'ingenious' ),
				"param_name"	=> "icon_color",
				"dependency"	=> array(
					"element"	=> "custom_icon_color",
					"not_empty"	=> true
				),
				"value"			=> '#363636'
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Shape Type', 'ingenious' ),
				"param_name"	=> "shape",
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
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Number', 'ingenious' ),
				"param_name"	=> "number",
				"value"			=> "356",
				"save_always"	=> true
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "use_custom_number_color",
				"value"			=> array( esc_html__( 'Edit Number Color', 'ingenious' ) => true )
			),
			array(
				"type"			=> "colorpicker",
				"param_name"	=> "custom_number_color",
				"dependency"	=> array(
					"element"	=> "use_custom_number_color",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"heading"		=> esc_html__( 'Title', 'ingenious' ),
				"param_name"	=> "title",
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "use_custom_title",
				"value"			=> array( esc_html__( 'Edit Title Color', 'ingenious' ) => true )
			),
			array(
				"type"			=> "colorpicker",
				"param_name"	=> "custom_title_color",
				"dependency"	=> array(
					"element"	=> "use_custom_title",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Animation Speed', 'ingenious' ),
				"param_name"	=> "speed",
				"value"			=> "2000",
				"save_always"	=> true
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
		"name"				=> esc_html__( 'CWS Milestone', 'ingenious' ),
		"base"				=> "cws_sc_milestone",
		'category'			=> "By CWS",
		"weight"			=> 80,
		"params"			=> $params
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_CWS_Sc_Milestone extends WPBakeryShortCode {
	    }
	}
?>