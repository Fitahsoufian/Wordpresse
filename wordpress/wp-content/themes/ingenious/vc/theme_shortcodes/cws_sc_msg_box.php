<?php
	// Map Shortcode in Visual Composer
	vc_map( array(
		"name"				=> esc_html__( 'CWS Message Box', 'ingenious' ),
		"base"				=> "cws_sc_msg_box",
		'category'			=> "By CWS",
		"weight"			=> 80,
		"params"			=> array(
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Type', 'ingenious' ),
				"param_name"	=> "type",
				"value"			=> array(
					esc_html__( 'Success', 'ingenious' )				=> 'success',
					esc_html__( 'Warning', 'ingenious' )				=> 'warn',
					esc_html__( 'Error', 'ingenious' )					=> 'error',
					esc_html__( 'Informational', 'ingenious' )			=> 'info',
				) 
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"heading"		=> esc_html__( 'Title', 'ingenious' ),
				"param_name"	=> "title",
			),
			array(
				"type"			=> "textarea",
				"admin_label"	=> true,
				"heading"		=> esc_html__( 'Text', 'ingenious' ),
				"param_name"	=> "text",
			),	
			array(
				"type"			=> "checkbox",
				"param_name"	=> "is_closable",
				"value"			=> array(
					esc_html__( 'Add Dismiss Option', 'ingenious' ) => true
				)
			),		
			array(
				"type"			=> "checkbox",
				"param_name"	=> "customize",
				"value"			=> array( esc_html__( 'Custom Background Color', 'ingenious' ) => true )
			),
			array(
				"type"			=> "colorpicker",
				"param_name"	=> "custom_fill_color",
				"dependency"	=> array(
					"element"	=> "customize",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "with_icon",
				"value"			=> array( esc_html__( 'Add Icon', 'ingenious' ) => true ),
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "with_custom_icon",
				"value"			=> array( esc_html__( 'Add Custom Icon', 'ingenious' ) => true ),
				"dependency"	=> array(
					"element"	=> "with_icon",
					"not_empty"	=> true
				),
			),
			array(
				"type"			=> "iconpicker",
				"param_name"	=> "custom_icon",
				"dependency"	=> array(
					"element"	=> "with_custom_icon",
					"not_empty"	=> true
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
	    class WPBakeryShortCode_CWS_Sc_Msg_Box extends WPBakeryShortCode {
	    }
	}
?>