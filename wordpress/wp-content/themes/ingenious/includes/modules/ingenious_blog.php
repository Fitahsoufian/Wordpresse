<?php
function ingenious_sc_blog ( $atts = array(), $content = "" ){
	$out = "";
	$defaults = array(
		'title'									=> '',
		'title_align'							=> 'left',
		'total_items_count'						=> '',
		'layout'								=> 'def',
		'post_hide_meta_override'				=> false,
		'full_width'							=> false,
		'post_hide_meta'						=> '',
		'chars_count'							=> '',
		'display_style'							=> 'grid',
		'items_pp'								=>  esc_html( get_option( 'posts_per_page' ) ),
		'tax'									=> '',
		'terms'									=> '',
		'addl_query_args'						=> array(),
		'links_enable'							=> true,
		'en_hover_color'						=> false,
		'hover_color'							=> '',
		'image_align'							=> 'img_left2',
		'titles'								=> '',
		'el_class'								=> '',
	);
	$atts = shortcode_atts( $defaults, $atts );
	extract( $atts );
	$pid = get_the_id();
	$links_enable	= (bool)$links_enable;
	$full_width = (bool)$full_width;
	$post_type = "post";
	$section_id = uniqid( 'posts_grid_' );
	$total_items_count = !empty( $total_items_count ) ? (int)$total_items_count : PHP_INT_MAX;
	$items_pp = !empty( $items_pp ) ? (int)$items_pp : esc_html( get_option( 'posts_per_page' ) );
	$paged = get_query_var( 'paged' );
	$paged = empty( $paged ) ? 1 : $paged;

	$def_post_layout = ingenious_get_option( 'def_blog_layout' );
	$def_post_layout = isset( $def_post_layout ) ? $def_post_layout : "";
	$layout = ( empty( $layout ) || $layout === "def" ) ? $def_post_layout : $layout; 
	$post_hide_meta_override = !empty( $post_hide_meta_override ) ? true : false;
	$post_hide_meta = explode( ",", $post_hide_meta );
	$post_def_hide_meta = ingenious_get_option( 'def_post_hide_meta' );
	$post_def_hide_meta  = isset( $post_def_hide_meta ) ? $post_def_hide_meta : array();
	$post_hide_meta = $post_hide_meta_override ? $post_hide_meta : $post_def_hide_meta;
	
	$el_class = esc_attr( $el_class );
	$sb = ingenious_get_sidebars();
	$sb_layout = isset( $sb['sb_layout_class'] ) ? $sb['sb_layout_class'] : '';
	$titles = !empty($titles) ? explode( ',', $titles ) : null;
	if ( $tax == 'title' && !empty( $titles ) ) {
		$items_pp = count( $titles );
	}	
	$terms = explode( ",", $terms );	
	$terms_temp = array();
	foreach ( $terms as $term ) {
		if ( !empty( $term ) ){
			array_push( $terms_temp, $term );
		}
	}
	$terms = $terms_temp;
	$all_terms = array();
	$all_terms_temp = !empty( $tax ) ? get_terms( $tax ) : array();
	$all_terms_temp = !is_wp_error( $all_terms_temp ) ? $all_terms_temp : array();
	foreach ( $all_terms_temp as $term ){
		array_push( $all_terms, $term->slug );
	}
	$terms = !empty( $terms ) ? $terms : $all_terms;
	$query_args = array('post_type'			=> array( $post_type ),
						'post_status'		=> 'publish',
						);
	if ( in_array( $display_style, array( 'grid' ) ) ){
		$query_args['posts_per_page']		= $items_pp;
		$query_args['paged']		= $paged;
	}
	else{
		$query_args['nopaging']				= true;
		$query_args['posts_per_page']		= -1;
	}
	if ( !empty( $terms ) ){
		$query_args['tax_query'] = array(
			array(
				'taxonomy'		=> $tax,
				'field'			=> 'slug',
				'terms'			=> $terms
			)
		);
	}
	if (!empty($titles)) {
		$query_args['post__in'] = $titles;
	}
	$en_hover_color = (bool)$en_hover_color;
	$hover_color = $en_hover_color ? esc_html($hover_color) : '';
	/* styles */
	ob_start();
	if ($en_hover_color) {
		echo "#{$section_id} .hover-effect {
			background: $hover_color;
		}";
	}
	$styles = ob_get_clean();
	$styles = json_encode($styles);
	$query_args = array_merge( $query_args, $addl_query_args );
	$q = new WP_Query( $query_args );
	$found_posts = $q->found_posts;
	$requested_posts = $found_posts > $total_items_count ? $total_items_count : $found_posts;
	$max_paged = $found_posts > $total_items_count ? ceil( $total_items_count / $items_pp ) : ceil( $found_posts / $items_pp );
	$cols = in_array( $layout, array( 'medium', 'small', 'checkerboard', 'fw_img' ) ) ? 1 : (int)$layout;
	$is_carousel = $display_style == 'carousel' && $requested_posts > $cols;
	if ( $is_carousel ){
		wp_enqueue_script( 'owl_carousel' );
	}
	else if ( is_numeric( $layout ) ){
		wp_enqueue_script( 'isotope' );
	}
	wp_enqueue_script( 'fancybox' );
	$use_pagination = in_array( $display_style, array( 'grid' ) ) && $max_paged > 1;
	$pagination_type = "pagination";
	$image_align = !empty($image_align) ? $image_align : '';
	ob_start ();
	echo "<section id='$section_id' data-style='".esc_attr($styles)."' class='posts_grid {$post_type}_posts_grid posts_grid_{$layout} posts_grid_{$display_style} render_styles $image_align" . ( !empty( $el_class ) ? " $el_class" : "" ) . "'>";
		if ( $is_carousel ){
			echo "<div class='widget_header clearfix'>";
				echo !empty( $title ) ? "<h2 class='widgettitle'>" . esc_html( $title ) . "</h2>" : "";				
				echo "<div class='carousel_nav'>";
					echo "<span class='prev'>";
					echo "</span>";
					echo "<span class='next'>";
					echo "</span>";
				echo "</div>";
			echo "</div>";			
		}
		else{
			echo !empty( $title ) ? "<h2 class='widgettitle text_align{$title_align}'>" . esc_html( $title ) . "</h2>" : "";
		}
		echo "<div class='ingenious_wrapper'>";
			echo "<div class='" . ( $is_carousel ? "ingenious_carousel" : "ingenious_grid" . ( is_numeric( $layout ) ? " isotope" : "" ) ) . "'" . ( $is_carousel ? " data-cols='" . ( !is_numeric( $layout ) ? "1" : $layout ) . "'" : "" ) . ">";
				$GLOBALS['ingenious_posts_grid_atts'] = array(
					'layout'						=> $layout,
					'sb_layout'						=> $sb_layout,
					'post_hide_meta'				=> $post_hide_meta,
					'chars_count'					=> $chars_count,
					'total_items_count'				=> $total_items_count,
					'links_enable'					=> $links_enable,
					'en_hover_color'				=> $en_hover_color,
					'image_align'					=> $image_align,
					'full_width'					=> $full_width,
				);

				if ( function_exists( "ingenious_post_posts_grid_posts" ) ){
					call_user_func_array( "ingenious_post_posts_grid_posts", array( $q ) );
				}

				unset( $GLOBALS['ingenious_posts_grid_atts'] );
			echo "</div>";
		echo "</div>";
		if ( $use_pagination ){
			ingenious_pagination ( $paged, $max_paged, false );
		}
	echo "</section>";
	$out = ob_get_clean();
	return $out;
}

function ingenious_get_special_post_formats (){
	return array( "status" );
}
function ingenious_is_special_post_format (){
	global $post;
	$sp_post_formats = ingenious_get_special_post_formats ();
	if ( isset($post) ){
		return in_array( get_post_format(), $sp_post_formats );
	}
	else{
		return false;
	}
}
function ingenious_post_format_mark (){
	global $post;
	if ( isset( $post ) ){
		$pf = get_post_format ();
		$icon = "book";
		switch ( $pf ){
			case "aside":
				$icon = "bullseye";
				break;
			case "gallery":
				$icon = "bullseye";
				break;
			case "link":
				$icon = "chain";
				break;
			case "image":
				$icon = "image";
				break;
			case "quote":
				$icon = "quote-left";
				break;
			case "status":
				$icon = "flag";
				break;
			case "video":
				$icon = "video-camera";
				break;
			case "audio":
				$icon = "music";
				break;
			case "chat":
				$icon = "wechat";
				break;
		}
		$out = "<i class='$icon'></i> $pf";
		return $out;
	}
	else{
		return "";
	}
}

function ingenious_get_post_thumbnail_dims ( $eq_thumb_height = false, $real_dims = array() ) {
	$def_grid_atts = array(
					'layout'				=> '1',
					'sb_layout'				=> '',
					'full_width'			=> '',
				);
	$def_single_atts = array(
					'sb_layout'				=> '',
				);
	$post_meta = get_post_meta( get_the_ID(), 'cws_mb_post' );
	$post_meta = isset( $post_meta[0] ) ? $post_meta[0] : array();
	$grid_atts = isset( $GLOBALS['ingenious_posts_grid_atts'] ) ? $GLOBALS['ingenious_posts_grid_atts'] : $def_grid_atts;
	$single_atts = isset( $GLOBALS['ingenious_single_post_atts'] ) ? $GLOBALS['ingenious_single_post_atts'] : $def_single_atts;
	$shot = isset( $GLOBALS['ingenious_row_fw_atts'] ) ? $GLOBALS['ingenious_row_fw_atts'] : $def_grid_atts;
	$single_fw = isset( $post_meta['full_width'] ) ? $post_meta['full_width'] : false;
	$single = is_single();
	if ( $single ){
		extract( $single_atts );
	}
	else{
		extract( $grid_atts );
	}
	extract($shot);
	if ($full_width == 'stretch_row_content' || $full_width == 'stretch_row_content_no_spaces') {
		$full_width = true;
	}
	$dims = array( 'width' => 0, 'height' => 0 );
	if ( $single ){
		if ( empty( $sb_layout ) ){
			if ( ( empty( $real_dims ) || ( isset( $real_dims['width'] ) && $real_dims['width'] > 1170 ) ) || $eq_thumb_height ){
				if ($single_fw) {
					$dims['width'] = 1920;
				} else{
					$dims['width'] = 1170;
				}
			}
		}
		else if ( $sb_layout === "single" ){
			if ( ( empty( $real_dims ) || ( isset( $real_dims['width'] ) && $real_dims['width'] > 870 ) ) || $eq_thumb_height ){
				$dims['width'] = 870;
				if ( $eq_thumb_height ) $dims['height'] = 490;
			}
		}
		else if ( $sb_layout === "double" ){
			if ( ( empty( $real_dims ) || ( isset( $real_dims['width'] ) && $real_dims['width'] > 570 ) ) || $eq_thumb_height ){
				$dims['width'] = 570;
				if ( $eq_thumb_height ) $dims['height'] = 290;
			}
		}
	} else if ($full_width){
		switch ($layout){
			case "1":	
				$dims['width'] = 1920;
				if ( !isset( $real_dims['height'] ) ){
					$dims['height'] = 1080;
				}		
				break;
			case '2':
				$dims['width'] = 1000;
				if ( !isset( $real_dims['height'] ) ){
					$dims['height'] = 208;
				}		
				break;
			case '3':
				$dims['width'] = 750;
				if ( !isset( $real_dims['height'] ) ){
					$dims['height'] = 208;
				}		
				break;
			case '4':
				$dims['width'] = 500;
				if ( !isset( $real_dims['height'] ) ){
					$dims['height'] = 152;
				}
				break;
		}
	} else{
		switch ($layout){
			case "1":
				if ( empty( $sb_layout ) ){
					$dims['width'] = 1170;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 659;
					}	
				}
				else if ( $sb_layout === "single" ){
					$dims['width'] = 870;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 490;
					}	
				}
				else if ( $sb_layout === "double" ){
					$dims['width'] = 570;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 290;
					}	
				}
				break;
			case "medium":
				$dims['width'] = 570;
				if ( !isset( $real_dims['height'] ) ){
					$dims['height'] = 290;
				}	
				break;
			case "fw_img":
				$dims['width'] = 570;
				if ( !isset( $real_dims['height'] ) ){
					$dims['height'] = 290;
				}	
				break;
			case "checkerboard":
				$dims['width'] = 570;
				if ( !isset( $real_dims['height'] ) ){
					$dims['height'] = 290;
				}	
				break;
			case "small":
				$dims['width'] = 370;
				if ( !isset( $real_dims['height'] ) ){
					$dims['height'] = 208;
				}	
				break;
			case '2':
				if ( empty( $sb_layout ) ){
					$dims['width'] = 570;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 290;
					}	
				}
				else if ( $sb_layout === "single" ){
					$dims['width'] = 420;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 237;
					}	
				}
				else if ( $sb_layout === "double" ){
					$dims['width'] = 270;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 152;
					}	
				}
				break;
			case '3':
				if ( empty( $sb_layout ) ){
					$dims['width'] = 370;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 208;
					}	
				}
				else if ( $sb_layout === "single" ){
					$dims['width'] = 270;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 152;
					}	
				}
				else if ( $sb_layout === "double" ){
					$dims['width'] = 270;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 152;
					}	
				}			
				break;
			case '4':
				$dims['width'] = 270;
				if ( !isset( $real_dims['height'] ) ){
					$dims['height'] = 152;
				}	
				break;
		}
	}
	return $dims;
}

function ingenious_post_posts_grid_posts ( $q = null ){
	if ( !isset( $q ) ) return;
	$def_grid_atts = array(
					'layout'				=> '1',
					'post_hide_meta'		=> array(),
					'total_items_count'		=> PHP_INT_MAX
				);
	$grid_atts = isset( $GLOBALS['ingenious_posts_grid_atts'] ) ? $GLOBALS['ingenious_posts_grid_atts'] : $def_grid_atts;
	extract( $grid_atts );
	$paged = $q->query_vars['paged'];
	if ( $paged == 0 && $total_items_count < $q->post_count ){
		$post_count = $total_items_count;
	}
	else{
		$ppp = $q->query_vars['posts_per_page'];
		$posts_left = $total_items_count - ( $paged - 1 ) * $ppp;
		$post_count = $posts_left < $ppp ? $posts_left : $q->post_count;
	}
	if ( $q->have_posts() ):
		ob_start();
		while( $q->have_posts() && $q->current_post < $post_count - 1 ):
			$q->the_post();
			ingenious_post_posts_grid_post ();
		endwhile;
		wp_reset_postdata();
		ob_end_flush();
	endif;				
}
function ingenious_post_posts_grid_post (){
	$def_grid_atts = array(
					'layout'				=> '1',
					'post_hide_meta'				=> array(),
				);
	$grid_atts = isset( $GLOBALS['ingenious_posts_grid_atts'] ) ? $GLOBALS['ingenious_posts_grid_atts'] : $def_grid_atts;
	extract( $grid_atts );
	$pid = get_the_id();
	$links_enable = (bool)$links_enable;
	$floated_media = in_array( $layout, array( 'medium', 'small', 'checkerboard', 'fw_img' ) );
	$post_id = get_the_id();
	$post_meta = get_post_meta( $post_id, 'cws_mb_post' );
	$post_meta = isset( $post_meta[0] ) ? $post_meta[0] : array();
	$image_from_post = isset($post_meta['post_back_image']) ? $post_meta['post_back_image'] : '';
	$post_title_color = isset($post_meta['post_title_color']) ? $post_meta['post_title_color'] : '';
	$post_font_color = isset($post_meta['post_font_color']) ? $post_meta['post_font_color'] : '';
	$post_font_sec_color = isset($post_meta['post_font_sec_color']) ? $post_meta['post_font_sec_color'] : '';
	$custom_title_overlay = isset($post_meta['custom_title_overlay']) ? $post_meta['custom_title_overlay'] : '';
	$post_custom_color = isset($post_meta['post_custom_color']) ? $post_meta['post_custom_color'] : '';
	$apply_color = isset($post_meta['apply_color']) ? $post_meta['apply_color'] : '';
	$apply_bg_color = isset($post_meta['apply_bg_color']) ? $post_meta['apply_bg_color'] : '';
	$title_overlay = isset($post_meta['title_overlay']) ? $post_meta['title_overlay'] : '';
	$title_bg_opacity = isset($post_meta['title_bg_opacity']) ? $post_meta['title_bg_opacity'] : '';
	$title_bg_opacity = $title_bg_opacity !== "" ? strval( (int)$title_bg_opacity / 100 ) : "";
	/* styles */

	ob_start();
	if ( $post_custom_color && ( $apply_color == 'list_color' || $apply_color == 'both_color' ) ) {
		echo "#post_post_{$pid} .post_title,
			#post_post_{$pid} .post_title a:hover,
			#post_post_{$pid} .date{
				color: $post_title_color;
			}
			#post_post_{$pid} .post_info_wrap{
				border-top-color: $post_title_color;
			}
			#post_post_{$pid} .post_post_header > *,
			#post_post_{$pid} .post_info_wrap .info_icon,
			#post_post_{$pid} .post_post_content{
				color: $post_font_color;
			}	
			#post_post_{$pid} .more-link{
				border-color: $post_font_sec_color;
				color: $post_font_sec_color;
			}
			#post_post_{$pid} .more-link:hover{
				background-color: transparent;
			}";
	}
	if ( $post_custom_color && ( $apply_color == 'single_color' ) ) {
		echo ".page_title_content #page_title{
				color: $post_title_color;
			}
			.page_title_content .bread-crumbs{
				color: $post_font_color;
			}";
	}
	if ($custom_title_overlay == 1 && ( $apply_bg_color == 'list_color' || $apply_bg_color == 'both_color' ) ) {
		echo "#post_post_{$pid}.post_grid_post:before{
			background-color: $title_overlay;
			opacity: $title_bg_opacity;
		}";
	}
	/* \styles */
	$styles = ob_get_clean();
	$styles = json_encode($styles);
	echo "<article data-style='".esc_attr($styles)."' id='post_post_{$pid}' ";
	post_class( array( 'item', 'post_post', 'render_styles', 'post_grid_post', (is_sticky(get_the_id()) ? "sticky-post ": ''), ($links_enable == true ? 'hover_on' : '') ) );
	echo ">";
		if (!empty($image_from_post) && $layout == 'fw_img') {
			$back_img_src = $image_from_post['src'];
			echo "<div class='back_img' style='background-image: url($back_img_src)'></div>";
		}
		if ($floated_media) {
			echo "<div class='clearfix'>";
		}
			if ($floated_media) {
				echo "<div class='floated_media posts_grid_post_floated_media post_posts_grid_post_floated_media'>";
			}
				if ($floated_media) {
					echo "<div class='floated_media_wrapper posts_grid_post_floated_media_wrapper post_posts_grid_post_floated_media_wrapper'>";
				}
					ingenious_post_posts_grid_post_media ();	
				if ($floated_media) {
					echo "</div>";
				}
			if ($floated_media) {
				echo "</div>";
			}
			echo "<div class='post_post_content_wrapper'>";
				ingenious_post_posts_grid_post_title ();
				ingenious_post_post_header ();
				ingenious_post_posts_grid_post_content ();
				ingenious_post_posts_grid_post_more ();
				ingenious_page_links ();
			echo "</div>";	
		if ($floated_media) {
			echo "</div>";
		}	
	echo "</article>";
}
function ingenious_post_posts_grid_post_title (){
	$def_grid_atts = array(
				'post_hide_meta'		=> array(),
			);
	$grid_atts = isset( $GLOBALS['ingenious_posts_grid_atts'] ) ? $GLOBALS['ingenious_posts_grid_atts'] : $def_grid_atts;
	extract( $grid_atts );
	$pid = get_the_id();
	$title = get_the_title();
	$permalink = get_the_permalink();
	$is_special_post_format = ingenious_is_special_post_format();
	$title_out = !$is_special_post_format && !empty( $title ) ? "<h3 class='post_post_title post_title'><a href='$permalink'>" . $title . "</a></h3>" : "";
	echo "<div class='post_title_wrap'>$title_out</div>";
}
function ingenious_post_post_header (){
	$def_grid_atts = array(
				'post_hide_meta'		=> array(),
			);
	$grid_atts = isset( $GLOBALS['ingenious_posts_grid_atts'] ) ? $GLOBALS['ingenious_posts_grid_atts'] : $def_grid_atts;
	extract( $grid_atts );
	$header_content = "";
	$single = is_single();
	if ($single) {
		if ( !in_array( 'date', $post_hide_meta ) ){
			$date = get_the_date();
			$header_content .= "<div class='date'><div class='date_container'><div class='cws-icon-calendar-with-spring-binder-and-date-blocks info_icon'></div><span>$date</span></div></div>";
		}
	}
	$pid = get_the_id();
	$permalink = get_the_permalink( $pid );
	$def_grid_atts = array(
					'layout'				=> '1',
					'post_hide_meta'		=> array(),
				);
	$grid_atts = isset( $GLOBALS['ingenious_posts_grid_atts'] ) ? $GLOBALS['ingenious_posts_grid_atts'] : $def_grid_atts;
	extract( $grid_atts );
	/* Post Info */
	if ( !in_array( 'post_info', $post_hide_meta ) ){
		$author = get_the_author();
		$special_pf = ingenious_is_special_post_format();
		if ( !empty($author) || $special_pf ){
			$header_content .= "<div class='info'>";
				$header_content .= "<div class='info_container'>";
					$header_content .= !empty($author) ? "<div class='cws-icon-user info_icon'></div><span>". esc_html__("by", "ingenious") ." $author</span>" : "";
					$header_content .= $special_pf ? ( !empty($author) ? INGENIOUS_V_SEP : "" ) . ingenious_post_format_mark() : "";
				$header_content .= "</div>";
			$header_content .= "</div>";
		}
	}
	/* Likes */
	if ( !in_array( 'likes', $post_hide_meta ) && ingenious_check_for_plugin( 'ingenious-shortcodes/ingenious-shortcodes.php' ) ){
		$header_content .= "<div class='like simple_like'>".cws_vc_shortcode_get_simple_likes_button( get_the_ID() )."</div>";
	}	
	/* Comments */
	if ( !in_array( 'comments', $post_hide_meta ) ){
		$comments_n = get_comments_number();
		if ( (int)$comments_n > 0 ){
			$permalink .= "#comments";
			$header_content .= "<a href='$permalink' class='comments_link'><div class='cws-icon-chat info_icon'></div>$comments_n ". esc_html__("comments", "ingenious") ."</a>";
		}
	}
	/* Terms */
	$terms = $tags = $cats = "";
	if ( has_category() ) {
		ob_start();
		the_category ( "&#x20;" );
		$cats .= ob_get_clean();
	}
	
	if ( has_tag() ) {
		ob_start();
		the_tags ( "", "&#x20;", "" );
		$tags .= ob_get_clean();
	}
	$terms .= !empty( $cats ) ? $cats : "";
	$terms .= !empty( $tags ) ? $tags : "";
	if ( !in_array( 'terms', $post_hide_meta ) ){		
		if ( !empty( $terms ) ){
			$header_content .= "<div class='meta_wrapper'>";
			$header_content .= "$terms";
			$header_content .= "</div>";
		}
	}
	/* Layout */
	if ( !empty( $header_content ) ){
		echo "<div class='post_post_header'>";
			echo sprintf("%s", $header_content);
		echo "</div>";		
	}
}

function ingenious_post_posts_grid_post_media (){
	$theme_custom_color = esc_attr( ingenious_get_option( 'theme_color' ) );
	$figure_style =  ingenious_figure_style() ;
	$pid = get_the_id();
	$def_grid_atts = array(
					'layout'				=> '1',
					'post_hide_meta'		=> array(),
					'links_enable'			=> '',
				);
	$grid_atts = isset( $GLOBALS['ingenious_posts_grid_atts'] ) ? $GLOBALS['ingenious_posts_grid_atts'] : $def_grid_atts;	
	extract( $grid_atts );	
	$links_enable = (bool)$links_enable;
	$post_url = esc_url(get_the_permalink());
	$post_format = get_post_format();
	$eq_thumb_height = in_array( $post_format, array( 'gallery' ) );
	$media_meta = get_post_meta( get_the_ID(), 'cws_mb_post' );
	$media_meta = isset( $media_meta[0] ) ? $media_meta[0] : array();
	$thumbnail_props = has_post_thumbnail( ) ? wp_get_attachment_image_src(get_post_thumbnail_id( ),'full') : array();
	$thumb_id = get_post_thumbnail_id();
	$thumbnail = !empty( $thumbnail_props ) ? $thumbnail_props[0] : '';
	$real_thumbnail_dims = array();
	if ( !empty( $thumbnail_props ) && isset( $thumbnail_props[1] ) ) $real_thumbnail_dims['width'] = $thumbnail_props[1];
	if ( !empty(  $thumbnail_props ) && isset( $thumbnail_props[2] ) ) $real_thumbnail_dims['height'] = $thumbnail_props[2];
	$thumbnail_dims = ingenious_get_post_thumbnail_dims( $eq_thumb_height, $real_thumbnail_dims );
	$thumb_media = false;
	$some_media = false;
	if ( !in_array( 'date', $post_hide_meta ) ){
		$day = get_the_date("j");
		$month = get_the_date("M");
		$post_date = "<div class='date'><span>$day</span>$month</div>";
	}
	ob_start();
	?>
		<div class="post_media post_post_media post_posts_grid_post_media">
			<?php
				switch ($post_format) {
					case 'link':
						$link = isset( $media_meta[$post_format] ) ? esc_url( $media_meta[$post_format] ) : "";
						if ( !empty($thumbnail) ) {
							$thumb_obj = ingenious_thumb( $thumbnail, $thumbnail_dims, $thumb_id );
							$thumb_url = isset( $thumb_obj[0] ) ? esc_url( $thumb_obj[0] ) : "";
							$thumbnail = esc_url($thumbnail);
							$retina_thumb_exists = false;
								$retina_thumb_url = "";
							?>
							<div class="pic <?php echo !empty( $link ) ? 'link_post' : ''; ?>">
								<?php
								echo !empty($link) ? "<a href='$link'>" : '';
								if ( $retina_thumb_exists ) {
									echo "<img src='$thumb_url' data-at2x='$retina_thumb_url' alt />";
								}	else {
									echo "<img src='$thumb_url' data-no-retina alt />";
								}
								?>
								<div class="hover-effect"></div>
								<?php
								if ( !empty( $link ) ) {
									echo "<div class='link'><span>$link</span></div>";
								} else if ( $links_enable ) {
									echo "<div class='links'><a class='fancy fa fa-plus' href='$thumbnail'></a>" . ( !$single ? "<a class='fa fa-share' href='$post_url'></a>" : "" ) . "</div>";
								}
								echo !empty($link) ? "</a>" : '';
								?>
							</div>
							<?php
							$thumb_media = true;
							$some_media = true;
						}
						else{
							if ( !empty( $link ) ) {
								echo "<div class='link'><a href='$link'>$link</a></div>";
								$some_media = true;
							}
						}
						$some_media = true;
						break;
					case 'video':
						$video = isset($media_meta[$post_format]) ? esc_attr($media_meta[$post_format]) : '';
						if ( !empty( $video ) ) {
							echo "<div class='video'>" . apply_filters('the_content',"[embed width='" . $thumbnail_dims['width'] . "']" . $video . "[/embed]") . "</div>";
							$some_media = true;
						}
						break;
					case 'audio':
					$audio = isset($media_meta[$post_format]) ? esc_attr($media_meta[$post_format]) : '';
						$is_soundcloud = is_int( strpos( (string) $audio, 'https://soundcloud' ) );
						if ($is_soundcloud){
							echo "<div class='soundcloud'>";
								echo apply_filters( 'the_content',"[embed width='".$thumbnail_dims['width']."' height='".$thumbnail_dims['height']."'] $audio [/embed]" );
							echo '</div>';						
							$some_media = true;
						} else {
							if ( !empty( $thumbnail ) ){
								$thumb_obj = ingenious_thumb( $thumbnail, $thumbnail_dims, $thumb_id );
								$thumb_url = isset( $thumb_obj[0] ) ? esc_url( $thumb_obj[0] ) : "";
								$thumbnail = esc_url($thumbnail);
								$retina_thumb_exists = false;
								$retina_thumb_url = "";
								echo "<div class='pic wth_hover'>";
									if ( $retina_thumb_exists ) {
										echo "<img src='$thumb_url' data-at2x='$retina_thumb_url' alt />";
									}	else {
										echo "<img src='$thumb_url' data-no-retina alt />";
									}
								echo "</div>";
								$thumb_media = true;
								$some_media = true;								
							}
							if ( !empty( $audio ) ){
								echo "<div class='audio'>" . apply_filters( 'the_content','[audio src="' . esc_url( $audio ) . '"]' ) . '</div>';						
								$some_media = true;
							}
						}
						break;
					case 'quote':
						$quote = isset( $media_meta['quote_text'] ) ? $media_meta['quote_text'] : '';
						$author_name = isset( $media_meta['author_name'] ) ? $media_meta['author_name'] : '';
						$author_status = isset( $media_meta['author_status'] ) ? $media_meta['author_status'] : '';		

						if ( !empty($thumbnail) ) {
							?>
							<div class="pic <?php echo !empty( $quote ) ? 'quote_post' : ''; ?>">
								<?php
								$src_img = ingenious_print_img_html(array('src' => $thumbnail), array( 'height' => $thumbnail_dims['height'], 'width' => $thumbnail_dims['width'], 'crop' => true ), $thumb_id );
								print "<img".$src_img." alt />";
								if ( !empty( $quote ) && !empty( $author_name )) {
									echo "<div class='hover-effect'></div>";
									echo "<div class='quote-wrap'>";
										echo "<div class='quote-cont'>";
											echo "<div class='quote'>";
												echo !empty($quote) ? "<p class='text'>".esc_html($quote)."</p>" : '';
												echo !empty($author_name) ? "<p class='author'>".esc_html($author_name)."</p>" : '';
												echo !empty($author_status) ? "<p class='author_position'>".esc_html($author_status)."</p>" : '';
											echo '</div>';
										echo '</div>';
									echo '</div>';
								}
								?>
							</div>
							<?php
							$thumb_media = true;
						} else {
							echo "<div class='quote-wrap'>";
								echo "<div class='quote-cont'>";
									echo "<div class='quote'>";
										echo !empty($quote) ? "<p class='text'>".esc_html($quote)."</p>" : '';
										echo !empty($author_name) ? "<p class='author'>".esc_html($author_name)."</p>" : '';
										echo !empty($author_status) ? "<p class='author_position'>".esc_html($author_status)."</p>" : '';
									echo '</div>';
								echo '</div>';
							echo '</div>';
						}					
						$some_media = true;
						break;
					case 'gallery':					
						$gallery = isset( $media_meta[$post_format] ) ? $media_meta[$post_format] : "";
						if ( !empty( $gallery ) ) {
							$match = preg_match_all("/\d+/",$gallery,$images);
							if ($match){
								$images = $images[0];
								$image_srcs = array();
								foreach ( $images as $image ) {
									$image_src = wp_get_attachment_image_src($image,'full');
									if ( $image_src ){
										$image_url['src'] = $image_src[0];
										$image_url['id'] = $image;
										array_push( $image_srcs, $image_url );
									}
								}
								$thumb_media = $some_media = count( $image_srcs ) > 0 ? true : false;
								$carousel = count($image_srcs) > 1 ? true : false;
								$gallery_id = uniqid( 'cws-gallery-' );
								if ($carousel) {
									echo "<a class='gallery_post_carousel_nav carousel_nav prev'>
													<span></span>
													</a>
													<a class='gallery_post_carousel_nav carousel_nav next'>
													<span></span>
													</a>
													<div class='gallery_post_carousel'>";
								}
								foreach ( $image_srcs as $image_src ) {
									$img_obj = ingenious_thumb( $image_src['src'], $thumbnail_dims , $image_src['id'] );
									$img_url = isset( $img_obj[0] ) ? esc_url( $img_obj[0] ) : "";
									$retina_thumb_exists = false;
									$retina_thumb_url = "";
									echo "<div class='pic'>";
										if ( $retina_thumb_exists ) {
											echo "<img src='$img_url' data-at2x='$retina_thumb_url' alt />";
										}
										else{
											echo "<img src='$img_url' data-no-retina alt />";
										}
										if ( $links_enable)  {
											echo "<div class='hover-effect'></div>";
											echo "<a href='$post_url' class='links area'></a>";
										}
									echo "</div>";
								}
								if ($carousel) {
									echo "</div>";
								}
							}
						}
						break;
				}
				if ( !$some_media && !empty( $thumbnail ) ) {
					$thumb_obj = ingenious_thumb( $thumbnail, $thumbnail_dims, $thumb_id );
					$thumb_url = isset( $thumb_obj[0] ) ? esc_url($thumb_obj[0]) : "";
					$retina_thumb_exists = false;
					$retina_thumb_url = "";	
					$retina_thumb_url = esc_attr($retina_thumb_url);
					echo "<div class='pic'>";
						if ( $retina_thumb_exists ) {
							echo "<img src='$thumb_url' data-at2x='$retina_thumb_url' alt />";
						}
						else{
							echo "<img src='$thumb_url' data-no-retina alt />";
						}
						if ( $links_enable)  {
							echo "<div class='hover-effect'></div>";
							echo "<a href='$post_url' class='links area'></a>";
						}
					echo "</div>";
					$thumb_media = true;
					$some_media = true;
				}
				echo sprintf("%s", $post_date);
			?>
		</div>
	<?php
	$some_media ? ob_end_flush() : ob_end_clean();
	if ( $thumb_media ){
		wp_enqueue_script( 'fancybox' );
	}
}

function ingenious_post_single_post_media (){
	$pid = get_the_id();
	$figure_style =  ingenious_figure_style() ;
	$def_grid_atts = array(
					'layout'				=> '1',
					'post_hide_meta'		=> array(),
				);
	$grid_atts = isset( $GLOBALS['ingenious_posts_grid_atts'] ) ? $GLOBALS['ingenious_posts_grid_atts'] : $def_grid_atts;	
	extract( $grid_atts );	
	$post_url = esc_url(get_the_permalink());
	$post_format = get_post_format( );
	$eq_thumb_height = in_array( $post_format, array( 'gallery' ) );
	$media_meta = get_post_meta( get_the_ID(), 'cws_mb_post' );
	$media_meta = isset( $media_meta[0] ) ? $media_meta[0] : array();
	$thumbnail_props = has_post_thumbnail( ) ? wp_get_attachment_image_src(get_post_thumbnail_id( ),'full') : array();
	$thumb_id = get_post_thumbnail_id();
	$thumbnail = !empty( $thumbnail_props ) ? $thumbnail_props[0] : '';
	$real_thumbnail_dims = array();
	if ( !empty( $thumbnail_props ) && isset( $thumbnail_props[1] ) ) $real_thumbnail_dims['width'] = $thumbnail_props[1];
	if ( !empty(  $thumbnail_props ) && isset( $thumbnail_props[2] ) ) $real_thumbnail_dims['height'] = $thumbnail_props[2];
	$thumbnail_dims = ingenious_get_post_thumbnail_dims( $eq_thumb_height, $real_thumbnail_dims );
	$crop_thumb = isset( $thumbnail_dims['width'] ) && $thumbnail_dims['width'] > 0;
	$thumb_media = false;
	$some_media = false;
	ob_start();
	?>
		<div class='post_media post_post_media post_single_post_media'>
		<?php
			switch ($post_format) {
				case 'link':
					$link = isset( $media_meta[$post_format] ) ? esc_url( $media_meta[$post_format] ) : "";
					if ( !empty($thumbnail) ) {
						$thumb_obj = ingenious_thumb( $thumbnail, $thumbnail_dims, $thumb_id );
						$thumb_url = isset( $thumb_obj[0] ) ? esc_url( $thumb_obj[0] ) : "";
						$thumbnail = esc_url($thumbnail);
						$retina_thumb_exists = false;
							$retina_thumb_url = "";
						?>
						<div class="pic <?php echo !empty( $link ) ? 'link_post' : ''; ?>">
							<?php
							echo !empty($link) ? "<a href='$link'>" : '';
							if ( $retina_thumb_exists ) {
								echo "<img src='$thumb_url' data-at2x='$retina_thumb_url' alt />";
							}	else {
								echo "<img src='$thumb_url' data-no-retina alt />";
							}
							?>
							<div class="hover-effect"></div>
							<?php
							if ( !empty( $link ) ) {
								echo "<div class='link'><span>$link</span></div>";
							} else {
								echo "<div class='links'><a class='fancy fa fa-plus' href='$thumbnail'>$figure_style</a></div>";
							}
							echo !empty($link) ? "</a>" : '';
							?>
						</div>
						<?php
						$thumb_media = true;
						$some_media = true;
					}
					else{
						if ( !empty( $link ) ) {
							echo "<div class='link'><a href='$link'>$link</a></div>";
							$some_media = true;
						}
					}
					$some_media = true;
					break;
				case 'video':
					$video = isset($media_meta[$post_format]) ? esc_attr($media_meta[$post_format]) : '';
					if ( !empty( $video ) ) {
						echo "<div class='video'>" . apply_filters('the_content',"[embed width='" . $thumbnail_dims['width'] . "']" . $video . "[/embed]") . "</div>";
						$some_media = true;
					}
					break;
				case 'audio':
					$audio = isset($media_meta[$post_format]) ? esc_attr($media_meta[$post_format]) : '';
					$is_soundcloud = is_int( strpos( (string) $audio, 'https://soundcloud' ) );
					if ($is_soundcloud){
						echo "<div class='soundcloud'>";
							echo apply_filters( 'the_content',"[embed width='".$thumbnail_dims['width']."' height='".$thumbnail_dims['height']."'] $audio [/embed]" );
						echo '</div>';						
						$some_media = true;
					} else {
						if ( !empty( $thumbnail ) ){
							$thumb_obj = ingenious_thumb( $thumbnail, $thumbnail_dims, $thumb_id );
							$thumb_url = isset( $thumb_obj[0] ) ? esc_url( $thumb_obj[0] ) : "";
							$thumbnail = esc_url($thumbnail);
							$retina_thumb_exists = false;
							$retina_thumb_url = "";
							echo "<div class='pic wth_hover'>";
								if ( $retina_thumb_exists ) {
									echo "<img src='$thumb_url' data-at2x='$retina_thumb_url' alt />";
								}	else {
									echo "<img src='$thumb_url' data-no-retina alt />";
								}
							echo "</div>";
							$thumb_media = true;
							$some_media = true;								
						}
						if ( !empty( $audio ) ){
							echo "<div class='audio'>" . apply_filters( 'the_content','[audio src="' . esc_url( $audio ) . '"]' ) . '</div>';						
							$some_media = true;
						}
					}
					break;
				case 'quote':
					$quote = isset( $media_meta['quote_text'] ) ? $media_meta['quote_text'] : '';
					$author_name = isset( $media_meta['author_name'] ) ? $media_meta['author_name'] : '';
					$author_status = isset( $media_meta['author_status'] ) ? $media_meta['author_status'] : '';		

					if ( !empty($thumbnail) ) {
						?>
						<div class="pic <?php echo !empty( $quote ) ? 'quote_post' : ''; ?>">
							<?php
							$src_img = ingenious_print_img_html(array('src' => $thumbnail), array( 'height' => $thumbnail_dims['height'], 'width' => $thumbnail_dims['width'], 'crop' => true ), $thumb_id );
							print "<img".$src_img." alt />";
							if ( !empty( $quote ) && !empty( $author_name )) {
								echo "<div class='hover-effect'></div>";
								echo "<div class='quote-wrap'>";
									echo "<div class='quote-cont'>";
										echo "<div class='quote'>";
											echo !empty($quote) ? "<p class='text'>".esc_html($quote)."</p>" : '';
											echo !empty($author_name) ? "<p class='author'>".esc_html($author_name)."</p>" : '';
											echo !empty($author_status) ? "<p class='author_position'>".esc_html($author_status)."</p>" : '';
										echo '</div>';
									echo '</div>';
								echo '</div>';
							}
							?>
						</div>
						<?php
						$thumb_media = true;
					} else {
						echo "<div class='quote-wrap'>";
							echo "<div class='quote-cont'>";
								echo "<div class='quote'>";
									echo !empty($quote) ? "<p class='text'>".esc_html($quote)."</p>" : '';
									echo !empty($author_name) ? "<p class='author'>".esc_html($author_name)."</p>" : '';
									echo !empty($author_status) ? "<p class='author_position'>".esc_html($author_status)."</p>" : '';
								echo '</div>';
							echo '</div>';
						echo '</div>';
					}					
					$some_media = true;
					break;
				case 'gallery':
					$gallery = isset( $media_meta[$post_format] ) ? $media_meta[$post_format] : "";
					if ( !empty( $gallery ) ) {
						$match = preg_match_all("/\d+/",$gallery,$images);
						if ($match){
							$images = $images[0];
							$image_srcs = array();
							foreach ( $images as $image ) {
								$image_src = wp_get_attachment_image_src($image,'full');
								$image_url['src'] = $image_src[0];
								$image_url['id'] = $image;
								array_push( $image_srcs, $image_url );
							}

							$thumb_media = $some_media = count( $image_srcs ) > 0 ? true : false;
							$carousel = count($image_srcs) > 1 ? true : false;
							$gallery_id = uniqid( 'cws-gallery-' );
							if ($carousel) {
								echo "<a class='gallery_post_carousel_nav carousel_nav prev'>
												<span></span>
												</a>
												<a class='gallery_post_carousel_nav carousel_nav next'>
												<span></span>
												</a>
												<div class='gallery_post_carousel'>";
							}
							foreach ( $image_srcs as $image_src ) {
								$img_obj = ingenious_thumb( $image_src['src'], $thumbnail_dims , $image_src['id'] );
								$img_url = isset( $img_obj[0] ) ? esc_url( $img_obj[0] ) : "";
								$retina_thumb_exists = false;
								$retina_thumb_url = "";
								if ( isset( $img_obj[3] ) ){
									extract( $img_obj[3] );
								}
								?>
								<div class='pic'>
									<?php
									if ( $retina_thumb_exists ) {
										echo "<img src='$img_url' data-at2x='$retina_thumb_url' alt />";
									}
									else{
										echo "<img src='$img_url' data-no-retina alt />";
									}
									?>
								</div>
								<?php
							}
							if ($carousel) {
								echo "</div>";
							}
						}
					}
					break;
			}
			if ( !$some_media && !empty( $thumbnail ) ) {
				$thumb_obj = ingenious_thumb( $thumbnail, $thumbnail_dims, $thumb_id );
				$thumb_url = isset( $thumb_obj[0] ) ? esc_url($thumb_obj[0]) : "";
				$retina_thumb_exists = false;
				$retina_thumb_url = "";	
				$retina_thumb_url = esc_attr($retina_thumb_url);
				echo "<div class='pic" . ( !$crop_thumb ? " wth_hover" : "" ) . "'>";
					if ( $retina_thumb_exists ) {
						echo "<img src='$thumb_url' data-at2x='$retina_thumb_url' alt />";
					}
					else{
						echo "<img src='$thumb_url' data-no-retina alt />";
					}
					if ( $crop_thumb ){
						echo "<div class='hover-effect'></div>";
					}
				echo "</div>";
				$thumb_media = true;
				$some_media = true;
			}
			?>
		</div>
	<?php
	$some_media ? ob_end_flush() : ob_end_clean();
	if ( $thumb_media ){
		wp_enqueue_script( 'fancybox' );
	}
	$GLOBALS['ingenious_single_post_floated_media'] = $thumb_media && !$crop_thumb;
}

function ingenious_post_posts_grid_post_content (){
	global $post;
	global $more;
	$id = get_the_ID();
	$permalink = get_the_permalink( $id );
	$more = 0;
	$is_rtl = is_rtl();
	$def_grid_atts = array(
					'post_hide_meta'		=> array(),
					'chars_count'			=> '',
				);
	$grid_atts = isset( $GLOBALS['ingenious_posts_grid_atts'] ) ? $GLOBALS['ingenious_posts_grid_atts'] : $def_grid_atts;	
	extract( $grid_atts );
	$chars_count = !empty( $chars_count ) ? $chars_count : ingenious_post_posts_grid_get_chars_count();
	$content = $proc_content = $excerpt = $proc_excerpt = "";
	$terms_hidden = in_array( 'terms', $post_hide_meta );	
	$content = $post->post_content;
	$excerpt = $post->post_excerpt;
	$read_more_exists = false;
	if ( !empty( $excerpt ) ){
		$proc_content = get_the_excerpt();
		$read_more_exists = !empty( $content );
	}
	else if ( strpos( (string) $content, '<!--more-->' ) ){
		$proc_content = get_the_content( "" );
		if (!empty($chars_count)) {
			$proc_content = trim( preg_replace( '/[\s]{2,}/u', ' ', strip_shortcodes( strip_tags( $proc_content ) ) ) );
			$chars_count = (int)$chars_count;
			$proc_content = mb_substr( $proc_content, 0, $chars_count );
		}
		$read_more_exists = true;
	}
	else if ( !empty( $content ) && !empty( $chars_count ) ){
		$proc_content = get_the_content( "" );
		$proc_content = trim( preg_replace( '/[\s]{2,}/u', ' ', strip_shortcodes( strip_tags( $proc_content ) ) ) );
		$chars_count = (int)$chars_count;
		$proc_content = mb_substr( $proc_content, 0, $chars_count );
		$read_more_exists = strlen( $proc_content ) < strlen( $content );
	}
	else{
		$proc_content = get_the_content( "" );		
	}
	echo "<div class='post_content post_post_content post_posts_grid_post_content'>";	
		echo apply_filters( 'the_content', $proc_content );
	echo "</div>";	
}
function ingenious_post_posts_grid_post_more() {
	global $post;
	global $more;
	$id = get_the_ID();
	$permalink = get_the_permalink( $id );
	$more = 0;
	$is_rtl = is_rtl();
	$def_grid_atts = array(
					'post_hide_meta'		=> array(),
					'chars_count'			=> '',
				);
	$grid_atts = isset( $GLOBALS['ingenious_posts_grid_atts'] ) ? $GLOBALS['ingenious_posts_grid_atts'] : $def_grid_atts;	
	extract( $grid_atts );
	$chars_count = !empty( $chars_count ) ? $chars_count : ingenious_post_posts_grid_get_chars_count();
	$content = $proc_content = $excerpt = $proc_excerpt = "";
	$terms_hidden = in_array( 'terms', $post_hide_meta );	
	$show_read_more = !in_array( 'read_more', $post_hide_meta );
	$content = $post->post_content;
	$excerpt = $post->post_excerpt;
	$read_more_exists = false;
	if ( !empty( $excerpt ) ){
		$read_more_exists = !empty( $content );
	}
	else if ( strpos( (string) $content, '<!--more-->' ) ){
		$read_more_exists = true;
	}
	else if ( !empty( $content ) && !empty( $chars_count ) ){
		$read_more_exists = strlen( $proc_content ) < strlen( $content );
	}
	if ($read_more_exists && $show_read_more) {
	 	echo "<a href='$permalink' class='more-link'>". esc_html__( "Read More", 'ingenious' ) ."</a>";
	}	
}
function ingenious_post_posts_grid_get_chars_count() {
	$def_blog_layout = ingenious_get_option( "def_blog_layout" );
	$def_grid_atts = array(
					'layout'	=> $def_blog_layout
				);
	$grid_atts = isset( $GLOBALS['ingenious_posts_grid_atts'] ) ? $GLOBALS['ingenious_posts_grid_atts'] : $def_grid_atts;	
	extract( $grid_atts );
	$number 	= NULL;
	$p_id 		= get_queried_object_id();
	$sb 		= ingenious_get_sidebars( $p_id );
	$sb_layout 	= isset( $sb['sb_layout_class'] ) ? $sb['sb_layout_class'] : '';
	switch ( $layout ) {
		case '1':
		case 'medium':
		case 'small':
		case 'checkerboard':
		case 'fw_img':
			switch ( $sb_layout ) {
				case 'double':
					$number = NULL;
					break;
				case 'single':
					$number = NULL;
					break;
				default:
					$number = NULL;
			}
			break;
		case '2':
			switch ( $sb_layout ) {
				case 'double':
					$number = 55;
					break;
				case 'single':
					$number = 90;
					break;
				default:
					$number = 130;
			}
			break;
		case '3':
			switch ( $sb_layout ) {
				case 'double':
					$number = 60;
					break;
				case 'single':
					$number = 60;
					break;
				default:
					$number = 70;
			}
			break;
	}
	return $number;
}



?>