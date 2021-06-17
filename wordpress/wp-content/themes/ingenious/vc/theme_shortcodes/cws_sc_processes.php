<?php 

// Map Shortcode in Visual Composer
	vc_map( array(
		"name"				=> esc_html__( 'CWS Processes', 'ingenious' ),
		"base"				=> "cws_sc_processes",
		'content_element' 	=> true,
		'as_parent'			=> array('only' => 'cws_sc_process'),
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
				"heading"		=> esc_html__( 'Processes Type', 'ingenious' ),
				"param_name"	=> "processes_type",
				"value"			=> array(
					esc_html__( 'Horizontal', 'ingenious' )			=> 'horizontal',
					esc_html__( 'Vertical', 'ingenious' )				=> 'vertical',
				) 
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html__( 'Columns', 'ingenious' ),
				"param_name"	=> "columns",
				"value"			=> array(
					esc_html__( 'One Column', 'ingenious' )			=> 'col_1',
					esc_html__( 'Two Columns', 'ingenious' )			=> 'col_2',
					esc_html__( 'Three Columns', 'ingenious' )			=> 'col_3',
					esc_html__( 'Four Columns', 'ingenious' )			=> 'col_4',
				),
				'std'        	 => 'col_3', 
				"dependency"	=> array(
					"element"	=> "processes_type",
					"value"	=> 'horizontal'
				),
			),
		)
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_CWS_Sc_Processes extends WPBakeryShortCodesContainer {
	    }
	}
?>