<?php
	// Map Shortcode in Visual Composer
	vc_map( array(
		"name"				=> esc_html__( 'CWS Carousel', 'ingenious' ),
		"base"				=> "cws_sc_carousel",
		'content_element' 	=> true,
		'as_parent'			=> array('only' => 'cws_sc_milestone, vc_column_text, cws_sc_vc_testimonial, cws_sc_button, cws_sc_msg_box, cws_sc_progress_bar, cws_sc_services, cws_sc_widget_text'),
		'category'			=> "By CWS",
		"weight"			=> 80,
		'js_view' 			=> 'VcColumnView',
		"params"			=> array(
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"heading"		=> esc_html__( 'Title', 'ingenious' ),
				"param_name"	=> "title",
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Columns', 'ingenious' ),
				"param_name"	=> "columns",
				"value"			=> array(
					esc_html__( "One", 'ingenious' ) 	=> '1',
					esc_html__( "Two", 'ingenious' )		=> '2',
					esc_html__( "Three", 'ingenious' )	=> '3',
					esc_html__( "Four", 'ingenious' )	=> '4'
				)		
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "bullets_nav",
				"value"			=> array( esc_html__( 'Add Navigation Bullets', 'ingenious' ) => true )
			)
		)
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_CWS_Sc_Carousel extends WPBakeryShortCodesContainer {
	    }
	}
?>