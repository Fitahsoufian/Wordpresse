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
	);
	$taxes = get_object_taxonomies ( 'cwsportfolio', 'object' );
	$avail_taxes = array(
		esc_html__( 'None', 'ingenious' )	=> '',
		esc_html__( 'Titles', 'ingenious' )	=> 'title',
	);
	foreach ( $taxes as $tax => $tax_obj ){
		$tax_name = isset( $tax_obj->labels->name ) && !empty( $tax_obj->labels->name ) ? $tax_obj->labels->name : $tax;
		$avail_taxes[$tax_name] = $tax;
	}
	array_push( $params, array(
		"type"				=> "dropdown",
		"heading"			=> esc_html__( 'Filter by', 'ingenious' ),
		"param_name"		=> "tax",
		"value"				=> $avail_taxes
	));
	foreach ( $avail_taxes as $tax_name => $tax ) {
		if ($tax == 'title'){
			$custom_post_type = 'cwsportfolio';
			global $wpdb;
    		$results = $wpdb->get_results( $wpdb->prepare( "SELECT ID, post_title FROM {$wpdb->posts} WHERE post_type LIKE %s and post_status = 'publish'", $custom_post_type ) );
    		$titles_arr = array();
		    foreach( $results as $index => $post ) {
		    	$post_title = $post->post_title;
		        $titles_arr[$post_title] =  $post->ID;
		    }
			array_push( $params, array(
				"type"			=> "cws_dropdown",
				"multiple"		=> "true",
				"heading"		=> esc_html__( 'Titles', 'ingenious' ),
				"param_name"	=> "titles",
				'edit_field_class'			=> 'inside-box vc_col-xs-12',
				"dependency"	=> array(
									"element"	=> "tax",
									"value"		=> 'title'
								),
				"value"			=> $titles_arr
			));		
		} else {
			$terms = get_terms( $tax );
			$avail_terms =  array(
				''    => ''
				);
			$hierarchy = _get_term_hierarchy($tax);
			if ( !is_a( $terms, 'WP_Error' ) ){
				foreach($terms as $term) {
					if(isset($term)){
						if($term->parent) {
							continue;
						}    
						$avail_terms[] = $term->name;  
						if(isset($hierarchy[$term->term_id])) { 
							$children = _get_term_children($term->term_id, $terms, $tax);          
							foreach($children as $child) {
								$child = get_term($child, $tax);
								$ancestors = get_ancestors( $child->term_id, $child->taxonomy );
								$depth = $ancestors = count($ancestors);
								if($child->count > 0){
									if($depth <= $ancestors){       
										$avail_terms[] =  str_repeat("-", $depth) . ' ('.$term->name.') '.$child->slug;
									}
								}
							}
						}     
					}    
				}
			}
			array_push( $params, array(
				"type"			=> "cws_dropdown",
				"multiple"		=> "true",
				"heading"		=> $tax_name,
				"param_name"	=> "{$tax}_terms",
				'edit_field_class'			=> 'inside-box vc_col-xs-12',
				"dependency"	=> array(
									"element"	=> "tax",
									"value"		=> $tax
								),
				"value"			=> $avail_terms
			));	
		} 		
	}
	$params2 = array(
		array(
			'type'			=> 'checkbox',
			'param_name'	=> 'portfolio_show_data_override',
			'value'			=> array(
				esc_html__( 'Show Meta Data', 'ingenious' ) => true
			)
		),
		array(
			'type'				=> 'cws_dropdown',
			'multiple'			=> "true",
			'param_name'		=> 'portfolio_data_to_show',					
			'dependency'		=> array(
				'element'			=> 'portfolio_show_data_override',
				'not_empty'			=> true
			),
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			'value'				=> array(
				esc_html__( 'None', 'ingenious' )		=> '',
				esc_html__( 'Title', 'ingenious' )		=> 'title',
				esc_html__( 'Excerpt', 'ingenious' )		=> 'excerpt',
				esc_html__( 'Categories', 'ingenious' )	=> 'cats',
			)
		),
		array(
			'type'			=> 'textfield',
			'heading'		=> esc_html__( 'Chars Count', 'ingenious' ),
			'param_name'	=> 'chars_count',
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			'dependency'	=> array(
				'element'		=> 'portfolio_show_data_override',
				'not_empty'		=> true
			),
			'value'			=> 	''	
		),
		array(
			"type"			=> "dropdown",
			"heading"		=> esc_html__( 'Layout', 'ingenious' ),
			"param_name"	=> 'display_style',
			"value"			=> array(
								esc_html__( 'Grid', 'ingenious' ) => 'grid',
								esc_html__( 'Grid with Filter', 'ingenious' ) => 'filter',
								esc_html__( 'Carousel', 'ingenious' ) => 'carousel',
								esc_html__( 'Showcase', 'ingenious' ) => 'showcase',
								esc_html__( 'Hexagon Vertical', 'ingenious' ) => 'hex_style',
								esc_html__( 'Hexagon Horizontal', 'ingenious' ) => 'hex_style_2',
							),
		),
		array(
			"type"			=> "checkbox",
			"param_name"	=> "en_isotope",
			"dependency" 	=> array(
					"element"	=> 'display_style',
					"value"		=> 'grid'
				),
			'value'			=> array(
				esc_html__( 'Use Isotope', 'ingenious' ) => true
			),
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
		),
		array(
			"type"			=> "dropdown",
			"heading"		=> esc_html__( 'Hexagon layout', 'ingenious' ),
			"param_name"	=> 'hex_display_style',
			"value"			=> array(
								esc_html__( 'Grid', 'ingenious' ) => 'grid',
								esc_html__( 'Grid with Filter', 'ingenious' ) => 'filter',
								esc_html__( 'Carousel', 'ingenious' ) => 'carousel',
							),
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			"dependency" 	=> array(
					"element"	=> 'display_style',
					"value"		=> array( "hex_style", "hex_style_2" )
				),
		),
		array(
			"type"			=> "checkbox",
			"param_name"	=> "carousel_pagination_hex",
			"dependency" 	=> array(
								"element"	=> 'hex_display_style',
								"value"		=> array( "carousel" )
							),
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			'value'			=> array(
				esc_html__( 'Add Navigation Bullets', 'ingenious' ) => true
			)
		),
		array(
			'type'			=> 'dropdown',
			'heading'		=> esc_html__( 'Grid Layout', 'ingenious' ),
			'param_name'	=> 'hex_layout',
			'save_always'	=> true,
			'value'			=> array(
					esc_html__( 'Three Columns', 'ingenious' ) => '3',
					esc_html__( 'Four Columns', 'ingenious' ) => '4',
					esc_html__( 'Five Columns', 'ingenious' ) => '5',
				),
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			"dependency" 	=> array(
					"element"	=> 'display_style',
					"value"		=> array( "hex_style", "hex_style_2" )
				),
		),
		array(
			"type"			=> "dropdown",
			"heading"		=> esc_html__( 'Start with:', 'ingenious' ),
			"param_name"	=> 'start_style',
			"value"			=> array(
								esc_html__( 'Even', 'ingenious' ) => 'start_even',
								esc_html__( 'Odd', 'ingenious' ) => 'start_odd',
							),
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			"dependency" 	=> array(
					"element"	=> 'display_style',
					"value"		=> array( "hex_style", "hex_style_2" )
				),
		),
		array(
			"type"			=> "checkbox",
			"param_name"	=> "carousel_auto",
			"dependency" 	=> array(
								"element"	=> 'display_style',
								"value"		=> array( "carousel" )
							),
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			'value'			=> array(
				esc_html__( 'Carousel Autoplay Enable', 'ingenious' ) => true
			)
		),
		array(
			"type"			=> "checkbox",
			"param_name"	=> "carousel_pagination",
			"dependency" 	=> array(
								"element"	=> 'display_style',
								"value"		=> array( "carousel" )
							),
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			'value'			=> array(
				esc_html__( 'Add Navigation Bullets', 'ingenious' ) => true
			)
		),
		array(
			"type"			=> "dropdown",
			"heading"		=> esc_html__( 'Hover', 'ingenious' ),
			"param_name"	=> "anim_style",
			"value"			=> array(
								esc_html__( 'Solid Color', 'ingenious' ) => 'hoverdef',
								esc_html__( 'Solid Color with Border', 'ingenious' ) => 'hoverbi2',
								esc_html__( 'Solid Color with Zoomed Border', 'ingenious' ) => 'hoverbi',
								esc_html__( 'Mouse Follow', 'ingenious' ) => 'hoverdir',
								esc_html__( 'Zoom with Rotation', 'ingenious' ) => 'hoversr',
								esc_html__( 'Zoom with Blur', 'ingenious' ) => 'hoverzb',
								esc_html__( 'No Hover with Link', 'ingenious' ) => 'hover_none_link',
								esc_html__( 'No Hover', 'ingenious' ) => 'hover_none',
							),
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			"dependency" 	=> array(
					"element"	=> 'display_style',
					"value"		=> array( "carousel" ,"grid" , "filter" )
				),
		),
		array(
			'type'				=> 'dropdown',
			'heading'			=> esc_html__( 'Icon Hover', 'ingenious' ),
			'param_name'		=> 'link_show',					
			"dependency" 	=> array(
					"element"	=> 'anim_style',
					"value"		=> array( "hoverdef" ,"hoverdir" , "hoverbi", "hoverbi2", "hoversr", "hoverzb" )
				),
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			'value'				=> array(
				esc_html__( 'Show Image PopUp Icon', 'ingenious' )	=> 'popup_link',
				esc_html__( 'Show Go to Project Details Icon', 'ingenious' )	=> 'single_link',
				esc_html__( 'None', 'ingenious' )	=> 'none',
			)
		),
		array(
			"type"			=> "checkbox",
			"param_name"	=> "area_link",
			"std"			=> true,
			'value'			=> array(
				esc_html__( 'Make Image Clickable', 'ingenious' ) => true
			),
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			"dependency" 	=> array(
					"element"	=> 'anim_style',
					"value"		=> array( "hoverdef" ,"hoverdir" , "hoverbi", "hoverbi2", "hoversr", "hoverzb" )
				),
		),
		array(
			"type"			=> "checkbox",
			"param_name"	=> "en_hover_color",
			'value'			=> array(
				esc_html__( 'Edit Hover Color', 'ingenious' ) => true
			),
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			"dependency" 	=> array(
					"element"	=> 'anim_style',
					"value"		=> array( "hoverdef" ,"hoverdir" , "hoverbi", "hoverbi2", "hoversr", "hoverzb" )
				),
		),
		array(
			"type"			=> "colorpicker",
			"param_name"	=> "hover_color",
			"dependency"	=> array(
				"element"	=> "en_hover_color",
				"not_empty"	=> true
			),
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			"value"			=> "rgba(0,0,0,0.7)"
		),
		array(
			"type"			=> "checkbox",
			"param_name"	=> "en_title_color",
			'value'			=> array(
				esc_html__( 'Edit Title Color', 'ingenious' ) => true
			),
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			"dependency" 	=> array(
					"element"	=> 'anim_style',
					"value"		=> array( "hoverdef" ,"hoverdir" , "hoverbi", "hoverbi2", "hoversr", "hoverzb" )
				),
		),
		array(
			"type"			=> "colorpicker",
			"param_name"	=> "title_color",
			"dependency"	=> array(
				"element"	=> "en_title_color",
				"not_empty"	=> true
			),
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			"value"			=> "#ffffff"
		),
		array(
			"type"			=> "checkbox",
			"param_name"	=> "en_cat_color",
			'value'			=> array(
				esc_html__( 'Edit Category Color', 'ingenious' ) => true
			),
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			"dependency" 	=> array(
					"element"	=> 'anim_style',
					"value"		=> array( "hoverdef" ,"hoverdir" , "hoverbi", "hoverbi2", "hoversr", "hoverzb" )
				),
		),
		array(
			"type"			=> "colorpicker",
			"param_name"	=> "cat_color",
			"dependency"	=> array(
				"element"	=> "en_cat_color",
				"not_empty"	=> true
			),
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			"value"			=> '#ffffff'
		),
		array(
			"type"			=> "checkbox",
			"param_name"	=> "en_icon_color",
			'value'			=> array(
				esc_html__( 'Edit Icon Link Color', 'ingenious' ) => true
			),
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			"dependency" 	=> array(
					"element"	=> 'anim_style',
					"value"		=> array( "hoverdef" ,"hoverdir" , "hoverbi", "hoverbi2", "hoversr", "hoverzb" )
				),
		),
		array(
			"type"			=> "colorpicker",
			"param_name"	=> "icon_color",
			"dependency"	=> array(
				"element"	=> "en_icon_color",
				"not_empty"	=> true
			),
			"heading"		=> esc_html__( 'Icon Font Color', 'ingenious' ),
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			"value"			=> '#363636'
		),
		array(
			"type"			=> "colorpicker",
			"param_name"	=> "icon_bg_color",
			"dependency"	=> array(
				"element"	=> "en_icon_color",
				"not_empty"	=> true
			),
			"heading"		=> esc_html__( 'Icon Background Color', 'ingenious' ),
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			"value"			=> '#ffffff'
		),
		array(
			"type"			=> "dropdown",
			"heading"		=> esc_html__( 'Add Animation', 'ingenious' ),
			"param_name"	=> "appear_style",
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			"value"			=> array(
								esc_html__( 'None', 'ingenious' ) => 'none',
								esc_html__( 'Bounce', 'ingenious' ) => 'callout.bounce',
								esc_html__( 'Shake', 'ingenious' ) => 'callout.shake',
								esc_html__( 'Flash', 'ingenious' ) => 'callout.flash',
								esc_html__( 'Pulse', 'ingenious' ) => 'callout.pulse',
								esc_html__( 'Swing', 'ingenious' ) => 'callout.swing',
								esc_html__( 'Tada', 'ingenious' ) => 'callout.tada',
								esc_html__( 'Fade In', 'ingenious' ) => 'transition.fadeIn',
								esc_html__( 'Flip X In', 'ingenious' ) => 'transition.flipXIn',
								esc_html__( 'Flip Y In', 'ingenious' ) => 'transition.flipYIn',
								esc_html__( 'Shrink In', 'ingenious' ) => 'transition.shrinkIn',
								esc_html__( 'Expand In', 'ingenious' ) => 'transition.expandIn',
								esc_html__( 'Grow', 'ingenious' ) => 'transition.grow',
								esc_html__( 'Slide Up', 'ingenious' ) => 'transition.slideUpBigIn',
								esc_html__( 'Slide Down', 'ingenious' ) => 'transition.slideDownBigIn',
								esc_html__( 'Slide Left', 'ingenious' ) => 'transition.slideLeftBigIn',
								esc_html__( 'Slide Right', 'ingenious' ) => 'transition.slideRightBigIn',
								esc_html__( 'Perspective Up', 'ingenious' ) => 'transition.perspectiveUpIn',
								esc_html__( 'Perspective Down', 'ingenious' ) => 'transition.perspectiveDownIn',
								esc_html__( 'Perspective Left', 'ingenious' ) => 'transition.perspectiveLeftIn',
								esc_html__( 'Perspective Right', 'ingenious' ) => 'transition.perspectiveRightIn',
							),
			"dependency" 	=> array(
					"element"	=> 'display_style',
					"value"		=> array( "carousel" ,"grid" , "filter" )
				),
		),
		array(
			'type'			=> 'dropdown',
			'heading'		=> esc_html__( 'Grid Layout', 'ingenious' ),
			'param_name'	=> 'layout',
			'save_always'	=> true,
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			'value'			=> array(
					esc_html__( 'One Column', 'ingenious' ) => '1',
					esc_html__( 'Two Columns', 'ingenious' ) => '2',
					esc_html__( 'Three Columns', 'ingenious' ) => '3',
					esc_html__( 'Four Columns', 'ingenious' ) => '4',
				),
			"dependency" 	=> array(
					"element"	=> 'display_style',
					"value"		=> array( "carousel" ,"grid" , "filter" )
				),
		),
		array(
			"type"			=> "checkbox",
			"param_name"	=> "masonry",
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			"dependency" 	=> array(
				"element"	=> 'layout',
				"value"		=> array( "def","2","3","4" )
			),
			'value'			=> array(
				esc_html__( 'Masonry', 'ingenious' ) => true
			)
		),		
		array(
			"type"			=> "checkbox",
			"param_name"	=> "crop_img",
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			'value'			=> array(
				esc_html__( 'Crop images (Square)', 'ingenious' ) => true
			)
		),
		array(
			'type'			=> 'dropdown',
			'heading'		=> esc_html__( 'Show Title and Description', 'ingenious' ),
			'param_name'	=> 'info_pos',
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			'value'			=> array(
					esc_html__( 'On Image Hover', 'ingenious' ) => 'inside_img',
					esc_html__( 'Under Image', 'ingenious' ) => 'under_img',
				),
			"dependency" 	=> array(
								"element"	=> 'layout',
								"value"		=> array( "def","1","2","3","4" )
				),
		),
		array(
			"type"			=> "checkbox",
			"param_name"	=> "title_divider",
			'edit_field_class' => 'inside-box vc_col-xs-12',
			'value'			=> array(
				esc_html__( 'Divider under title', 'ingenious' ) => true
			)
		),		
		array(
			"type"			=> "dropdown",
			"heading"		=> esc_html__( 'Info Alignment', 'ingenious' ),
			"param_name"	=> "info_align",
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			"value"			=> array(
					esc_html__( 'Center', 'ingenious' ) 	=> 'center',
					esc_html__( 'Left', 'ingenious' )	=> 'left',
					esc_html__( 'Right', 'ingenious' ) 	=> 'right',
							),
			"dependency" 	=> array(
								"element"	=> 'info_pos',
								"value"		=> 'under_img'
				),
		),
		array(
			"type"			=> "dropdown",
			"heading"		=> esc_html__( 'Image Spacings', 'ingenious' ),
			"param_name"	=> "portfolio_style",
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			"value"			=> array(
					esc_html__( 'Add Spacings', 'ingenious' ) => 'def_style',
					esc_html__( 'No Spacings', 'ingenious' ) => 'wide_style',
							),
			"dependency" 	=> array(
								"element"	=> 'info_pos',
								"value"		=> 'inside_img'
				),
		),
		array(
			"type"			=> "checkbox",
			"param_name"	=> "item_shadow",
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			"dependency" 	=> array(
								"element"	=> 'portfolio_style',
								"value"		=> array( "def_style" )
							),
			'value'			=> array(
				esc_html__( 'Add Shadow on Hover', 'ingenious' ) => true
			)
		),
		array(
			"type"			=> "dropdown",
			"heading"		=> esc_html__( 'Pagination Type', 'ingenious' ),
			"param_name"	=> "pag_type",
			'edit_field_class'			=> 'inside-box vc_col-xs-12',
			"value"			=> array(
					esc_html__( 'Load More', 'ingenious' ) => 'load_pag',
					esc_html__( 'Page Numbers', 'ingenious' ) => 'num_pag',
							),
		),
	);		
	$params = array_merge($params, $params2);
	array_push( $params, array(
		"type"			=> "textfield",
		"heading"		=> esc_html__( 'Items per Page', 'ingenious' ),
		"param_name"	=> "items_pp",
		"dependency" 	=> array(
							"element"	=> 'display_style',
							"value"		=> array( "grid", "filter", "hex_style", "hex_style_2" )
						),
		"value"			=> esc_html( get_option( 'posts_per_page' ) )
	));
	array_push( $params, array(
		"type"			=> "textfield",
		"heading"		=> esc_html__( 'Items to display', 'ingenious' ),
		"param_name"	=> "total_items_count",
	));
	array_push( $params, array(
		"type"				=> "textfield",
		"heading"			=> esc_html__( 'Extra class name', 'ingenious' ),
		"description"		=> esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'ingenious' ),
		"param_name"		=> "el_class",
		"value"				=> ""
	));
	vc_map( array(
		"name"				=> esc_html__( 'CWS Portfolio', 'ingenious' ),
		"base"				=> "cws_sc_portfolio_posts_grid",
		'category'			=> "By CWS",
		"weight"			=> 80,
		"params"			=> $params
	));

if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_CWS_Sc_Portfolio_Posts_Grid extends WPBakeryShortCode {
    }
}
?>