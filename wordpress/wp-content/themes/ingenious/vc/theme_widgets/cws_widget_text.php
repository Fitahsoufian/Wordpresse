<?php
	// Map Shortcode in Visual Composer
	vc_map( array(
		"name"				=> esc_html__( 'CWS Widget Text', 'ingenious' ),
		"base"				=> "cws_sc_widget_text",
		'category'			=> "CWS Widgets",
		"weight"			=> 80,
		"params"			=> array(
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"heading"		=> esc_html__( 'Title', 'ingenious' ),
				"param_name"	=> "title",
			),
			array(
				"type"			=> "textarea",
				"heading"		=> esc_html__( 'Widget Content', 'ingenious' ),
				"param_name"	=> "text"
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Text Align', 'ingenious' ),
				"param_name"	=> "text_align",
				"value"			=> array(
					esc_html__( 'Left', 'ingenious' )			=> 'left',
					esc_html__( 'Right', 'ingenious' )			=> 'right',
					esc_html__( 'Center', 'ingenious' )			=> 'center',
				) 
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "add_button",
				"value"			=> array( esc_html__( 'Add Button', 'ingenious' ) => true )
			),
			array(
				"type"			=> "colorpicker",
				"heading"		=> esc_html__( 'Custom Color', 'ingenious' ),
				"param_name"	=> "color",
				"dependency"	=> array(
					"element"		=> "add_button",
					"not_empty"		=> true
				)
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Url', 'ingenious' ),
				"param_name"	=> "button_url",
				"dependency"	=> array(
					"element"		=> "add_button",
					"not_empty"		=> true
				)
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Title', 'ingenious' ),
				"param_name"	=> "button_text",
				"dependency"	=> array(
					"element"		=> "add_button",
					"not_empty"		=> true
				)
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
	    class WPBakeryShortCode_CWS_Sc_Widget_Text extends WPBakeryShortCode {
	    }
	}
?>