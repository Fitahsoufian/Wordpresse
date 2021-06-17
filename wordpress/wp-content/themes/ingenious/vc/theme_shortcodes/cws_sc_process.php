<?php 

	// Map Shortcode in Visual Composer
	$icon_params = ingenious_icon_vc_sc_config_params ();
	$params = ingenious_merge_arrs( array(
		$icon_params,
		array(
			array(
				"type"			=> "checkbox",
				"param_name"	=> "use_custom_color",
				"value"			=> array( esc_html__( 'Edit Main Color', 'ingenious' ) => true ),
			),
			array(
				"type"			=> "colorpicker",
				"param_name"	=> "custom_color",
				"dependency"	=> array(
					"element"	=> "use_custom_color",
					"not_empty"	=> true
				),
				"value"			=> '#363636'
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "active",
				"value"			=> array( esc_html__( 'Active Process', 'ingenious' ) => true ),
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "use_custom_active_color",
				"value"			=> array( esc_html__( 'Edit Active Color', 'ingenious' ) => true ),
				"dependency"	=> array(
					"element"	=> "active",
					"not_empty"	=> true
				),
			),
			array(
				"type"			=> "colorpicker",
				"param_name"	=> "custom_active_color",
				"dependency"	=> array(
					"element"	=> "use_custom_active_color",
					"not_empty"	=> true
				),
				"value"			=> INGENIOUS_THEME_COLOR
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html__( 'Title', 'ingenious' ),
				"param_name"	=> "title",
				"save_always"	=> true
			),
			array(
				"type"			=> "textarea",
				"heading"		=> esc_html__( 'Description', 'ingenious' ),
				"param_name"	=> "descr",
				"save_always"	=> true
			)
		)
	));
	vc_map( array(
		"name"				=> esc_html__( 'CWS Process', 'ingenious' ),
		"base"				=> "cws_sc_process",
		'as_child'			=> array('only' => 'cws_sc_processes'),
		'category'			=> "By CWS",
		"weight"			=> 80,
		"params"			=> $params
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_CWS_Sc_Process extends WPBakeryShortCode {
	    }
	}
?>