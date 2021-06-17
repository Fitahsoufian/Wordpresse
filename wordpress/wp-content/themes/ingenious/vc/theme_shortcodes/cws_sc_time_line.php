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
			"type"			=> "dropdown",
			"heading"		=> esc_html__( 'Filter By', 'ingenious' ),
			"param_name"	=> "filter_by",
			"value"			=> array(
				esc_html__( 'None', 'ingenious' )				=> 'none',
				esc_html__( 'Categories', 'ingenious' )			=> 'cat',
				esc_html__( 'Tags', 'ingenious' )				=> 'tag',
				esc_html__( 'Categories and Tags', 'ingenious' )	=> 'cat_tag'
			)
		)
	);
	$cat_terms = get_terms( "category" );
	$cats = array();
	foreach ( $cat_terms as $cat_term ){
		$cats[$cat_term->name] = $cat_term->slug;
	}
	if ( !empty( $cats ) ){
		array_push( $params, array(
			'type'			=> 'cws_dropdown',
			'multiple'		=> "true",
			"param_name"	=> "cats",
			"dependency"	=> array(
				"element"		=> "filter_by",
				"value"			=> array( "cat", "cat_tag" )
			),
			"value"			=> $cats
		));
	}
	$tag_terms = get_terms( "post_tag" );
	$tags = array();
	foreach ( $tag_terms as $tag_term ){
		$tags[$tag_term->name] = $tag_term->slug;
	}
	if ( !empty( $tags ) ){
		array_push( $params, array(
			'type'			=> 'cws_dropdown',
			'multiple'		=> "true",
			"heading"		=> esc_html__( "Tags", "ingenious" ),
			"param_name"	=> "tags",
			"dependency"	=> array(
				"element"		=> "filter_by",
				"value"			=> array( "tag", "cat_tag" )
			),
			"value"			=> $tags
		));
	}
	$params = array_merge( $params, array(
		array(
			"type"			=> "checkbox",
			"param_name"	=> "hide_cat",
			"value"			=> array( esc_html__( 'Hide Categories', 'ingenious' ) => true )
		),
		array(
			"type"			=> "dropdown",
			"heading"		=> esc_html__( 'Layout', 'ingenious' ),
			"param_name"	=> "type",
			"value"			=> array(
				esc_html__( 'Large Hexagons with Thumbnails', 'ingenious' )				=> 'large_type',
				esc_html__( 'Small Hexagons without Thumbnails', 'ingenious' )				=> 'small_type',
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
			"type"			=> "textfield",
			"heading"		=> esc_html__( 'Items per Page', 'ingenious' ),
			"param_name"	=> "post_pp",
			"value"			=> "4"
		),
		array(
			"type"			=> "textfield",
			"heading"		=> esc_html__( 'Items to display', 'ingenious' ),
			"param_name"	=> "count",
			"value"			=> "15"
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
		"name"				=> esc_html__( 'CWS Time Line', 'ingenious' ),
		"base"				=> "cws_sc_time_line",
		'category'			=> "By CWS",
		"weight"			=> 80,
		"params"			=> $params
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_CWS_Sc_Time_Line extends WPBakeryShortCode {
	    }
	}
?>