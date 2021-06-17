<?php
	$post_type = "post";
	$post_type_obj = get_post_type_object( $post_type );
	$post_type_name = isset( $post_type_obj->labels->name ) && !empty( $post_type_obj->labels->name ) ? $post_type_obj->labels->name : $post_type;
	$params = array(
		array(
			"type"			=> "textfield",
			"admin_label"	=> true,
			"heading"		=> esc_html__( 'Title', 'ingenious' ),
			"param_name"	=> "title",
			"value"			=> ""
		),
		array(
			"type"			=> "dropdown",
			"heading"		=> esc_html__( 'Title Alignment', 'ingenious' ),
			"param_name"	=> "title_align",
			"value"			=> array(
				esc_html__( "Left", 'ingenious' ) 	=> 'left',
				esc_html__( "Right", 'ingenious' )	=> 'right',
				esc_html__( "Center", 'ingenious' )	=> 'center'
			)		
		),
		array(
			"type"			=> "dropdown",
			"heading"		=> esc_html__( 'Blog View', 'ingenious' ),
			"param_name"	=> "display_style",
			"value"			=> array(
				esc_html__( 'Grid', 'ingenious' ) => 'grid',
				esc_html__( 'Carousel', 'ingenious' ) => 'carousel'
			)
		),
	);

	$taxes = get_object_taxonomies ( $post_type, 'object' );
	$avail_taxes = array(
		esc_html__( 'None', 'ingenious' )	=> ''
	);
	foreach ( $taxes as $tax => $tax_obj ){
		$tax_name = isset( $tax_obj->labels->name ) && !empty( $tax_obj->labels->name ) ? $tax_obj->labels->name : $tax;
		$avail_taxes[$tax_name] = $tax;
	}
	array_push( $params, array(
		"type"				=> "dropdown",
		"heading"			=> esc_html__( 'Filter by', 'ingenious' ),
		"param_name"		=> $post_type . "_tax",
		"value"				=> $avail_taxes
	));
	foreach ( $avail_taxes as $tax_name => $tax ) {
		$terms = get_terms( $tax );
		$avail_terms = array(
			''				=> ''
		);
		if ( !is_a( $terms, 'WP_Error' ) ){
			foreach ( $terms as $term ) {
				$avail_terms[$term->name] = $term->slug;
			}
		}
		array_push( $params, array(
			"type"			=> "cws_dropdown",
			"multiple"		=> "true",
			"param_name"	=> "{$post_type}_{$tax}_terms",
			"dependency"	=> array(
								"element"	=> $post_type . "_tax",
								"value"		=> $tax
							),
			"value"			=> $avail_terms
		));				
	}
	$params2 = array(
		array(
			'type'			=> 'dropdown',
			'heading'		=> esc_html__( 'Layout', 'ingenious' ),
			'param_name'	=> 'layout',
			'save_always'	=> true,
			'value'			=> array(
				esc_html__( 'Large Image List', 'ingenious' ) => '1',
				esc_html__( 'Medium Image List', 'ingenious' ) => 'medium',
				esc_html__( 'Small Image List', 'ingenious' ) => 'small',
				esc_html__( 'Two Columns', 'ingenious' ) => '2',
				esc_html__( 'Three Columns', 'ingenious' ) => '3',
				esc_html__( 'Four Columns', 'ingenious' ) => '4',
				esc_html__( 'Checkerboard', 'ingenious' ) => 'checkerboard',
				esc_html__( 'Full Width Background', 'ingenious' ) => 'fw_img',
							)
		),
		array(
			'type'			=> 'dropdown',
			'heading'		=> esc_html__( 'Image Alignment', 'ingenious' ),
			'param_name'	=> 'image_align',
			'save_always'	=> true,
			'value'			=> array(
				esc_html__( 'Left', 'ingenious' ) => 'img_left',
				esc_html__( 'Right', 'ingenious' ) => 'img_right',
				esc_html__( 'Checkerboard', 'ingenious' ) => 'img_check',
							),
			"dependency" 	=> array(
					"element"	=> 'layout',
					"value"		=> 'fw_img'
				),
		),
		array(
			'type'			=> 'checkbox',
			'param_name'	=> 'links_enable',
			'value'			=> array(
					esc_html__( 'Add Image Hover', 'ingenious' ) => true
				),
			'std' => 'true'
		),
		array(
			"type"			=> "checkbox",
			"param_name"	=> "en_hover_color",
			'value'			=> array(
				esc_html__( 'Edit Hover Color', 'ingenious' ) => true
			),
			"dependency" 	=> array(
					"element"	=> 'links_enable',
					"not_empty"		=> true
				),
		),
		array(
			"type"			=> "colorpicker",
			"param_name"	=> "hover_color",
			"dependency"	=> array(
				"element"	=> "en_hover_color",
				"not_empty"	=> true
			),
			"value"			=> "rgba(0,0,0,0.7)"
		),
		array(
			'type'			=> 'checkbox',
			'param_name'	=> $post_type . '_hide_meta_override',
			'value'			=> array(
				esc_html__( 'Hide Meta Data', 'ingenious' ) => true
			)
		),
		array(
			'type'			=> 'cws_dropdown',
			'multiple'		=> "true",
			'param_name'	=> $post_type . '_hide_meta',
			'dependency'	=> array(
					'element'	=> $post_type . '_hide_meta_override',
					'not_empty'	=> true
			),
			'value'			=> array(
				esc_html__( 'None', 'ingenious' )			=> '',
				esc_html__( 'Date', 'ingenious' )			=> 'date',
				esc_html__( 'Post Info', 'ingenious' )		=> 'post_info',
				esc_html__( 'Comments', 'ingenious' )		=> 'comments',
				esc_html__( 'Read More', 'ingenious' )		=> 'read_more',
				esc_html__( 'Terms', 'ingenious' )			=> 'terms'						
			)
		),
		array(
			"type"			=> "textfield",
			"heading"		=> esc_html__( 'Items per Page', 'ingenious' ),
			"param_name"	=> "items_pp",
			"dependency" 	=> array(
								"element"	=> "display_style",
								"value"		=> array( "grid" )
							),
			"value"			=> esc_html( get_option( 'posts_per_page' ) )
		),
		array(
			"type"			=> "textfield",
			"heading"		=> esc_html__( 'Items to display', 'ingenious' ),
			"param_name"	=> "total_items_count",
		),
	);
	$params = array_merge($params, $params2);

	array_push( $params, array(
		'type'			=> 'textfield',
		'heading'		=> esc_html__( 'Chars Count', 'ingenious' ),
		'param_name'	=> 'chars_count',
		'value'			=> 	''	
	));

	array_push( $params, array(
		"type"				=> "textfield",
		"heading"			=> esc_html__( 'Extra class name', 'ingenious' ),
		"description"		=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'ingenious' ),
		"param_name"		=> "el_class",
		"value"				=> ""
	));

	vc_map( array(
		"name"				=> esc_html__( 'CWS Blog', 'ingenious' ),
		"base"				=> "cws_sc_vc_blog",
		'category'			=> "By CWS",
		"weight"			=> 80,
		"params"			=> $params
	));

if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_CWS_Sc_Vc_Blog extends WPBakeryShortCode {
    }
}

?>