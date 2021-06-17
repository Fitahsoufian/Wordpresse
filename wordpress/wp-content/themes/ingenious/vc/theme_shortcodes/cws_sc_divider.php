<?php
	// Map Shortcode in Visual Composer
	vc_map( array(
		"name"				=> esc_html__( 'CWS Divider', 'ingenious' ),
		"base"				=> "cws_sc_divider",
		'category'			=> "By CWS",
		"weight"			=> 80,
		"params"			=> array(
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Type', 'ingenious' ),
				"param_name"	=> "type",
				"value"			=> array(
					esc_html__( 'Thin', 'ingenious' )					=> 'thin',
					esc_html__( 'Thick', 'ingenious' )					=> 'thick',
					esc_html__( 'With Line on Center', 'ingenious' )	=> 'thin_center',
				) 
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Top Spacing', 'ingenious' ),
				"description"	=> esc_html__( 'in pixels', 'ingenious' ),
				"param_name"	=> "mtop",
				"value"			=> ""
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Bottom Spacing', 'ingenious' ),
				"description"	=> esc_html__( 'in pixels', 'ingenious' ),
				"param_name"	=> "mbottom",
				"value"			=> ""
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "customize_colors",
				"value"			=> array( esc_html__( 'Edit Color', 'ingenious' ) => true )
			),
			array(
				"type"			=> "colorpicker",
				"param_name"	=> "color",
				"dependency"	=> array(
					"element"		=> "customize_colors",
					"not_empty"		=> true
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

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_CWS_Sc_Divider extends WPBakeryShortCode {
	    }
	}
?>