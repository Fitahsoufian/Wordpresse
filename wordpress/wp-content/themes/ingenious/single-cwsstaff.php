<?php
	get_header();

	$sb = ingenious_get_sidebars();
	extract( $sb );
	$page_classes = "";
	$page_classes .= !empty( $sb_layout_class ) ? " {$sb_layout_class}_sidebar" : "";
	$page_classes = trim( $page_classes );

	$p_id = get_queried_object_id ();
	$post_meta = get_post_meta( get_the_ID(), 'cws_mb_post' );
	$post_meta = isset( $post_meta[0] ) ? $post_meta[0] : array();
	$social_group = isset( $post_meta['social_group'] ) ? $post_meta['social_group'] : array();

	echo "<div id='page'" . ( !empty( $page_classes ) ? " class='$page_classes'" : "" ) . ">";
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
				while ( have_posts() ) : the_post();
					echo "<article id='staff_post_{$p_id}' class='staff_post post_single clearfix'>";
							ingenious_staff_single_post_media ();
							ingenious_staff_single_post_title ();

							$deps = ingenious_get_post_term_links_str( 'cwsstaff_member_department' );
							if ( !empty( $deps ) ){
								echo "<div class='post_terms staff_post_terms posts_grid_post_terms'>";
									echo sprintf("%s", $deps);
								echo "</div>";	
							}
							$poss = ingenious_get_post_term_links_str( 'cwsstaff_member_position' );
							$terms = "";
							if ( !empty( $deps ) || !empty( $poss ) ){
								if ( !empty( $poss ) ){
									$terms .= !empty( $terms ) ? INGENIOUS_V_SEP : "";
								}
								if ( !empty( $terms ) ){
									echo "<div class='post_terms staff_post_terms single_post_terms'>";
										echo sprintf("%s", $terms);
									echo "</div>";
								}
							}
							ingenious_staff_single_post_content ();
						ingenious_page_links ();
					echo "</article>";
				endwhile;
				wp_reset_postdata();
				unset( $GLOBALS['ingenious_single_post_atts'] );
			echo "</main>";
		echo "</div>";
	echo "</div>";

	get_footer();
?>