<?php
get_header();
$p_id = get_the_id();
$meta = get_post_meta( $p_id, 'cws_mb_post' );
$meta = isset( $meta[0] ) ? $meta[0] : array();

extract( shortcode_atts( array(
			'single_img' 	=> true,
			'full_width'	=> false,
		), $meta) );
$single_img	= (bool)$single_img;
$full_width	= (bool)$full_width;
$sb = ingenious_get_sidebars();
extract( $sb );
$post_custom_color = isset($meta['post_custom_color']) ? $meta['post_custom_color'] : '';
$post_title_color = isset($meta['post_title_color']) ? $meta['post_title_color'] : '';
$post_font_color = isset($meta['post_font_color']) ? $meta['post_font_color'] : '';
$post_font_sec_color = isset($meta['post_font_sec_color']) ? $meta['post_font_sec_color'] : '';
$apply_color = isset($meta['apply_color']) ? $meta['apply_color'] : '';
$apply_bg_color = isset($meta['apply_bg_color']) ? $meta['apply_bg_color'] : '';
$custom_title_spacings = isset($meta['custom_title_spacings']) ? $meta['custom_title_spacings'] : '';
$page_title_spacings = isset($meta['page_title_spacings']) ? $meta['page_title_spacings'] : '';
$image_from_post = isset($meta['post_back_image']) ? $meta['post_back_image'] : '';
$custom_title_overlay = isset($meta['custom_title_overlay']) ? $meta['custom_title_overlay'] : '';
$title_overlay = isset($meta['title_overlay']) ? $meta['title_overlay'] : '';
$title_bg_opacity = isset($meta['title_bg_opacity']) ? $meta['title_bg_opacity'] : '';
$post_thumb_url = isset($image_from_post['src']) ? $image_from_post['src'] : '';
$title_space_top = isset($page_title_spacings['top']) ? $page_title_spacings['top'] : '';
$title_space_bot = isset($page_title_spacings['bottom']) ? $page_title_spacings['bottom'] : '';
$title_bg_opacity = $title_bg_opacity !== "" ? strval( (int)$title_bg_opacity / 100 ) : "";
$page_classes = "render_styles";
$page_classes .= $full_width ? ' full_width' : '';
$page_classes .= !empty( $sb_layout_class ) ? " {$sb_layout_class}_sidebar" : "";
$page_classes = trim( $page_classes );
$title = get_the_title();
$meta_postition = ingenious_get_option( "blog_meta_position" );
$meta_postition = isset($meta_postition) ? $meta_postition : 'top';

/* styles */
ob_start();
if ($post_thumb_url) {
	echo ".single-post #page_title_section{
		background-image: url($post_thumb_url);
	}";
}
if ($custom_title_overlay && ( $apply_bg_color == 'single_color' || $apply_bg_color == 'both_color' ) ) {
	echo "#page_title_section:before{
		background-color: $title_overlay;
		opacity: $title_bg_opacity;
	}";
}
if ($custom_title_spacings) {
	echo "#page_title_section .page_title_content{
		padding-top: $title_space_top !important;
		padding-bottom: $title_space_bot !important;
	}";
}
if ( $post_custom_color && ( $apply_color == 'single_color' || $apply_color == 'both_color' ) ) {
	echo "#page_title_section #page_title{
		color: $post_title_color;
	}
	#page_title_section .bread-crumbs a{
		color: $post_font_color;
	}
	#page_title_section .bread-crumbs .current{
		color: $post_font_sec_color;
	}";
}
/* /styles */
$styles = ob_get_clean();
$styles = json_encode($styles);

echo "<div id='page'" . ( !empty( $page_classes ) ? " data-style='".esc_attr($styles)."' class='$page_classes'" : "" ) . ">";
	if ( $single_img && $full_width ) {
		ingenious_post_single_post_media ();
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
			while ( have_posts() ) : the_post();
				$pid = get_the_id();
				echo "<article id='post_post_{$pid}' ";
				post_class( array( 'post_post', 'post_single' ) );
				echo ">";
					ob_start();
					if ( $single_img && !$full_width ) {
						ingenious_post_single_post_media ();
						$header_media = ob_get_clean();
					}
					$floated_media = isset( $GLOBALS['ingenious_single_post_floated_media'] ) ? $GLOBALS['ingenious_single_post_floated_media'] : false;
					unset( $GLOBALS['ingenious_single_post_floated_media'] );
					if ($floated_media) {
						echo "<div class='clearfix post_post_wrapper'>";
					}
						if ( !empty( $header_media ) ){
							if ( $floated_media ){
								echo "<div class='floated_media post_floated_media single_post_floated_media'>";
									echo "<div class='floated_media_wrapper post_floated_media_wrapper single_post_floated_media_wrapper'>";
										echo sprintf("%s", $header_media);
									echo "</div>";
								echo "</div>";
							}
							else{
								echo sprintf("%s", $header_media);
							}
						}
						
						if ($meta_postition == 'top'){
							echo "<div class='post_info_wrap'>";	
								ingenious_post_post_header ();
								ingenious_page_links ();
							echo "</div>";
						}

						echo "<div class='post_post_content_wrapper'>";
							$content = apply_filters( 'the_content', get_the_content () );
							echo !empty( $content ) ? "<div class='post_content post_post_content post_single_post_content" . ( !$floated_media ? " clearfix" : "" ) . "'>$content</div>" : "";	
						echo "</div>";

						if ($meta_postition == 'bottom'){
							echo "<div class='post_info_wrap'>";	
								ingenious_post_post_header ();
								ingenious_page_links ();
							echo "</div>";
						}						
					if ($floated_media) {
						echo "</div>";
					}
				echo "</article>";
			endwhile;
			wp_reset_postdata();
			unset( $GLOBALS['ingenious_single_post_atts'] );
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		echo "</main>";
	echo "</div>";
echo "</div>";

get_footer();
?>