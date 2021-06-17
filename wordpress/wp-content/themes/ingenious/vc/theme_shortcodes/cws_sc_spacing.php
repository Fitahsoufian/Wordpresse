<?php
	// Map Shortcode in Visual Composer
	vc_map( array(
		"name"				=> esc_html__( 'CWS Spacing', 'ingenious' ),
		"base"				=> "cws_sc_spacing",
		'category'			=> "By CWS",
		// "icon"				=> "boc_spacing",
		"weight"			=> 80,
		"params"			=> array(
			array(
				"type" => "textfield",
				"heading" => esc_html__('Height', 'ingenious'),
				"param_name" => "height",
				"description" => esc_html__('Enter empty space height', 'ingenious'),
				"value" => "32px",
				'save_always' => true,
				'admin_label' => true,
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Set Resonsive Empty Space Height', 'ingenious' ),
				'param_name' => 'responsive_es',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Height for small Desktops', 'ingenious'),
				'param_name' => 'height_size_sm_desctop',
				'description' => esc_html__( 'Enter height in pixels.', 'ingenious' ),
				'edit_field_class' => 'vc_col-sm-6',
				'dependency' => array(
					'element' => 'responsive_es',
					"value" => "true"
				),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Height for Tablets', 'ingenious'),
				'param_name' => 'height_tablet',
				'description' => esc_html__( 'Enter height in pixels.', 'ingenious' ),
				'edit_field_class' => 'vc_col-sm-6',
				'dependency' => array(
					'element' => 'responsive_es',
					"value" => "true"
				),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Height for Mobile', 'ingenious'),
				'param_name' => 'height_mobile',
				'description' => esc_html__( 'Enter height in pixels.', 'ingenious' ),
				'edit_field_class' => 'vc_col-sm-6',
				'dependency' => array(
					'element' => 'responsive_es',
					"value" => "true"
				),
			)
		)
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_CWS_Sc_Spacing extends WPBakeryShortCode {
	    }
	}
?>