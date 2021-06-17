<?php
	$post_types = array( 'cwsportfolio', 'cwsstaff' );
	$avail_post_types = array();
	foreach ( $post_types as $post_type ){
		if ( post_type_exists( $post_type ) ){
			$post_type_obj = get_post_type_object( $post_type );
			$post_type_name = isset( $post_type_obj->labels->name ) && !empty( $post_type_obj->labels->name ) ? $post_type_obj->labels->name : $post_type;
			$avail_post_types[$post_type_name] = $post_type;
		}
	}
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
			"heading"		=> esc_html__( 'Post Type', 'ingenious' ),
			"param_name"	=> "post_type",
			"save_always" 	=> true,
			"value"			=> $avail_post_types								
		),
		array(
			"type"			=> "dropdown",
			"heading"		=> esc_html__( 'Portfolio Style', 'ingenious' ),
			"param_name"	=> "portfolio_style",
			"value"			=> array(
								esc_html__( 'Default', 'ingenious' ) => 'def_style',
								esc_html__( 'Hexagon Style', 'ingenious' ) => 'hex_style',
							),
			"dependency" 	=> array(
								"element"	=> "post_type",
								"value"		=> "cwsportfolio"
							),
		),
		array(
			"type"			=> "dropdown",
			"heading"		=> esc_html__( 'Display Style', 'ingenious' ),
			"param_name"	=> 'display_style',
			"value"			=> array(
								esc_html__( 'Grid', 'ingenious' ) => 'grid',
								esc_html__( 'Grid with Filter', 'ingenious' ) => 'filter',
								esc_html__( 'Carousel', 'ingenious' ) => 'carousel'
							),
		)
	);
	$params = array_merge( $params, array(
		array(
			"type"			=> "checkbox",
			"param_name"	=> "select_filter",
			"dependency" 	=> array(
								"element"	=> 'display_style',
								"value"		=> array( "filter" )
							),
			'value'			=> array(
				esc_html__( 'Select filter', 'ingenious' ) => true
			)
		),
		array(
			"type"			=> "textfield",
			"heading"		=> esc_html__( 'Items per Page', 'ingenious' ),
			"param_name"	=> "items_pp",
			"dependency" 	=> array(
								"element"	=> 'display_style',
								"value"		=> array( "grid", "filter" )
							),
			"value"			=> esc_html( get_option( 'posts_per_page' ) )
		),
		array(
			"type"			=> "checkbox",
			"param_name"	=> "carousel_pagination",
			"dependency" 	=> array(
								"element"	=> 'display_style',
								"value"		=> array( "carousel" )
							),
			'value'			=> array(
				esc_html__( 'Pagination', 'ingenious' ) => true
			)
		),
		array(
			"type"			=> "textfield",
			"heading"		=> esc_html__( 'Items to display', 'ingenious' ),
			"param_name"	=> "total_items_count",
		),
	));
	foreach ( $avail_post_types as $post_type_name => $post_type ) {
		$layout_vals = array();
		switch ( $post_type ){
			case "cwsportfolio":
				$layout_vals = array(
					esc_html__( 'Default', 'ingenious' ) => 'def',
					esc_html__( 'One Column', 'ingenious' ) => '1',
					esc_html__( 'Two Columns', 'ingenious' ) => '2',
					esc_html__( 'Three Columns', 'ingenious' ) => '3',
					esc_html__( 'Four Columns', 'ingenious' ) => '4',
					esc_html__( 'Full Width', 'ingenious' ) => 'fw',
				);
				break;
			case "cwsstaff":
				$layout_vals = array(
					esc_html__( 'Default', 'ingenious' ) => 'def',
					esc_html__( 'One Column', 'ingenious' ) => '1',
					esc_html__( 'Two Columns', 'ingenious' ) => '2',
					esc_html__( 'Three Columns', 'ingenious' ) => '3',
					esc_html__( 'Four Columns', 'ingenious' ) => '4'
				);
				break;
		}		
		if ( !empty( $layout_vals ) ){
			array_push( $params, array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Layout', 'ingenious' ),
				'param_name'	=> $post_type . '_layout',
				'group'			=> $post_type_name . esc_html__( " Options", 'ingenious' ),
				'dependency'	=> array(
									'element'	=> 'post_type',
									'value'		=> $post_type
								),
				'save_always'	=> true,
				'value'			=> $layout_vals
			));
		}
		if ( $post_type == 'cwsportfolio' ){
			$params = array_merge( $params, array(
				array(
					'type'			=> 'checkbox',
					'param_name'	=> $post_type . '_show_data_override',
					'group'			=> $post_type_name . esc_html__( " Options", 'ingenious' ),
					'dependency'	=> array(
							'element'	=> 'post_type',
							'value'		=> $post_type
						),
					'value'			=> array(
						esc_html__( 'Customize Output', 'ingenious' ) => true
					)
				),
				array(
					'type'				=> 'cws_dropdown',
					'multiple'			=> "true",
					'heading'			=> esc_html__( 'Show', 'ingenious' ),
					'param_name'		=> $post_type . '_data_to_show',
					'group'				=> $post_type_name . esc_html__( " Options", 'ingenious' ),					
					'dependency'		=> array(
						'element'			=> $post_type . '_show_data_override',
						'not_empty'			=> true
					),
					'value'				=> array(
						esc_html__( 'None', 'ingenious' )		=> '',
						esc_html__( 'Title', 'ingenious' )		=> 'title',
						esc_html__( 'Excerpt', 'ingenious' )		=> 'excerpt',
						esc_html__( 'Categories', 'ingenious' )	=> 'cats'
					)
				)
			));
		}
		if ( $post_type == 'cwsstaff' ){
			$params = array_merge( $params, array(
				array(
					'type'			=> 'checkbox',
					'param_name'	=> $post_type . '_hide_meta_override',
					'group'			=> $post_type_name . esc_html__( " Options", 'ingenious' ),
					'dependency'	=> array(
							'element'	=> 'post_type',
							'value'		=> $post_type
						),
					'value'			=> array(
						esc_html__( 'Customize Output', 'ingenious' ) => true
					)
				),
				array(
					'type'				=> 'cws_dropdown',
					'multiple'			=> "true",
					'heading'			=> esc_html__( 'Hide', 'ingenious' ),
					'param_name'		=> $post_type . '_data_to_hide',
					'group'				=> $post_type_name . esc_html__( " Options", 'ingenious' ),
					'dependency'		=> array(
						'element'			=> $post_type . '_hide_meta_override',
						'not_empty'			=> true
					),
					'value'				=> array(
						esc_html__( 'None', 'ingenious' )			=> '',
						esc_html__( 'Departments', 'ingenious' )		=> 'department',
						esc_html__( 'Positions', 'ingenious' )		=> 'position',
						esc_html__( 'Content', 'ingenious' )			=> 'content',
					)
				),
				array(
					"type"			=> "textfield",
					'group'			=> $post_type_name . esc_html__( " Options", 'ingenious' ),
					'dependency'	=> array(
							'element'	=> 'post_type',
							'value'		=> $post_type
						),
					"heading"		=> esc_html__( 'Chars Count', 'ingenious' ),
					"param_name"	=> "chars_count",
				),
			));
		}		
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
			"group"				=> $post_type_name . esc_html__( " Options", 'ingenious' ),
			"dependency"		=> array(
					'element'	=> 'post_type',
					'value'		=> $post_type
				),
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
				"heading"		=> $tax_name,
				"param_name"	=> "{$post_type}_{$tax}_terms",
				"group"				=> $post_type_name . esc_html__( " Options", 'ingenious' ),
				"dependency"	=> array(
									"element"	=> $post_type . "_tax",
									"value"		=> $tax
								),
				"value"			=> $avail_terms
			));				
		}
	}
	array_push( $params, array(
		"type"				=> "textfield",
		"heading"			=> esc_html__( 'Extra class name', 'ingenious' ),
		"description"		=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'ingenious' ),
		"param_name"		=> "el_class",
		"value"				=> ""
	));
	vc_map( array(
		"name"				=> esc_html__( 'CWS Posts Grid', 'ingenious' ),
		"base"				=> "cws_sc_vc_posts_grid",
		'category'			=> "By CWS",
		"weight"			=> 80,
		"params"			=> $params
	));

if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_CWS_Sc_Vc_Posts_Grid extends WPBakeryShortCode {
    }
}
?>