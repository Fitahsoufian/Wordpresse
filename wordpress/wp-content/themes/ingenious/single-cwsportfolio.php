<?php

	get_header();
	$p_id = get_queried_object_id ();
	$post_meta = get_post_meta( get_the_ID(), 'cws_mb_post' );
	$post_meta = isset( $post_meta[0] ) ? $post_meta[0] : array();
	$sb = ingenious_get_sidebars();
	extract( $sb );
	$sb_layout = isset( $post_meta['sb_layout'] ) ? $post_meta['sb_layout'] : '';
	$sb_layout_class = in_array( $sb_layout, array( 'left', 'right' ) ) ? 'single' : ( ( $sb_layout === "both" ) ? 'double' : '' );
	$page_classes = "";
	$page_classes .= !empty( $sb_layout_class ) ? " {$sb_layout_class}_sidebar" : "";
	$page_classes = trim( $page_classes );
	extract( wp_parse_args( $post_meta, array(
		'show_related' 		=> false,
		'rpo_title'			=> '',
		'rpo_cols'			=> '4',
		'rpo_show'			=> 'on',
		'rpo_meta'			=> '',
		'carousel'			=> false,
		'full_width'		=> false,
		'rpo_items_count'	=> get_option( 'posts_per_page' ),
	)));
	$full_width = isset( $post_meta['full_width'] ) ? $post_meta['full_width'] : false;
	$full_width = (bool)$full_width;
	$show_related = isset( $post_meta['show_related'] ) ? $post_meta['show_related'] : false;
	$rpo_title = isset( $post_meta['rpo_title'] ) ? esc_html( $post_meta['rpo_title'] ) : "";
	$rpo_items_count = isset( $post_meta['rpo_items_count'] ) ? esc_textarea( $post_meta['rpo_items_count'] ) : esc_textarea( get_option( "posts_per_page" ) );
	$rpo_cols = isset( $post_meta['rpo_cols'] ) ? esc_textarea( $post_meta['rpo_cols'] ) : 4;
	
	$rpo_show = isset( $post_meta['rpo_show'] ) ? $post_meta['rpo_show'] : '';
	$rpo_meta = isset( $post_meta['rpo_meta'] ) ? $post_meta['rpo_meta'] : '';
	
	if (is_array($rpo_meta) && $rpo_meta[0] == '!!!dummy!!!'){
		unset($rpo_meta[0]);
	}
	$rpo_meta = is_array($rpo_meta) ? implode( ",", $rpo_meta ) : $rpo_meta;

	$title = get_the_title();
	$decr_pos = isset( $post_meta['decr_pos'] ) ? $post_meta['decr_pos'] : '';
	$p_type = isset( $post_meta['p_type'] ) ? $post_meta['p_type'] : '';
	$gall_type = isset( $post_meta['gall_type'] ) ? $post_meta['gall_type'] : '';
	$slider_type = isset( $post_meta['slider_type'] ) ? $post_meta['slider_type'] : '';
	$rev_slider_type = isset( $post_meta['rev_slider_type'] ) ? $post_meta['rev_slider_type'] : '';
	$video_type = isset( $post_meta['video_type'] ) ? $post_meta['video_type'] : '';
	$full_width = isset( $post_meta['full_width'] ) ? $post_meta['full_width'] : false;	
	$decr_pos = isset( $post_meta['decr_pos'] ) ? $post_meta['decr_pos'] : '';
	$cont_width = isset( $post_meta['cont_width'] ) ? $post_meta['cont_width'] : '';
	$categories = isset( $post_meta['rpo_categories'] ) ? $post_meta['rpo_categories'] : '';
	if(is_array($categories)){
		if(empty($categories[0])){
			unset($categories[0]);
		}
	}
	$page_classes .= $full_width ? ' full_width' : '';
	$classes = '';
	$classes .= !empty($p_type) ? $p_type : '';
	$classes .= !empty($decr_pos) ? ' ' . $decr_pos : '';
	$classes .= $decr_pos == 'left' || $decr_pos == 'left_s' ? ' reverse' : '';
	$classes .= $decr_pos == 'left_s' || $decr_pos == 'right_s' ? ' sticky' : '';
	$classes .= !empty($decr_pos) && $decr_pos !== 'bot' && !$full_width ? ' flex_col' : '';
	$sticky = $decr_pos == 'left_s' || $decr_pos == 'right_s' ? 'sticky_cont' : '';
	switch ($cont_width) {
		case '25':
			$media_width = '75';
			break;
		case '33':
			$media_width = '66';
			break;
		case '50':
			$media_width = '50';
			break;
		case '66':
			$media_width = '33';
			break;
	}

	$cats = get_the_terms( $p_id, 'cwsportfolio-cat' );
	$cats = $cats ? $cats : array(); 
	$cat_slugs = array();
	foreach( $cats as $cat ){
		$cat_slugs[] = $cat->slug;
	}
	$has_cats = !empty( $cat_slugs );

	$related_posts = array();
	$has_related = false;

	if ( $has_cats ){
		$query_args = array(
			'post_type' => 'cwsportfolio',
		);
		$query_args['tax_query'] = array( array(
			'taxonomy' => 'cwsportfolio-cat',
			'field' => 'slug',
			'terms' => !empty($categories) ? $categories : $cat_slugs
		));
		$query_args["post__not_in"] = array( $p_id );
		$q = new WP_Query( $query_args );
		$related_posts = $q->posts;
		if ( count( $related_posts ) > 0 ){
			$has_related = true;
		}
	}
	$use_related_carousel = $carousel == 1 && $has_related;
	$section_class = "portfolio single";
	$section_class .= $use_related_carousel ? " related" : "";
	echo "<div id='page'" . ( !empty( $page_classes ) ? " class='$page_classes'" : "" ) . ">";
		ob_start();
		ingenious_portfolio_single_post_post_media ();
		$media = ob_get_clean();
		if ( $full_width ) {
			echo sprintf("%s", $media);
		}
		echo "<div class='ingenious_layout_container'>";
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
			echo "<main id='page_content'>";
				$GLOBALS['ingenious_single_post_atts'] = array(
					'sb_layout'						=> $sb_layout_class,
				);
				echo "<section class='$section_class'>";
					echo "<div class='cws_wrapper portfolio_items'>";
						while ( have_posts() ) : the_post();
							$pid = get_the_id();
							echo "<article id='portfolio_post_{$pid}' class='portfolio_post post_single clearfix " . $classes . "'>";
								ob_start();
								ingenious_portfolio_single_post_post_media ();
								$media = ob_get_clean();
								ob_start();
								echo "<div class='portfolio_single_content {$sticky}'>";
									ingenious_portfolio_single_post_title ();
									ingenious_portfolio_single_post_terms ();
									ingenious_portfolio_single_post_content ();
								echo "</div>";
								$content_terms = ob_get_clean();

								if (!$full_width) {
									if ($decr_pos == 'bot') {
										echo !empty($media) ? $media : '';
										echo !empty($content_terms) ? $content_terms : '';
									} else {
										echo "<div class='single_col single_col_" . (!empty($media_width) ? $media_width : '') . "'>";
											echo !empty($media) ? $media : '';
										echo "</div>";
										echo "<div class='single_col single_col_" . $cont_width . "'>";
											echo !empty($content_terms) ? $content_terms : '';
										echo "</div>";
									}
								} else {
									echo sprintf("%s", $content_terms);
								}
								ingenious_page_links ();
							echo "</article>";
						endwhile;
						wp_reset_postdata();
						unset( $GLOBALS['ingenious_single_post_atts'] );
					echo "</div>";

					if ( $use_related_carousel ){
						$related_ids = array();
						foreach ( $related_posts as $related_post ) {
							$related_ids[] = $related_post->ID;
						}
						array_unshift( $related_ids, $p_id );
						$ajax_data = array(
							'current' => $p_id,
							'initial' => $p_id,
							'related_ids' => $related_ids
						);
						echo "<input type='hidden' id='portfolio_single_ajax_data' value='" . esc_attr(json_encode( $ajax_data ) ) . "' />";
						?>
						<div class='carousel_nav_panel clearfix'>
							<div class='prev_section'>
								<div class='prev'>
									<div class="wrap">
										<span><?php esc_html_e( 'Prev' , 'ingenious' ); ?></span>
									</div>
									<i class="fas fa-long-arrow-alt-left"></i>
								</div>
							</div>
							<a href='javascript:history.go(-1)' class="back_link">
								<span></span>
								<span></span>
								<span></span>
								<span></span>
								<span></span>
								<span></span>
								<span></span>
								<span></span>
								<span></span>
							</a>
							<div class='next_section'>
								<div class='next'>
									<div class="wrap">
										<span><?php esc_html_e( 'Next' , 'ingenious' ); ?></span>
									</div>
									<i class="fas fa-long-arrow-alt-right"></i>
								</div>
							</div>
						</div>
						<?php
					}
				echo "</section>";
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
							'portfolio_layout_override'	=> true,
							'portfolio_layout'			=> $rpo_cols,

							'portfolio_show_data_override' => true,
							'portfolio_data_to_show' => $rpo_meta,
							'title_divider'				=> false,

							'info_pos'					=> $rpo_show,
							'anim_style'				=> 'hoverdef',
							'link_show'					=> 'popup_link',
							'call_from'					=> 'related',

							'tax'							=> 'cwsportfolio-cat',
							'terms'							=> !empty($categories) ? implode( ",", $categories ) : $term_slugs,
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
			echo "</main>";
		echo "</div>";
	echo "</div>";

	get_footer();
?>