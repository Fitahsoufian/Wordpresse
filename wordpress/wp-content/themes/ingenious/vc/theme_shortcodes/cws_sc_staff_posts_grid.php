<?php
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
			"heading"		=> esc_html__( 'Layout', 'ingenious' ),
			"param_name"	=> 'display_style',
			"value"			=> array(
								esc_html__( 'Grid', 'ingenious' ) => 'grid',
								esc_html__( 'Grid with Filter', 'ingenious' ) => 'filter',
								esc_html__( 'Carousel', 'ingenious' ) => 'carousel'
							),
		),
		array(
			"type"			=> "checkbox",
			"param_name"	=> "select_filter",
			"dependency" 	=> array(
								"element"	=> 'display_style',
								"value"		=> array( "filter" )
							),
			'value'			=> array(
				esc_html__( 'Display Drop-Down Filter', 'ingenious' ) => true
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
				esc_html__( 'Add Navigation Bullets', 'ingenious' ) => true
			)
		),
		array(
			"type"			=> "textfield",
			"heading"		=> esc_html__( 'Items to display', 'ingenious' ),
			"param_name"	=> "total_items_count",
		),
		array(
			'type'			=> 'dropdown',
			'heading'		=> esc_html__( 'Grid Layout', 'ingenious' ),
			'param_name'	=> 'layout',
			'group'			=> esc_html__( "Customize", 'ingenious' ),
			'save_always'	=> true,
			'value'			=> array(
					esc_html__( 'Default', 'ingenious' ) => 'def',
					esc_html__( 'One Column', 'ingenious' ) => '1',
					esc_html__( 'Two Columns', 'ingenious' ) => '2',
					esc_html__( 'Three Columns', 'ingenious' ) => '3',
					esc_html__( 'Four Columns', 'ingenious' ) => '4'
				),
		),
		array(
			'type'			=> 'checkbox',
			'param_name'	=> 'staff_hide_meta_override',
			'group'			=> esc_html__( "Customize", 'ingenious' ),
			'value'			=> array(
				esc_html__( 'Hide Meta Data', 'ingenious' ) => true
			)
		),
		array(
			'type'				=> 'cws_dropdown',
			'multiple'			=> "true",
			'param_name'		=> 'staff_data_to_hide',
			'group'				=> esc_html__( "Customize", 'ingenious' ),
			'dependency'		=> array(
				'element'			=> 'staff_hide_meta_override',
				'not_empty'			=> true
			),
			'value'				=> array(
				esc_html__( 'None', 'ingenious' )			=> '',
				esc_html__( 'Departments', 'ingenious' )	=> 'department',
				esc_html__( 'Positions', 'ingenious' )		=> 'position',
				esc_html__( 'Content', 'ingenious' )		=> 'content',
				esc_html__( 'Social Icons', 'ingenious' )	=> 'soc_icons',
			)
		),
		array(
			"type"			=> "textfield",
			'group'			=> esc_html__( "Customize", 'ingenious' ),
			"heading"		=> esc_html__( 'Chars Count', 'ingenious' ),
			"param_name"	=> "chars_count",
			"value"			=> ""
		),
	);	
	$taxes = get_object_taxonomies ( 'cwsstaff', 'object' );
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
		"param_name"		=> "tax",
		"group"				=> esc_html__( "Customize", 'ingenious' ),
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
			"param_name"	=> "{$tax}_terms",
			"group"				=> esc_html__( "Customize", 'ingenious' ),
			"dependency"	=> array(
								"element"	=> "tax",
								"value"		=> $tax
							),
			"value"			=> $avail_terms
		));				
	}
	array_push( $params, array(
		"type"				=> "textfield",
		"heading"			=> esc_html__( 'Extra class name', 'ingenious' ),
		"description"		=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'ingenious' ),
		"param_name"		=> "el_class",
		"value"				=> ""
	));
	vc_map( array(
		"name"				=> esc_html__( 'CWS Staff', 'ingenious' ),
		"base"				=> "cws_sc_staff_posts_grid",
		'category'			=> "By CWS",
		"weight"			=> 80,
		"params"			=> $params
	));

if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_CWS_Sc_Staff_Posts_Grid extends WPBakeryShortCode {
    }
}
?>