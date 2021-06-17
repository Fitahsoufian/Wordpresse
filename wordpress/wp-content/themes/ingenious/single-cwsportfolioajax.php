<?php
	
	$sb = ingenious_get_sidebars();
	extract( $sb );
	$page_classes = "";
	$page_classes .= !empty( $sb_layout_class ) ? " {$sb_layout_class}_sidebar" : "";
	$page_classes = trim( $page_classes );
	$p_id = get_queried_object_id ();
	$post_meta = get_post_meta( get_the_ID(), 'cws_mb_post' );
	$post_meta = isset( $post_meta[0] ) ? $post_meta[0] : array();
	$def_row_fw_atts = array(
					'full_width'				=> false,
				);
	$shot = isset( $GLOBALS['ingenious_row_fw_atts'] ) ? $GLOBALS['ingenious_row_fw_atts'] : $def_row_fw_atts;
	extract($shot);
	extract( wp_parse_args( $post_meta, array(
		'show_related' 		=> false,
		'rpo_title'			=> '',
		'rpo_cols'			=> '4',
		'carousel'			=> false,
		'img_size'			=> '1',
		'rpo_items_count'	=> get_option( 'posts_per_page' ),
	)));
	if ($full_width == 'stretch_row_content' || $full_width == 'stretch_row_content_no_spaces') {
		$full_width = true;
	} 
	$ajax_width = 1920;
	$show_related = isset( $post_meta['show_related'] ) ? $post_meta['show_related'] : false;
	$rpo_title = isset( $post_meta['rpo_title'] ) ? esc_html( $post_meta['rpo_title'] ) : "";
	$rpo_items_count = isset( $post_meta['rpo_items_count'] ) ? esc_textarea( $post_meta['rpo_items_count'] ) : esc_textarea( get_option( "posts_per_page" ) );
	$rpo_cols = isset( $post_meta['rpo_cols'] ) ? esc_textarea( $post_meta['rpo_cols'] ) : 4;
	$title = get_the_title();
	ob_start();
	ingenious_portfolio_single_post_post_media ();
	$media = ob_get_clean();
	$floated_media = isset( $GLOBALS['ingenious_portfolio_single_post_floated_media'] ) ? $GLOBALS['ingenious_portfolio_single_post_floated_media'] : false;
	unset( $GLOBALS['ingenious_portfolio_single_post_floated_media'] );
	if ( $img_size == 2 ) {
		echo sprintf("%s", $media);
	}
	if ( in_array( $sb_layout, array( "left", "both" ) ) ){
		echo "<ul id='left_sidebar' class='sidebar'>";
			dynamic_sidebar( $sidebar1 );
		echo "</ul>";
	}
	if ( $sb_layout === "right" ){
		echo "<ul id='right_sidebar' class='sidebar'>";
			dynamic_sidebar( $sidebar1 );
		echo "</ul>";
	}
	else if ( $sb_layout === "both" ){
		echo "<ul id='right_sidebar' class='sidebar'>";
			dynamic_sidebar( $sidebar2 );
		echo "</ul>";	
	}
	$GLOBALS['ingenious_single_ajax_atts'] = array(
		'sb_layout'						=> $sb_layout_class,
		'display_style'					=> 'showcase',
	);
	$pid = get_the_id();
	echo "<div id='portfolio_post_{$pid}' class='portfolio_post post_single clearfix'>";
		ob_start();
		ingenious_portfolio_single_post_post_media (false,$ajax_width);
		$media = ob_get_clean();
		$floated_media = isset( $GLOBALS['ingenious_portfolio_single_post_floated_media'] ) ? $GLOBALS['ingenious_portfolio_single_post_floated_media'] : false;
		unset( $GLOBALS['ingenious_portfolio_single_post_floated_media'] );
		if ( $img_size == 1 ) {
			if ( $floated_media ){
				echo "<div class='floated_media portfolio_floated_media single_post_floated_media'>";
					echo "<div class='floated_media_wrapper portfolio_floated_media_wrapper single_post_floated_media_wrapper'>";
						echo sprintf("%s", $media);
					echo "</div>";
				echo "</div>";						
			}
			else{
				echo sprintf("%s", $media);
			}
		}
		ob_start();
		ingenious_portfolio_single_post_terms ();
		ingenious_portfolio_single_post_content ();
		$content_terms = ob_get_clean();
		echo "<div class='ingenious_layout_container'>";
			if ( !empty( $content_terms ) ){
				if ( $floated_media && $img_size == 1 ){
					echo "<div class='clearfix floated_media_content portfolio_single_content'>";
						echo sprintf("%s", $content_terms);
					echo "</div>";
				}
				else{
					echo "<div class='portfolio_single_content'>";
						echo sprintf("%s", $content_terms);
					echo "</div>";
				}
			}
			echo "<div class='back_link_case'><a href='javascript:history.go(-1)'><i class='fas fa-long-arrow-alt-right'></i>" . esc_html__('Back to selected work' , 'ingenious') . "</a></div>";
		echo "</div>";
		ingenious_page_links ();
	echo "</div>";
	wp_reset_postdata();
	unset( $GLOBALS['ingenious_single_post_atts'] );

	if ( $show_related ){
		$terms = wp_get_post_terms( $p_id, 'cwsportfolio-cat' );
		$term_slugs = array();
		for ( $i=0; $i < count( $terms ); $i++ ){
			$term = $terms[$i];
			$term_slug = $term->slug;
			array_push( $term_slugs, $term_slug );
		}
		$term_slugs = implode( ",", $term_slugs );
		if ( !empty( $term_slugs ) ){
			$rp_args = array(
				'title'							=> $rpo_title,
				'post_type'						=> 'cwsportfolio',
				'total_items_count'				=> $rpo_items_count,
				'display_style'					=> 'carousel',
				'portfolio_layout_override'		=> true,
				'portfolio_layout'				=> $rpo_cols,
				'tax'							=> 'cwsportfolio-cat',
				'terms'							=> $term_slugs,
				'addl_query_args'				=> array(
				'post__not_in'					=> array( $p_id ),
				),
			);
			$related_projects = ingenious_posts_grid( $rp_args );
			if ( !empty( $related_projects ) ){
				echo "<hr />";
				echo sprintf("%s", $related_projects);
			}
		}
	}
?>