<?php
	// Map Shortcode in Visual Composer
	$params = array(
		array(
			"type"			=> "textfield",
			"admin_label"	=> true,
			"heading"		=> esc_html__( 'Title', 'ingenious' ),
			"param_name"	=> "title",
		),
		array(
			"type"			=> "iconpicker",
			"heading"		=> esc_html__( 'Widget Icon', 'ingenious' ),
			"param_name"	=> "icon",
		),
		array(
			"type"			=> "dropdown",
			"heading"		=> esc_html__( 'Filter By', 'ingenious' ),
			"param_name"	=> "filter_by",
			"value"			=> array(
				esc_html__( 'None', 'ingenious' )						=> 'none',
				esc_html__( 'Departments', 'ingenious' )					=> 'department',
				esc_html__( 'Positions', 'ingenious' )					=> 'position',
				esc_html__( 'Departments and Positions', 'ingenious' )	=> 'department_position'
			)
		)
	);
	$dep_terms = get_terms( "cwsstaff_member_department" );
	$deps = array();
	if ( !is_a( $dep_terms, 'WP_Error' ) ){
		foreach ( $dep_terms as $dep_term ){
			$deps[$dep_term->name] = $dep_term->slug;
		}
	}
	if ( !empty( $deps ) ){
		array_push( $params, array(
			'type'				=> 'cws_dropdown',
			'multiple'			=> "true",
			"heading"			=> esc_html__( "Departments", "ingenious" ),
			"param_name"		=> "departments",
			"dependency"		=> array(
				"element"			=> "filter_by",
				"value"				=> array( "department", "department_position" )
			),
			"value"				=> $deps
		));
	}
	$pos_terms = get_terms( "cwsstaff_member_position" );
	$poss = array();
	if ( !is_a( $dep_terms, 'WP_Error' ) ){
		foreach ( $pos_terms as $pos_term ){
			$poss[$pos_term->name] = $pos_term->slug;
		}
	}
	if ( !empty( $poss ) ){
		array_push( $params, array(
			'type'				=> 'cws_dropdown',
			'multiple'			=> "true",
			"heading"			=> esc_html__( "Positions", "ingenious" ),
			"param_name"		=> "positions",
			"dependency"		=> array(
				"element"			=> "filter_by",
				"value"				=> array( "position", "department_position" )
			),
			"value"				=> $poss
		));
	}
	$params = array_merge( $params, array(
		array(
			"type"			=> "textfield",
			"heading"		=> esc_html__( 'Posts to Show', 'ingenious' ),
			"param_name"	=> "count",
			"value"			=> "4"
		),
		array(
			"type"			=> "textfield",
			"heading"		=> esc_html__( 'Posts per slide', 'ingenious' ),
			"param_name"	=> "visible_count",
			"value"			=> "2"
		),
		array(
			'type'				=> 'cws_dropdown',
			'multiple'			=> "true",
			'heading'			=> esc_html__( 'Hide', 'ingenious' ),
			'param_name'		=> 'hide',
			'value'				=> array(
				esc_html__( 'None', 'ingenious' )			=> '',
				esc_html__( 'Departments', 'ingenious' )		=> 'departments',
				esc_html__( 'Positions', 'ingenious' )		=> 'positions',
				esc_html__( 'Description', 'ingenious' )		=> 'desc'
			)
		),
		array(
			"type"			=> "textfield",
			"heading"		=> esc_html__( 'Chars Count', 'ingenious' ),
			"desc"			=> esc_html__( 'Count of chars from post content', 'ingenious' ),
			"param_name"	=> "chars_count",
			"value"			=> "70"
		),
		array(
			"type"			=> "checkbox",
			"param_name"	=> "add_custom_color",
			"value"			=> array( esc_html__( 'Add Custom Color', 'ingenious' ) => true )
		),
		array(
			"type"			=> "colorpicker",
			"heading"		=> esc_html__( 'Custom Color', 'ingenious' ),
			"param_name"	=> "color",
			"dependency"	=> array(
				"element"		=> "add_custom_color",
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
	));
	vc_map( array(
		"name"				=> esc_html__( 'CWS Widget Staff', 'ingenious' ),
		"base"				=> "cws_sc_widget_cwsstaff",
		'category'			=> "CWS Widgets",
		"weight"			=> 80,
		"params"			=> $params
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_CWS_Sc_Widget_CWSStaff extends WPBakeryShortCode {
	    }
	}
?>