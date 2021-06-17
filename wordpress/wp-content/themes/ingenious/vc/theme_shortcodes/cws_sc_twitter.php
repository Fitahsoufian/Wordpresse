<?php
	// Map Shortcode in Visual Composer
	$font_options = ingenious_get_option( 'body_font' );
	$font_color = $font_options['color'];
	vc_map( array(
		"name"				=> esc_html__( 'CWS Twitter', 'ingenious' ),
		"base"				=> "cws_sc_twitter",
		'category'			=> "By CWS",
		"weight"			=> 80,
		"params"			=> array(
			array(
				"type"			=> "iconpicker",
				"heading"		=> esc_html__( 'Icon', 'ingenious' ),
				"param_name"	=> "icon",
				"value"			=> ""
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "customize_colors",
				"value"			=> array( esc_html__( 'Edit Color', 'ingenious' ) => true )
			),
			array(
				"type"			=> "colorpicker",
				"param_name"	=> "custom_font_color",
				"dependency"	=> array(
					"element"		=> "customize_colors",
					"not_empty"		=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Tweets per Slide', 'ingenious' ),
				"param_name"	=> "visible_number",
				"value"			=> "2"
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Total Tweets', 'ingenious' ),
				"param_name"	=> "number",
				"value"			=> "4"
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
	    class WPBakeryShortCode_CWS_Sc_Twitter extends WPBakeryShortCode {
	    }
	}
?>