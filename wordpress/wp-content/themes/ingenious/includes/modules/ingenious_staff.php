<?php

function ingenious_staff_posts_grid ( $atts = array(), $content = "" ){
	$out = "";
	$defaults = array(
		'title'									=> '',
		'title_align'							=> 'left',
		'post_type'								=> '',
		'total_items_count'						=> '',
		'layout'								=> 'def',
		'staff_hide_meta_override'				=> false,			
		'staff_data_to_hide'					=> '',
		'display_style'							=> 'grid',
		'select_filter'							=> '',
		'carousel_pagination'					=> '',
		'items_pp'								=>  esc_html( get_option( 'posts_per_page' ) ),
		'paged'									=> 1,
		'tax'									=> '',
		'terms'									=> '',
		'chars_count'							=> '',
		'addl_query_args'						=> array(),
		'el_class'								=> ''
	);
	$proc_atts = shortcode_atts( $defaults, $atts );
	extract( $proc_atts );
	$terms = isset( $atts[ $tax . "_terms" ] ) ? $atts[ $tax . "_terms" ] : "";
	$section_id = uniqid( 'staff_posts_grid_' );
	$ajax_data = array();
	$total_items_count = !empty( $total_items_count ) ? (int)$total_items_count : PHP_INT_MAX;
	$items_pp = !empty( $items_pp ) ? (int)$items_pp : esc_html( get_option( 'posts_per_page' ) );
	$paged = (int)$paged;
	$select_filter = (bool)$select_filter;
	$carousel_pagination = (bool)$carousel_pagination;

	$def_layout = ingenious_get_option( 'def_staff_layout' );
	$def_layout = isset( $def_layout ) ? $def_layout : "";
	$layout = ( empty( $layout ) || $layout === "def" ) ? $def_layout : $layout; 
	$staff_hide_meta_override = !empty( $staff_hide_meta_override ) ? true : false;
	$staff_data_to_hide = explode( ",", $staff_data_to_hide );
	$staff_def_data_to_hide = ingenious_get_option( 'def_staff_data_to_hide' );
	$staff_def_data_to_hide  = isset( $staff_def_data_to_hide ) ? $staff_def_data_to_hide : array();
	$staff_data_to_hide = $staff_hide_meta_override ? $staff_data_to_hide : $staff_def_data_to_hide;

	$el_class = esc_attr( $el_class );
	$sb = ingenious_get_sidebars();
	$sb_layout = isset( $sb['sb_layout_class'] ) ? $sb['sb_layout_class'] : '';	

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
	$not_in = (1 == $paged) ? array() : get_option( 'sticky_posts' );
	$query_args = array('post_type'			=> 'cwsstaff',
						'post_status'		=> 'publish',
						'post__not_in'		=> $not_in
						);
	if ( in_array( $display_style, array( 'grid', 'filter' ) ) ){
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
	$query_args['orderby'] 	= "menu_order date title";
	$query_args['order']	= "ASC";
	$query_args = array_merge( $query_args, $addl_query_args );
	$q = new WP_Query( $query_args );
	$found_posts = $q->found_posts;
	$requested_posts = $found_posts > $total_items_count ? $total_items_count : $found_posts;
	$max_paged = $found_posts > $total_items_count ? ceil( $total_items_count / $items_pp ) : ceil( $found_posts / $items_pp );
	$cols = in_array( $layout, array( 'medium', 'small' ) ) ? 1 : (int)$layout;
	$is_carousel = $display_style == 'carousel' && $requested_posts > $cols;
	wp_enqueue_script( 'fancybox' );
	$is_filter = in_array( $display_style, array( 'filter' ) ) && !empty( $terms ) ? true : false;
	$filter_vals = array();
	$use_pagination = in_array( $display_style, array( 'grid', 'filter' ) ) && $max_paged > 1;
	$pagination_type = "pagination";
	if ( !$is_filter && in_array( $layout, array( '2', '3', '4' ) ) ){
		$pagination_type = "load_more";
	}
	$dynamic_content = $is_filter || $use_pagination;
	if ( $is_carousel ){
		wp_enqueue_script( 'owl_carousel' );
	}
	else if ( in_array( $layout, array( "2", "3", "4" ) ) || $dynamic_content ){
		wp_enqueue_script( 'isotope' );
	}
	if ( $dynamic_content || is_single() || is_archive()){
		wp_enqueue_script( 'owl_carousel' ); // for dynamically loaded gallery posts
		wp_enqueue_script( 'imagesloaded' );
	}
	ob_start ();
	$filter = $select_filter ? " select_filter" : " simple_filter";
	$classes = $carousel_pagination ? " carousel_pagination" : "";
	echo "<section id='$section_id' class='posts_grid staff_posts_grid posts_grid_{$layout} posts_grid_{$display_style}" . ( $dynamic_content ? " dynamic_content" : "" ) . ( !empty( $el_class ) ? " $el_class" : "" ) . $filter . " '>";
		if ( $is_carousel ){
			echo "<div class='widget_header clearfix'>";
				echo !empty( $title ) ? "<h2 class='widgettitle'>" . esc_html( $title ) . "</h2>" : "";		
				if ( !$carousel_pagination ) {
					echo "<div class='carousel_nav'>";
						echo "<span class='prev'>";
						echo "</span>";
						echo "<span class='next'>";
						echo "</span>";
					echo "</div>";	
				}		
				
			echo "</div>";			
		}
		else if ( $is_filter && count( $terms ) > 1 ){
			foreach ( $terms as $term ) {
				if ( empty( $term ) ) continue;
				$term_obj = get_term_by( 'slug', $term, $tax );
				if ( empty( $term_obj ) ) continue;
				$term_name = $term_obj->name;
				$filter_vals[$term] = $term_name;
			}
			if ( $filter_vals > 1 ){
				echo !empty( $title ) ? "<h2 class='widgettitle'>" . esc_html( $title ) . "</h2>" : "";
				echo "<ul class='filter_wrap'>";
					echo "<li data-filter='_all_' class='filter active'>All</li>";
					foreach ( $filter_vals as $term_slug => $term_name ){
						echo "<li data-filter='" . esc_html( $term_slug ) . "' class='filter'>" . esc_html( $term_name ) . "</li>";
					}
				echo "</ul>";
				echo "<select class='filter'>";
					echo "<option value='_all_' selected>" . esc_html__( 'All', 'ingenious' ) . "</option>";
					foreach ( $filter_vals as $term_slug => $term_name ){
						echo "<option value='" . esc_html( $term_slug ) . "'>" . esc_html( $term_name ) . "</option>";
					}
				echo "</select>";
			}
			else{
				echo !empty( $title ) ? "<h2 class='widgettitle text_align{$title_align}'>" . esc_html( $title ) . "</h2>" : "";				
			}
		}
		else{
			echo !empty( $title ) ? "<h2 class='widgettitle text_align{$title_align}'>" . esc_html( $title ) . "</h2>" : "";
		}
		echo "<div class='ingenious_wrapper'>";
			echo "<div class='" . ( $is_carousel ? "ingenious_carousel" : "ingenious_grid" . ( ( in_array( $layout, array( "2", "3", "4" ) ) || $dynamic_content ) ? " isotope" : "" ) ) . $classes .  "'" . ( $is_carousel ? " data-cols='" . ( !is_numeric( $layout ) ? "1" : $layout ) . "'" : "" ) . ">";
				$GLOBALS['ingenious_staff_grid_atts'] = array(
					'post_type'						=> 'cwsstaff',
					'layout'						=> $layout,
					'sb_layout'						=> $sb_layout,
					'staff_data_to_hide'			=> $staff_data_to_hide,
					'total_items_count'				=> $total_items_count,
					'chars_count'					=> $chars_count,
					);
				if ( function_exists( "ingenious_staff_posts_grid_posts" ) ){
					call_user_func_array( "ingenious_staff_posts_grid_posts", array( $q ) );
				}
				unset( $GLOBALS['ingenious_staff_grid_atts'] );
			echo "</div>";
			if ( $dynamic_content ){
				ingenious_loader_html();
			}
		echo "</div>";
		if ( $use_pagination ){
			if ( $pagination_type == 'load_more' ){
				ingenious_load_more ();
			}
			else{
				ingenious_pagination ( $paged, $max_paged );
			}
		}
		if ( $dynamic_content ){
			$ajax_data['section_id']						= $section_id;
			$ajax_data['post_type']							= 'cwsstaff';
			$ajax_data['staff_data_to_hide']				= $staff_data_to_hide;
			$ajax_data['layout']							= $layout;
			$ajax_data['chars_count']						= $chars_count;
			$ajax_data['sb_layout']							= $sb_layout;
			$ajax_data['total_items_count']					= $total_items_count;
			$ajax_data['items_pp']							= $items_pp;
			$ajax_data['page']								= $paged;
			$ajax_data['max_paged']							= $max_paged;
			$ajax_data['tax']								= $tax;
			$ajax_data['terms']								= $terms;
			$ajax_data['filter']							= $is_filter;
			$ajax_data['current_filter_val']				= '_all_';
			$ajax_data['addl_query_args']					= $addl_query_args;
			$ajax_data_str = json_encode( $ajax_data );
			echo "<form id='{$section_id}_data' class='posts_grid_data'>";
				echo "<input type='hidden' id='{$section_id}_ajax_data' class='posts_grid_ajax_data' name='{$section_id}_ajax_data' value='$ajax_data_str' />";
			echo "</form>";
		}
	echo "</section>";
	$out = ob_get_clean();
	return $out;
}

function ingenious_staff_posts_grid_posts ( $q = null ){
	if ( !isset( $q ) ) return;
	$def_grid_atts = array(
					'layout'						=> '1',
					'staff_data_to_hide'			=> array(),
					'total_items_count'				=> PHP_INT_MAX
				);
	$grid_atts = isset( $GLOBALS['ingenious_staff_grid_atts'] ) ? $GLOBALS['ingenious_staff_grid_atts'] : $def_grid_atts;
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
			ingenious_staff_posts_grid_post ();
		endwhile;
		wp_reset_postdata();
		ob_end_flush();
	endif;		
}

function ingenious_get_staff_thumbnail_dims ( $real_dims = array() ) {
	$def_grid_atts = array(
		'layout'				=> '1',
		'sb_layout'				=> '',
	);
	$def_single_atts = array(
		'sb_layout'				=> '',
	);
	$grid_atts = isset( $GLOBALS['ingenious_staff_grid_atts'] ) ? $GLOBALS['ingenious_staff_grid_atts'] : $def_grid_atts;
	$single_atts = isset( $GLOBALS['ingenious_single_post_atts'] ) ? $GLOBALS['ingenious_single_post_atts'] : $def_single_atts;

	$single = is_single();
	$resolution = 1170;
	if ( $single ){
		extract( $single_atts );
	}
	else{
		extract( $grid_atts );
	}
	$dims = array( 'width' => null, 'height' => null , 'crop' => true);
	if ($single){
		if ( ( empty( $real_dims ) || ( isset( $real_dims['width'] ) && $real_dims['width'] > 1170 ) ) ) {
			$dims['width']	= 1170;
		}
	}
	else{
		$dims['width'] = ($resolution / (int) $layout);
	}

	return $dims;
}

function ingenious_staff_posts_grid_post (){
	$def_grid_atts = array(
					'layout'				=> '1',
					'staff_data_to_hide'	=> array(),
				);
	$grid_atts = isset( $GLOBALS['ingenious_staff_grid_atts'] ) ? $GLOBALS['ingenious_staff_grid_atts'] : $def_grid_atts;
	extract( $grid_atts );
	$pid = get_the_id();
	$item_id = uniqid( "staff_post_" );
	$post_meta = get_post_meta( $pid, 'cws_mb_post' );
	$post_meta = isset( $post_meta[0] ) ? $post_meta[0] : array();
	echo "<article id='$item_id' data-pid='$pid' class='item staff_post'>";
		ingenious_staff_posts_grid_post_media ();
		echo "<div class='ingenious_staff_posts_grid_post_data'>";
			ob_start();
			ingenious_staff_posts_grid_post_title ();
			if ( !in_array( 'department', $staff_data_to_hide ) ) {
				echo "<div class='post_terms staff_post_terms'>";
					echo ingenious_get_post_term_links_str( 'staff_member_department' );
				echo "</div>";	
			}
			if ( !in_array( 'position', $staff_data_to_hide ) ) {
				echo "<div class='post_terms staff_post_terms'>";
					echo ingenious_get_post_term_links_str( 'staff_member_position' );
				echo "</div>";	
			}	
			$title_terms = ob_get_clean();
			echo sprintf("%s", $title_terms);
		echo "</div>";
	echo "</article>";
}
function ingenious_staff_posts_grid_post_media (){
	$pid = get_the_id();
	$def_grid_atts = array(
					'layout'					=> '1',
					'staff_data_to_hide'		=> array(),
				);
	$grid_atts = isset( $GLOBALS['ingenious_staff_grid_atts'] ) ? $GLOBALS['ingenious_staff_grid_atts'] : $def_grid_atts;	
	extract( $grid_atts );
	$post_url = esc_url(get_the_permalink());
	$post_meta = get_post_meta( $pid, 'cws_mb_post' );
	$post_meta = isset( $post_meta[0] ) ? $post_meta[0] : array();
	$thumbnail_props = has_post_thumbnail() ? wp_get_attachment_image_src(get_post_thumbnail_id( ),'full') : array();
	$thumbnail_id = get_post_thumbnail_id();
	$thumbnail = !empty( $thumbnail_props ) ? $thumbnail_props[0] : '';
	$thumbnail_dims = ingenious_get_staff_thumbnail_dims();
	$thumb_obj = ingenious_thumb( $thumbnail, $thumbnail_dims, $thumbnail_id );
	$thumb_url = isset( $thumb_obj[0] ) ? esc_url($thumb_obj[0]) : "";
	$thumb_url_retina = isset( $thumb_obj[3] ) ? esc_url($thumb_obj[3]) : "";
	$thumb_url_retina = $thumb_url_retina == null ? "data-no-retina" : "data-at2x='$thumb_url_retina'";
	$clickable = isset( $post_meta['is_clickable'] ) ? $post_meta['is_clickable']: false;
	if ( !empty( $thumb_url ) ){
		echo "<div class='post_media staff_post_media'>";
			echo "<div class='staff_photo'>";
				echo "<img src='$thumb_url' $thumb_url_retina alt />";
			echo "</div>";
			if (!in_array( 'content', $staff_data_to_hide) && !in_array( 'soc_icons', $staff_data_to_hide)) {
				echo "<div class='staff_hover_content'>";
					if (!in_array( 'content', $staff_data_to_hide)) {
						ingenious_staff_posts_grid_post_content ();
					}
					if (!in_array( 'soc_icons', $staff_data_to_hide)) {
						ingenious_staff_posts_grid_social_links ();
					}	
				echo "</div>";
			}
		echo "</div>";
	}		
}
function ingenious_staff_posts_grid_post_title (){
	$pid = get_the_id();
	$permalink = get_the_permalink( $pid );
	$title = get_the_title();
	echo !empty( $title ) ?	"<a href='$permalink'><h3 class='staff_post_title'>$title</h3></a>" : "";	
}
function ingenious_get_staff_chars_count ( $cols = null ){
	switch ( $cols ){
		case '1':
			$number = 300;
			break;
		case '2':
			$number = 130;
			break;
		case '3':
			$number = 110;
			break;
		case '4':
			$number = 100;
			break;
	}
	return $number;
}
function ingenious_staff_posts_grid_post_content (){
	$def_grid_atts = array(
					'layout'					=> '1',
					'chars_count'				=> '125',
				);
	$grid_atts = isset( $GLOBALS['ingenious_staff_grid_atts'] ) ? $GLOBALS['ingenious_staff_grid_atts'] : $def_grid_atts;	
	extract( $grid_atts );
	$pid = get_the_id();
	$post = get_post( $pid );
	$post_content =  apply_filters( 'the_content', $post->post_content );
	$post_content = !empty( $post->post_excerpt ) ? $post->post_excerpt : $post->post_content;
	$chars_count = !empty($chars_count) ? $chars_count : ingenious_get_staff_chars_count( $layout );
	$post_content = trim( preg_replace( "/[\s]{2,}/", " ", strip_shortcodes( strip_tags( $post_content ) ) ) );
	$post_content = wptexturize( $post_content );
	$post_content = substr( $post_content, 0, $chars_count );
	if ( !empty( $post_content ) ){
		echo "<div class='post_content staff_post_content'>";
			echo sprintf("%s", $post_content);
		echo "</div>";
	}
}
function ingenious_staff_posts_grid_social_links (){
	$pid = get_the_id();
	$post_meta = get_post_meta( $pid, 'cws_mb_post' );
	$post_meta = isset( $post_meta[0] ) ? $post_meta[0] : array();
	$social_group = isset( $post_meta['social_group'] ) ? $post_meta['social_group']: array();
	$icons = "";
	foreach ( $social_group as $social ) {
		$title = isset( $social['title'] ) ? $social['title'] : "";
		$icon = isset( $social['icon'] ) ? $social['icon'] : "";
		$url = isset( $social['url'] ) ? $social['url'] : "";
		if ( !empty( $icon ) && !empty( $url ) ){
			$icons .= "<a href='$url' target='_blank' class='{$icon}'" . ( !empty( $title ) ? " title='$title'" : "" ) . "></a>";
		}
	}
	if ( !empty( $icons ) ){
		echo "<div class='post_social_links staff_social_links'>";
			echo sprintf("%s", $icons);	
		echo "</div>";
	}
}
function ingenious_staff_single_post_title (){
	$title = get_the_title();
	echo !empty( $title ) ?	"<h3 class='staff_post_title'>$title</h3>" : "";	
}
function ingenious_staff_single_social_links (){
	$pid = get_the_id();
	$post_meta = get_post_meta( $pid, 'cws_mb_post' );
	$post_meta = isset( $post_meta[0] ) ? $post_meta[0] : array();
	$social_group = isset( $post_meta['social_group'] ) ? $post_meta['social_group']: array();
	$icons = "";
	foreach ( $social_group as $social ) {
		$title = isset( $social['title'] ) ? $social['title'] : "";
		$icon = isset( $social['icon'] ) ? $social['icon'] : "";
		$url = isset( $social['url'] ) ? $social['url'] : "";
		if ( !empty( $icon ) && !empty( $url ) ){
			$icons .= "<a href='$url' target='_blank' class='{$icon}'" . ( !empty( $title ) ? " title='$title'" : "" ) . "></a>";
		}
	}
	if ( !empty( $icons ) ){
		echo "<div class='post_social_links staff_social_links single_social_links'>";
			echo sprintf("%s", $icons);		
		echo "</div>";
	}	
}

function ingenious_staff_single_post_media (){
	$pid = get_the_id();
	$post_meta = get_post_meta( $pid, 'cws_mb_post' );
	$post_meta = isset( $post_meta[0] ) ? $post_meta[0] : array();
	$thumbnail_props = has_post_thumbnail() ? wp_get_attachment_image_src(get_post_thumbnail_id( ),'full') : array();
	$thumbnail = !empty( $thumbnail_props ) ? $thumbnail_props[0] : '';
	$thumbnail_id = get_post_thumbnail_id();
	$thumbnail_dims = ingenious_get_staff_thumbnail_dims();
	$thumb_obj = ingenious_thumb( $thumbnail, $thumbnail_dims, $thumbnail_id );
	$thumb_url = isset( $thumb_obj[0] ) ? esc_url($thumb_obj[0]) : "";
	$thumb_url_retina = isset( $thumb_obj[3] ) ? esc_url($thumb_obj[3]) : "";
	$thumb_url_retina = $thumb_url_retina == null ? "data-no-retina" : "data-at2x='$thumb_url_retina'";
	if ( !empty( $thumb_url ) ){
		echo "<div class='post_media staff_post_media single_post_media'>";
			echo "<div class='staff_photo'>";
				echo "<img src='$thumb_url' $thumb_url_retina alt />";
			echo "</div>";
			ingenious_staff_single_social_links ();
		echo "</div>";
	}	
}

function ingenious_staff_single_post_content (){
	$pid = get_the_id();
	$post = get_post( $pid );
	$post_content =  apply_filters( 'the_content', $post->post_content );
	if ( !empty( $post_content ) ){
		echo "<div class='post_content single_post_content staff_post_content'>";
			echo sprintf("%s", $post_content);	
		echo "</div>";
	}
}

?>