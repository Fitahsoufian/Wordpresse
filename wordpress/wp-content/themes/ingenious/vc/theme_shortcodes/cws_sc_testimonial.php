<?php
	// Map Shortcode in Visual Composer
	vc_map( array(
		"name"				=> esc_html__( 'CWS Testimonial', 'ingenious' ),
		"base"				=> "cws_sc_vc_testimonial",
		'category'			=> "By CWS",
		"weight"			=> 80,
		"params"			=> array(
			array(
				"type"			=> "attach_image",
				"heading"		=> esc_html__( 'Thumbnail', 'ingenious' ),
				"param_name"	=> "thumbnail",
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Shape Type', 'ingenious' ),
				"param_name"	=> "shape",
				"value"			=> array(
					esc_html__( 'Circle', 'ingenious' )			=> 'circle',
					esc_html__( 'Rhomb', 'ingenious' )				=> 'rhomb',
				) 
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Author', 'ingenious' ),
				"param_name"	=> "author_name",
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Author Status', 'ingenious' ),
				"param_name"	=> "author_status",
			),
			array(
				"type"			=> "textarea_html",
				"heading"		=> esc_html__( 'Quote', 'ingenious' ),
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

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_CWS_Sc_Testimonial extends WPBakeryShortCode {
	    }
	}
?>