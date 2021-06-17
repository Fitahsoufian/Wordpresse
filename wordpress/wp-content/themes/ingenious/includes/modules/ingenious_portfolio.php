<?php

function ingenious_portfolio_posts_grid ( $atts = array(), $content = "" ){
	$out = "";
	$defaults = array(
		'title'									=> '',
		'title_align'							=> 'left',
		'info_pos'								=> 'inside_img',
		'total_items_count'						=> '',
		'layout'								=> 'def',
		'hex_layout'							=> '4',
		'anim_style'							=> 'hoverdef',
		'start_style'							=> 'start_even',
		'en_hover_color'						=> false,
		'en_title_color'						=> false,
		'en_cat_color'							=> false,
		'masonry'								=> false,
		'crop_img'								=> false,
		'title_divider'							=> false,
		'portfolio_show_data_override'			=> false,
		'full_width'							=> false,
		'item_shadow'							=> false,
		'en_isotope'							=> false,
		'carousel_auto'							=> false,
		'en_icon_color'							=> false,
		'hover_color'							=> 'rgba(0,0,0,0.7)',
		'pag_type'								=> 'load_pag',
		'info_align'							=> 'center',
		'title_color'							=> '#fff',
		'cat_color'								=> '#fff',
		'icon_color'							=> '#363636',
		'icon_bg_color'							=> '#fff',
		'portfolio_data_to_show'				=> '',
		'appear_style'							=> 'none',
		'portfolio_style'						=> '',
		'chars_count'							=> '',
		'display_style'							=> 'grid',
		'hex_display_style'						=> '',
		'link_show'								=> 'popup_link',
		'area_link'								=> true,
		'carousel_pagination'					=> '',
		'carousel_pagination_hex'				=> '',
		'items_pp'								=>  esc_html( get_option( 'posts_per_page' ) ),
		'paged'									=> 1,
		'tax'									=> '',
		'titles'								=> '',
		'addl_query_args'						=> array(),
		'el_class'								=> ''
	);
	$proc_atts = shortcode_atts( $defaults, $atts );
	if( isset( $GLOBALS['ingenious_row_fw_atts'] ) ) {
		$shot = $GLOBALS['ingenious_row_fw_atts'];
	} else {
		return;
	}
	extract( $proc_atts );
	extract($shot);
	$terms = isset( $atts[ $tax . "_terms" ] ) ? $atts[ $tax . "_terms" ] : "";
	$titles = !empty($titles) ? explode( ',', $titles ) : null;
	if ( $tax == 'title' && !empty( $titles ) ) {
		$items_pp = count( $titles );
	}
	$portfolio_style = esc_html($portfolio_style);
	$display_style = esc_html($display_style);
	$anim_style = esc_html($anim_style);
	$portfolio_fig_style = !empty($portfolio_fig_style) ? $portfolio_fig_style : '';
	switch ($display_style) {
		case 'hex_style':
			$portfolio_fig_style = 'hex_style';
			break;
		case 'hex_style_2':
			$portfolio_fig_style = 'hex_style_2';
			break;
	}
	$pid = get_the_id();
	$p_meta = get_post_meta( $pid, 'cws_mb_post' );
	$p_meta = isset( $p_meta[0] ) ? $p_meta[0] : array();
	$section_id = uniqid( 'portfolio_posts_grid_' );
	$ajax_data = array();
	$total_items_count = !empty( $total_items_count ) ? (int)$total_items_count : PHP_INT_MAX;
	$items_pp = !empty( $items_pp ) ? (int)$items_pp : esc_html( get_option( 'posts_per_page' ) );
	$paged = (int)$paged;
	$masonry = (bool)$masonry;

	$carousel_pagination = ($carousel_pagination == '1' || $carousel_pagination_hex == '1') ? true : false;
	$def_layout = ingenious_get_option( 'def_portfolio_layout' );
	$def_layout = isset( $def_layout ) ? $def_layout : "";
	if ($portfolio_fig_style) {
		$layout = $hex_layout;
	}
	$layout = ( empty( $layout ) || $layout === "def" ) ? $def_layout : $layout; 
	$portfolio_show_data_override = !empty( $portfolio_show_data_override ) ? true : false;
	$portfolio_data_to_show = explode( ",", $portfolio_data_to_show );
	$portfolio_def_data_to_show = ingenious_get_option( 'def_portfolio_data_to_show' );
	$portfolio_def_data_to_show  = isset( $portfolio_def_data_to_show ) ? $portfolio_def_data_to_show : array();
	$portfolio_data_to_show = $portfolio_show_data_override ? $portfolio_data_to_show : $portfolio_def_data_to_show;

	$el_class = esc_attr( $el_class );
	$sb = ingenious_get_sidebars();
	$sb_layout = isset( $sb['sb_layout_class'] ) ? $sb['sb_layout_class'] : '';	

	$terms = explode( ",", $terms );
	$terms_temp = array();
	foreach ( $terms as $term ) {
		if ( !empty( $term ) ){
			if(strrpos($term, ') ')){
				$term = str_replace(substr($term, 0, strrpos($term, ') ') + 2), "", $term); 
			}
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
	$query_args = array('post_type'			=> 'cwsportfolio',
						'post_status'		=> 'publish',
						'post__not_in'		=> $not_in
						);
	if ( in_array( $display_style, array( 'grid', 'filter' ) ) || in_array( $hex_display_style, array( 'grid', 'filter' ) ) ){
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
	$query_args['orderby'] 	= "menu_order date title";
	$query_args['order']	= "ASC";
	$query_args = array_merge( $query_args, $addl_query_args );
	$q = new WP_Query( $query_args );
	$found_posts = $q->found_posts;
	$requested_posts = $found_posts > $total_items_count ? $total_items_count : $found_posts;
	$max_paged = $found_posts > $total_items_count ? ceil( $total_items_count / $items_pp ) : ceil( $found_posts / $items_pp );
	$cols = in_array( $layout, array( 'medium', 'small' ) ) ? 1 : (int)$layout;
	if ( $display_style == 'hex_style' || $display_style == 'hex_style_2' ) {
		$is_carousel = $hex_display_style == 'carousel' && $requested_posts > $cols;
	} else {
		$is_carousel = $display_style == 'carousel' && $requested_posts > $cols;
	}
	wp_enqueue_script( 'fancybox' );
	if ( $display_style == 'hex_style' || $display_style == 'hex_style_2' ) {
		$is_filter = in_array( $hex_display_style, array( 'filter' ) ) && !empty( $terms ) ? true : false;
	} else {
		$is_filter = in_array( $display_style, array( 'filter' ) ) && !empty( $terms ) ? true : false;
	}
	if ($is_filter) {
		wp_enqueue_script( 'lavalamp' );
	}
	$filter_vals = array();
	if ( $display_style == 'hex_style' || $display_style == 'hex_style_2' ) {
		$use_pagination = in_array( $hex_display_style, array( 'grid', 'filter' ) ) && $max_paged > 1;
	} else {
		$use_pagination = in_array( $display_style, array( 'grid', 'filter' ) ) && $max_paged > 1;
	}
	$dynamic_content = $is_filter || $use_pagination;
	if ( $is_carousel ){
		wp_enqueue_script( 'owl_carousel' );
	}
	else if ( in_array( $layout, array( "2", "3", "4", "5" ) ) || $dynamic_content ){
		wp_enqueue_script( 'isotope' );
	}
	if ( $dynamic_content || is_single() || is_archive()){
		wp_enqueue_script( 'owl_carousel' ); // for dynamically loaded gallery posts
		wp_enqueue_script( 'imagesloaded' );
	}
	if ($full_width == 'stretch_row_content' || $full_width == 'stretch_row_content_no_spaces') {
		$full_width = true;
	} 
	$post_url = esc_url(get_the_permalink());
	$thumbnail_props = has_post_thumbnail() ? wp_get_attachment_image_src(get_post_thumbnail_id( ),'full') : array();
	$thumbnail = !empty( $thumbnail_props ) ? $thumbnail_props[0] : '';
	$real_thumbnail_dims = array();
	if ( !empty( $thumbnail_props ) && isset( $thumbnail_props[1] ) ) $real_thumbnail_dims['width'] = $thumbnail_props[1];
	if ( !empty(  $thumbnail_props ) && isset( $thumbnail_props[2] ) ) $real_thumbnail_dims['height'] = $thumbnail_props[2];
	$isotope = array('masonry' => $masonry , 'columns' => $layout, 'portfolio_style' => $portfolio_style );
	if ($isotope['masonry']){
		$thumbnail_dims = ingenious_get_portfolio_thumbnail_dims( false, $real_thumbnail_dims );
		extract(ingenious_portfolio_masonry($thumbnail, $thumbnail_dims, $p_meta, $isotope));
	}
	$isotope_line_count = !empty($isotope_line_count) ? $isotope_line_count : '';
	$isotope_col_count = !empty($isotope_col_count) ? $isotope_col_count : '';
	$hex_w = '';
	$hex_h = '';
	switch ($display_style) {
		case 'hex_style':
			$portfolio_fig_style = ' hex_style';
			switch ($hex_layout) {
				case '3':
					$hex_w = '380';
					$hex_h = '430';
					break;
				case '4':
					$hex_w = '280';
					$hex_h = '310';
					break;
				case '5':
					$hex_w = '220';
					$hex_h = '245';
					break;
			}
			break;
		case 'hex_style_2':
			$portfolio_fig_style = ' hex_style_2';
			switch ($hex_layout) {
				case '3':
					$hex_w = '450';
					$hex_h = '400';
					break;
				case '4':
					$hex_w = '340';
					$hex_h = '300';
					break;
				case '5':
					$hex_w = '270';
					$hex_h = '245';
					break;
			}
			break;
	}
	ob_start ();

	$classes = $classes_add = '';
	$classes .= $carousel_pagination ? " carousel_pagination" : " carousel_nav";
	$classes .= $carousel_auto ? " carousel_auto" : "";
	$classes_add .= $portfolio_fig_style ? " hexagon_grid" : "";
	$classes_add .= $full_width ? " full_width_style" : "";
	$classes_add .= $portfolio_style == "wide_style" ? " wide_style" : "";
	$classes_add .= !empty($start_style) ? " " . "$start_style" : "";
	$classes_add .= $appear_style !== 'none' ? " appear_style" : "";
	$classes_add .= $carousel_pagination ? " carousel_pagination" : " carousel_nav";
	$en_isotope = !empty($en_isotope) ? $en_isotope : '';
	if ($portfolio_fig_style) {
		$isotope_style = "";
	} else if ($masonry == '1') {
		$isotope_style = " isotope masonry";
	} else if ($dynamic_content) {
		$isotope_style = " isotope";
	} else if ($en_isotope) {
		$isotope_style = " isotope";
	} else {
		$isotope_style = "";
	}
	$layout_cl = "";
	if ($display_style == "showcase") {
		$layout = "";
	} else {
		$layout_cl = "posts_grid_{$layout}";
	}

	$en_hover_color = (bool)$en_hover_color;
	$hover_color = $en_hover_color ? esc_html($hover_color) : '';
	$en_title_color = (bool)$en_title_color;
	$en_icon_color = (bool)$en_icon_color;
	$title_color = $en_title_color ? esc_html($title_color) : '';
	$en_cat_color = (bool)$en_cat_color;
	$cat_color = $en_cat_color ? esc_html($cat_color) : '';
	ob_start();	
	if ($en_hover_color) {
		echo "#{$section_id} .portfolio_content_wrap {
			background: $hover_color;
		}";
	}
	if ($en_title_color) {
		echo "#{$section_id} .portfolio_post_title a,
		#{$section_id} .gallery_post_carousel_nav,
		#{$section_id} .links.video,
		#{$section_id} .post_content{
			color: $title_color;
		}
		#{$section_id} .portfolio_item_post.under_img .portfolio_post_title:before{
			background: $title_color;
		}
		#{$section_id} .portfolio_item_post.hoverbi .hover-effect:before, 
		#{$section_id} .portfolio_item_post.hoverbi2 .hover-effect:before, 
		#{$section_id} .portfolio_item_post.hoverbi2 .hover-effect:after{
			border-color: $title_color;
		}";
	if ($en_cat_color) {
		echo "#{$section_id} .post_terms,
		#{$section_id} .post_terms a{
			color: $cat_color;
		}";
	}
	}
	if ($en_icon_color) {
		echo "#{$section_id} .links_wrap a{
			color: $icon_color;
		}
		#{$section_id}.portfolio_item_post .links_wrap .links .icon_shape svg{
			background: $icon_bg_color;
		}";
	}
	$styles = ob_get_clean();
	$styles = json_encode($styles);
	$grid_num = $layout_cl;
	$grid_num = preg_replace("/[^0-9]/", '', $grid_num);

	if (!empty($appear_style) && $appear_style !== 'none') {
		wp_enqueue_script('velocity', INGENIOUS_THEME_URI . '/js/velocity.min.js', '', true);
		wp_enqueue_script('velocity_ui', INGENIOUS_THEME_URI . '/js/velocity.ui.min.js', '', true);
	}
	echo "<section id='$section_id' class='posts_grid portfolio_posts_grid simple_filter $layout_cl posts_grid_{$display_style}" . ( $dynamic_content ? " dynamic_content" : "" ) . ( !empty( $el_class ) ? " $el_class" : "" ) . $classes_add . " render_styles ' data-style='".esc_attr($styles)."' " . (!empty($grid_num) ? "data-col='$grid_num'" : '') . ">";
		if ( $is_carousel && !empty($title) ){
			echo "<div class='widget_header clearfix'>";
				echo !empty( $title ) ? "<h2 class='widgettitle " . ($carousel_pagination ? "text_align{$title_align}" : '') . "'>" . esc_html( $title ) . "</h2>" : "";		
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
				echo !empty( $title ) ? "<h2 class='widgettitle text_align{$title_align}'>" . esc_html( $title ) . "</h2>" : "";
				echo "<ul class='filter_wrap'>";
					echo "<li data-filter='_all_' class='filter active'><h5>All</h5></li>";
					foreach ( $filter_vals as $term_slug => $term_name ){
						echo "<li data-filter='" . esc_html( $term_slug ) . "' class='filter'><h5>" . esc_html( $term_name ) . "</h5></li>";
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
			echo "<div class='" . ( $is_carousel ? "ingenious_carousel" : "ingenious_grid" . ( ( in_array( $layout, array( "2", "3", "4", "5" ) ) || $dynamic_content ) ? $isotope_style : "" ) ) . $classes .  "'" . ( $is_carousel ? " data-cols='" . ( !is_numeric( $layout ) ? "1" : $layout ) . "'" : "" ) . ">";
				if (!$portfolio_fig_style && !$is_carousel && $masonry) {
					echo "<div class='grid-size'></div>";
				}
				$GLOBALS['ingenious_posts_grid_atts'] = array(
					'post_type'						=> 'cwsportfolio',
					'layout'						=> $layout,
					'hex_layout'					=> $hex_layout,
					'hex_w'							=> $hex_w,
					'hex_h'							=> $hex_h,
					'info_align'					=> $info_align,
					'start_style'					=> $start_style,
					'display_style'					=> $display_style,
					'hex_display_style'				=> $hex_display_style,
					'sb_layout'						=> $sb_layout,
					'portfolio_data_to_show'		=> $portfolio_data_to_show,
					'portfolio_style'				=> $portfolio_style,
					'total_items_count'				=> $total_items_count,
					'info_pos'						=> $info_pos,
					'masonry'						=> $masonry,
					'crop_img'						=> $crop_img,
					'title_divider'					=> $title_divider,
					'full_width'					=> $full_width,
					'anim_style'					=> $anim_style,
					'item_shadow'					=> $item_shadow,
					'en_hover_color'				=> $en_hover_color,
					'en_cat_color'					=> $en_cat_color,
					'hover_color'					=> $hover_color,
					'title_color'					=> $title_color,
					'cat_color'						=> $cat_color,
					'appear_style'					=> $appear_style,
					'link_show'						=> $link_show,
					'area_link'						=> $area_link,
					'isotope_line_count'			=> $isotope_line_count,
					'isotope_col_count'				=> $isotope_col_count,
					'chars_count'					=> $chars_count,
					);
				if ( function_exists( "ingenious_portfolio_posts_grid_posts" ) ){
					call_user_func_array( "ingenious_portfolio_posts_grid_posts", array( $q ) );
				}
				unset( $GLOBALS['ingenious_posts_grid_atts'] );
			echo "</div>";
			if ( $dynamic_content ){
				ingenious_loader_html();
			}
		echo "</div>";
		if ( $use_pagination ){
			if ( $pag_type == 'load_pag' ){
				ingenious_load_more ();
			}
			else if ( $pag_type == 'num_pag' ){
				ingenious_pagination ( $paged, $max_paged );
			}
		}
		if ( $dynamic_content ){
			$ajax_data['section_id']						= $section_id;
			$ajax_data['post_type']							= 'cwsportfolio';
			$ajax_data['portfolio_data_to_show']			= $portfolio_data_to_show;
			$ajax_data['link_show']							= $link_show;
			$ajax_data['area_link']							= $area_link;
			$ajax_data['layout']							= $layout;
			$ajax_data['hex_layout']						= $hex_layout;
			$ajax_data['hex_w']								= $hex_w;
			$ajax_data['hex_h']								= $hex_h;
			$ajax_data['start_style']						= $start_style;
			$ajax_data['display_style']						= $display_style;
			$ajax_data['hex_display_style']					= $hex_display_style;
			$ajax_data['sb_layout']							= $sb_layout;
			$ajax_data['total_items_count']					= $total_items_count;
			$ajax_data['full_width']						= $full_width;
			$ajax_data['items_pp']							= $items_pp;
			$ajax_data['page']								= $paged;
			$ajax_data['max_paged']							= $max_paged;
			$ajax_data['tax']								= $tax;
			$ajax_data['terms']								= $terms;
			$ajax_data['filter']							= $is_filter;
			$ajax_data['current_filter_val']				= '_all_';
			$ajax_data['addl_query_args']					= $addl_query_args;
			$ajax_data['portfolio_style']					= $portfolio_style;
			$ajax_data['info_pos']							= $info_pos;
			$ajax_data['masonry']							= $masonry;
			$ajax_data['crop_img']							= $crop_img;
			$ajax_data['title_divider']						= $title_divider;
			$ajax_data['anim_style']						= $anim_style;
			$ajax_data['item_shadow']						= $item_shadow;
			$ajax_data['appear_style']						= $appear_style;
			$ajax_data['isotope_line_count']				= $isotope_line_count;
			$ajax_data['isotope_col_count']					= $isotope_col_count;
			$ajax_data['chars_count']						= $chars_count;
			$ajax_data['info_align']						= $info_align;
			$ajax_data['pag_type']							= $pag_type;
			$ajax_data_str = json_encode( $ajax_data );
			echo "<form id='{$section_id}_data' class='posts_grid_data'>";
				echo "<input type='hidden' id='{$section_id}_ajax_data' class='posts_grid_ajax_data' name='{$section_id}_ajax_data' value='$ajax_data_str' />";
			echo "</form>";
		}
	echo "</section>";
	$out = ob_get_clean();
	return $out;
}

function ingenious_portfolio_posts_grid_posts ( $q = null ){
	if ( !isset( $q ) ) return;
	$def_grid_atts = array(
		'layout'					=> '1',
		'portfolio_data_to_show'	=> array(),
		'total_items_count'			=> PHP_INT_MAX
	);
	$grid_atts = isset( $GLOBALS['ingenious_posts_grid_atts'] ) ? $GLOBALS['ingenious_posts_grid_atts'] : $def_grid_atts;
	extract( $grid_atts );
	$paged = $q->query_vars['paged'];
	if (( $paged == 0 && $total_items_count < $q->post_count ) || ($display_style == 'carousel')){
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
			ingenious_portfolio_posts_grid_post ();
		endwhile;
		wp_reset_postdata();
		ob_end_flush();
	endif;				
}
function ingenious_get_portfolio_thumbnail_dims ( $eq_thumb_height = false, $real_dims = array() ) {
	$def_grid_atts = array(
					'layout'				=> '1',
					'sb_layout'				=> '',
					'full_width'			=> false,
				);
	$def_single_atts = array(
					'sb_layout'				=> '',
				);
	$post_meta = get_post_meta( get_the_ID(), 'cws_mb_post' );
	$post_meta = isset( $post_meta[0] ) ? $post_meta[0] : array();
	$grid_atts = isset( $GLOBALS['ingenious_posts_grid_atts'] ) ? $GLOBALS['ingenious_posts_grid_atts'] : $def_grid_atts;
	$single_atts = isset( $GLOBALS['ingenious_single_post_atts'] ) ? $GLOBALS['ingenious_single_post_atts'] : $def_single_atts;
	$ajax_single_atts = isset( $GLOBALS['ingenious_single_ajax_atts'] ) ? $GLOBALS['ingenious_single_ajax_atts'] : $def_grid_atts;
	$single = is_single();
	if ( $single ){
		extract( $single_atts );
		extract($ajax_single_atts);
	}
	else{
		extract( $grid_atts );
	}
	if (is_archive()) {
		$full_width = false;
	}
	// $full_width = !empty($full_width) ? $full_width : '';
	$display_style = !empty($display_style) ? $display_style : '';
	$display_style = esc_attr( $display_style );
	$layout = !empty($layout) ? $layout : '1';
	$single_fw = isset( $post_meta['full_width'] ) ? $post_meta['full_width'] : false;
	$dims = array( 'width' => 0, 'height' => 0 );
	if ($single){
		if ( empty( $sb_layout ) ){
			if ( ( empty( $real_dims ) || ( isset( $real_dims['width'] ) ) ) ){
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
			}
		}
		else if ( $sb_layout === "double" ){
			if ( ( empty( $real_dims ) || ( isset( $real_dims['width'] ) && $real_dims['width'] > 570 ) ) || $eq_thumb_height ){
				$dims['width'] = 570;
			}
		}
	} else if ($full_width == 'true'){
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
	} else if ($display_style == 'showcase') {
		$dims['width'] = 1920;
		if ( !isset( $real_dims['height'] ) ){
			$dims['height'] = 1080;
		}
	} else{
		switch ($layout){
			case "1":
				if ( empty( $sb_layout ) ){
					$dims['width'] = 1200;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 659;
					}	
				}
				else if ( $sb_layout === "single" ){
					$dims['width'] = 890;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 490;
					}	
				}
				else if ( $sb_layout === "double" ){
					$dims['width'] = 590;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 290;
					}	
				}
				break;
			case '2':
				if ( empty( $sb_layout ) ){
					$dims['width'] = 600;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 290;
					}	
				}
				else if ( $sb_layout === "single" ){
					$dims['width'] = 440;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 237;
					}	
				}
				else if ( $sb_layout === "double" ){
					$dims['width'] = 300;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 152;
					}	
				}
				break; 
			case '3':
				if ( empty( $sb_layout ) ){
					$dims['width'] = 400;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 208;
					}	
				}
				else if ( $sb_layout === "single" ){
					$dims['width'] = 300;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 152;
					}	
				}
				else if ( $sb_layout === "double" ){
					$dims['width'] = 190;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 152;
					}	
				}			
				break;
			case '4':
				$dims['width'] = 300;
				if ( !isset( $real_dims['height'] ) ){
					$dims['height'] = 152;
				}	
				else if ( $sb_layout === "single" ){
					$dims['width'] = 225;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 152;
					}	
				}
				else if ( $sb_layout === "double" ){
					$dims['width'] = 150;
					if ( !isset( $real_dims['height'] ) ){
						$dims['height'] = 152;
					}	
				}
				break;
		}
	}
	return $dims;
}
function ingenious_get_portfolio_chars_count ( $cols = null ){
	$number = 155;
	switch ( $cols ){
		case '1':
			$number = 300;
			break;
		case '2':
			$number = 130;
			break;
		case '3':
			$number = 70;
			break;
		case '4':
			$number = 55;
			break;
	}
	return $number;
}
function ingenious_portfolio_posts_grid_post (){
	$def_grid_atts = array(
		'layout'						=> '1',
		'portfolio_data_to_show'		=> array(),
		'portfolio_style'				=> '',
		'display_style'					=> '',
		'info_pos'						=> 'inside_img',
		'item_shadow'					=> false,
	);
	$grid_atts = isset( $GLOBALS['ingenious_posts_grid_atts'] ) ? $GLOBALS['ingenious_posts_grid_atts'] : $def_grid_atts;

	extract( $grid_atts );
	$call_from = isset($call_from) ? $call_from : '';
	$post_meta = get_post_meta( get_the_ID(), 'cws_mb_post' );
	$post_meta = isset( $post_meta[0] ) ? $post_meta[0] : array();
	$p_type = isset( $post_meta['p_type'] ) ? $post_meta['p_type'] : '';
	$video_type = isset( $post_meta['video_type'] ) ? $post_meta['video_type'] : '';	
	$slider_type = isset( $post_meta['slider_type'] ) ? $post_meta['slider_type'] : '';	
	$popup = isset( $post_meta['video_type']['popup'] ) ? $post_meta['video_type']['popup'] : '';
	$popup = $popup == 'true' ? true : false;
	$enable_hover = isset( $post_meta['enable_hover'] ) ? $post_meta['enable_hover'] : false;
	$portfolio_style = esc_attr( $portfolio_style );
	$display_style = esc_attr( $display_style );
	$info_pos = !empty($info_pos) ? $info_pos : 'inside_img';
	$item_shadow = !empty($item_shadow) ? $item_shadow : false;
	$portfolio_fig_style = ($display_style == 'hex_style' || $display_style == 'hex_style_2');
	$video_on = $p_type == 'video' && $video_type['on_grid'] == 1 && !$popup;
	$slider_on = $p_type == 'slider' && $slider_type['on_grid'] == 1;
	$anim_style = !empty($anim_style) ? $anim_style : '';
	$hover_none = ($anim_style == 'hover_none');
	$hover_none_link = ($anim_style == 'hover_none_link');
	$pid = get_the_id();

	ingenious_portfolio_posts_grid_post_media (); 
	if ($info_pos == 'inside_img'){
		if ($hover_none_link && $enable_hover == 1) {
			ingenious_portfolio_posts_grid_post_hover ();
		} else if (!$video_on && !$hover_none && $enable_hover == 1 && !$slider_on) {
			if ($portfolio_fig_style == false) {
				echo "<div class='portfolio_content_wrap'>";
					ingenious_portfolio_posts_grid_post_hover ();
					ingenious_portfolio_posts_grid_post_title ();
					ingenious_portfolio_posts_grid_post_terms ();
					ingenious_portfolio_posts_grid_post_content ();
				echo "</div>";
			}
		}
	} else {
		ingenious_portfolio_posts_grid_post_title ();
		ingenious_portfolio_posts_grid_post_terms ();
		ingenious_portfolio_posts_grid_post_content ();
	}
	if ( $display_style == 'showcase' ) {
		echo "<div class='side_load'>";
			echo "<div class='load_bg'></div>";
			echo "<div class='load_wrap'>";
				ingenious_portfolio_posts_grid_post_title ();
			echo "</div>";
		echo "</div>";
	}
	echo "</div>";
	if ($item_shadow == 1 && $enable_hover == 1) {
		echo "<div class='item_shadow_box'></div>";
	}
	echo "</article>";
}
function ingenious_getUrl() {
	global $wp;
	return home_url( $wp->request );
}    
function ingenious_portfolio_posts_grid_post_media (){
	$pid = get_the_id();
	$p_meta = get_post_meta( $pid, 'cws_mb_post' );
	$p_meta = isset( $p_meta[0] ) ? $p_meta[0] : array();
	$post_url = esc_url(get_the_permalink());
	$post_meta = get_post_meta( get_the_ID(), 'cws_mb_post' );
	$post_meta = isset( $post_meta[0] ) ? $post_meta[0] : array();
	$p_type = isset( $post_meta['p_type'] ) ? $post_meta['p_type'] : '';
	$title = get_the_title();	
	$permalink = get_the_permalink( $pid );
	$def_grid_atts = array(
					'layout'						=> '1',
					'hex_layout'					=> '3',
					'portfolio_data_to_show'	=> array(),
					'portfolio_style'				=> '',
					'display_style'					=> 'grid',
					'anim_style'					=> 'hoverdef',
					'info_pos'						=> 'inside_img',
					'masonry'						=> false,
					'crop_img'						=> false,
					'title_divider'					=> false,
					'appear_style'					=> 'none',
					'hex_display_style'				=> 'grid',
				);	
	$grid_atts = isset( $GLOBALS['ingenious_posts_grid_atts'] ) ? $GLOBALS['ingenious_posts_grid_atts'] : $def_grid_atts;

	extract( $grid_atts );
	$portfolio_style = esc_attr( $portfolio_style );
	$display_style = !empty($display_style) ? $display_style : "";
	$portfolio_fig_style = !empty($portfolio_fig_style) ? $portfolio_fig_style : "";
	$hex_display_style = !empty($hex_display_style) ? esc_attr( $hex_display_style ) : "";
	$appear_style = !empty($appear_style) ? $appear_style : "";
	$masonry = !empty($masonry) ? $masonry : "";
	$display_style = esc_attr( $display_style );
	$info_pos = !empty($info_pos) ? $info_pos : 'inside_img';
	$slider_type = isset( $post_meta['slider_type'] ) ? $post_meta['slider_type'] : '';
	$video_type = isset( $post_meta['video_type'] ) ? $post_meta['video_type'] : '';
	$enable_hover = isset( $post_meta['enable_hover'] ) ? $post_meta['enable_hover'] : false;
	$custom_url = isset( $post_meta['link_options_url'] ) ? $post_meta['link_options_url'] : "";
	$fancybox = isset( $post_meta['link_options_fancybox'] ) ? $post_meta['link_options_fancybox'] : false;
	$classes = "";
	$classes .= " ".esc_attr($info_pos);
	$classes .= $title_divider ? " title_divider" : "";
	$classes .= $appear_style ? " appear_style" : "";
	$classes .= $enable_hover == 0 ? " hover_none" : "";
	$anim_style = !empty($anim_style) ? $anim_style : '';
	if ($display_style == 'grid' || $display_style == 'filter') {
		$classes .= !empty($anim_style) ? " $anim_style" : "";
	}
	$masonry = $masonry == 'true' ? true : false;
	$post_url = esc_url(get_the_permalink());
	$thumbnail_props = has_post_thumbnail() ? wp_get_attachment_image_src(get_post_thumbnail_id( ),'full') : array();
	$thumb_id = get_post_thumbnail_id();
	$thumbnail = !empty( $thumbnail_props ) ? $thumbnail_props[0] : '';
	$real_thumbnail_dims = array();
	if ( !empty( $thumbnail_props ) && isset( $thumbnail_props[1] ) ) $real_thumbnail_dims['width'] = $thumbnail_props[1];
	if ( !empty(  $thumbnail_props ) && isset( $thumbnail_props[2] ) ) $real_thumbnail_dims['height'] = $thumbnail_props[2];
	switch ($display_style) {
		case 'hex_style':
			$portfolio_fig_style = ' hex_style';
			$hex_h_mob = '110';
			$hex_w_mob = '100';
			switch ($hex_layout) {
				case '3':
					$hex_w = '380';
					$hex_h = '430';
					break;
				case '4':
					$hex_w = '280';
					$hex_h = '310';
					break;
				case '5':
					$hex_w = '220';
					$hex_h = '245';
					break;
			}
			break;
		case 'hex_style_2':
			$portfolio_fig_style = ' hex_style_2';
			if ($hex_display_style == 'carousel') {
				$hex_h_mob = '100';
				$hex_w_mob = '110';
				switch ($hex_layout) {
					case '3':
						$hex_w = '380';
						$hex_h = '340';
						break;
					case '4':
						$hex_w = '280';
						$hex_h = '250';
						break;
					case '5':
						$hex_w = '220';
						$hex_h = '200';
						break;
				}
				break;
			} else {
				$hex_h_mob = '100';
				$hex_w_mob = '110';
				switch ($hex_layout) {
					case '3':
						$hex_w = '450';
						$hex_h = '400';
						break;
					case '4':
						$hex_w = '340';
						$hex_h = '300';
						break;
					case '5':
						$hex_w = '270';
						$hex_h = '245';
						break;
				}
				break;
			}
	}
	$classes .= $portfolio_fig_style ? $portfolio_fig_style : "";
	$hex_classes = '';
	$canvas_id = '';
	if ( $portfolio_fig_style ) {
		$canvas_id = uniqid( "canvas_" );
		$canvas_id = "id='$canvas_id'";
		$hex_classes = 'figure_container hexagon';
		$hex_classes .= $hex_layout ? ' col_' . $hex_layout : '';
		$thumbnail_dims_hex = array( 'width' => $hex_w . 'px', 'height' => $hex_h . 'px' , 'crop' => true);
		$thumbnail_dims = $thumbnail_dims_hex;
	} else {
		$thumbnail_dims = ingenious_get_portfolio_thumbnail_dims( false, $real_thumbnail_dims );
	}
	
	if ($crop_img == '1'){
		$thumbnail_dims['crop'] = true;
	}
	
	$isotope = array('masonry' => $masonry , 'columns' => $layout, 'portfolio_style' => $portfolio_style );
	if ($isotope['masonry']){
		extract(ingenious_portfolio_masonry($thumbnail, $thumbnail_dims, $p_meta, $isotope));
	}

	$video_t = isset( $post_meta['video_type']['video_t'] ) ? $post_meta['video_type']['video_t'] : '';
	$video = isset( $post_meta['video_type'][$video_t . '_t']['url'] ) ? $post_meta['video_type'][$video_t . '_t']['url'] : '';
	$video_img = isset( $post_meta['video_type']['img'] ) ? $post_meta['video_type']['img'] : '';
	$popup_grid = isset( $post_meta['video_type']['popup_grid'] ) ? $post_meta['video_type']['popup_grid'] : '';
	$popup_grid = (bool)$popup_grid;
	if (!empty($thumbnail)) {
		$thumb_obj = ingenious_thumb( $thumbnail, $thumbnail_dims, $thumb_id );
	}
	$thumb_url = isset( $thumb_obj[0] ) ? esc_url($thumb_obj[0]) : "";
	$thumb_url_retina = isset( $thumb_obj[3] ) ? esc_url($thumb_obj[3]) : "";
	$thumb_url_retina = $thumb_url_retina == null ? "data-no-retina" : "data-at2x='$thumb_url_retina'";
	$link_fancy = "";
	$link_fancy .= $fancybox ? "class='fancy fa flaticon-magnifying-glass'" : "";
	$link_fancy .= $fancybox ? " href='$thumbnail'" : "";
	$popup = isset( $post_meta['video_type']['popup'] ) ? $post_meta['video_type']['popup'] : '';
	$popup = (bool)$popup;
	$video_on = $p_type == 'video' && $video_type['on_grid'] == 1 && !$popup;
	$slider_on = $p_type == 'slider' && $slider_type['on_grid'] == 1;
	$hover_none = ($anim_style == 'hover_none');
	$hover_none_link = ($anim_style == 'hover_none_link');
	$link_url = "";
	$link_url .= $custom_url ? $custom_url : $post_url;
	$page_url = ingenious_getUrl();
	$data_col = !empty($isotope_col_count) ? " data-masonry-col='$isotope_col_count'" : ""; 
	$data_line = !empty($isotope_line_count) ? " data-masonry-line='$isotope_line_count'" : ""; 
	$data_anim = '';

	if ($display_style == 'grid' || $display_style == 'filter') {
		$data_anim = $appear_style !== 'none' ? " data-item-anim='$appear_style'" : ""; 
	}
		echo "<article id='post_post_{$pid}' class='item portfolio_item_post portfolio_item_grid_post clearfix" . $classes . "' $data_col $data_line $data_anim>";
			echo "<div class='item_content'>";
				
				echo "<div class='mobile_title_wrapper'><span class='mobile_title'>".esc_html($title)."</span></div>";

				echo "<div class='post_media post_post_media post_posts_grid_post_media'>";
					if ($p_type == 'slider' && $slider_type['on_grid'] == 1 && !$portfolio_fig_style) {
						if ($display_style == 'showcase') {
							echo "<div class='pic' style='background-image:url(" . $thumb_url . ")'>";
								echo "<a href='#' class='links' data-pid='{$pid}' data-url-reload='$page_url'></a>";	
							echo "</div>";
							if ($enable_hover == 1 && !$hover_none && !$hover_none_link) {
								echo "<div class='portfolio_content_wrap'>";
									ingenious_portfolio_posts_grid_post_hover ();
									if ($info_pos == 'inside_img') {
										ingenious_portfolio_posts_grid_post_title ();
										ingenious_portfolio_posts_grid_post_terms ();
										ingenious_portfolio_posts_grid_post_content ();
									}
								echo "</div>";
							}
						}else if ( !empty( $slider_type ) ) {
							$match = preg_match_all("/\d+/",$slider_type['slider_gall'],$images);
							if ($match){
								$images = $images[0];
								$image_srcs = array();
								foreach ( $images as $image ) {
									$image_src = wp_get_attachment_image_src($image,'full');
									$image_url['src'] = $image_src[0];
									$image_url['id'] = $image;
									if (!empty($image_url['src'])){
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
													</a>";
								}
								if ($enable_hover == 1 && !$hover_none && !$hover_none_link) {
									echo "<div class='portfolio_content_wrap'>";
										ingenious_portfolio_posts_grid_post_hover ();
										if ($info_pos == 'inside_img') {
											ingenious_portfolio_posts_grid_post_title ();
											ingenious_portfolio_posts_grid_post_terms ();
											ingenious_portfolio_posts_grid_post_content ();
										}
									echo "</div>";
								}
								if ($carousel) {
									echo "<div class='gallery_post_carousel'>";
								}
								foreach ( $image_srcs as $image_src ) {
									$img_obj = ingenious_thumb( $image_src['src'], $thumbnail_dims , $image_src['id'] );
									$img_url = isset( $img_obj[0] ) ? esc_url( $img_obj[0] ) : "";
									$thumb_url_retina = isset( $img_obj[3] ) ? esc_url( $img_obj[3] ) : "";
									$thumb_url_retina = $thumb_url_retina == null ? "data-no-retina" : "$thumb_url_retina";
									if ( !empty($img_url) ) {
										echo "<div class='pic'>";
											echo "<img src='$img_url' $thumb_url_retina alt />";
										echo "</div>";
									}
								}
								if ($carousel) {
									echo "</div>";
								}
							}
						}
					} else if ($p_type == 'video' && $video_type['on_grid'] == 1 && !$portfolio_fig_style) {
						if ($display_style == 'showcase') {
							echo "<div class='" . $hex_classes . " pic' style='background-image:url(" . $thumb_url . ")'>";
								echo "<a href='#' class='links' data-pid='{$pid}' data-url-reload='$page_url'></a>";	
							echo "</div>";
							if ($enable_hover == 1 && !$hover_none && !$hover_none_link) {
								echo "<div class='portfolio_content_wrap'>";
									ingenious_portfolio_posts_grid_post_hover ();
									if ($info_pos == 'inside_img') {
										ingenious_portfolio_posts_grid_post_title ();
										ingenious_portfolio_posts_grid_post_terms ();
										ingenious_portfolio_posts_grid_post_content ();
									}
								echo "</div>";
							}
						} else {
							global $wp_filesystem;
							if ( !empty($video_img['src']) ) {
								$video_img = !empty($video_img['src']) ? $video_img['src'] : '';
								$img_obj = ingenious_thumb( $video_img, $thumbnail_dims , $thumb_id );
								$img_url = isset( $img_obj[0] ) ? esc_url( $img_obj[0] ) : "";
								$thumb_url_retina = isset( $img_obj[3] ) ? esc_url( $img_obj[3] ) : "";
							}
							preg_match('@[^/]*$@', $video, $video_link);
							$clear_url = array("?", "&amp", "watchv=");
							$video_id = str_replace($clear_url, '', preg_replace('/[^?][a-z]*=\w+/', '', $video_link[0]));
							$video_url = str_replace('watch?v=', '', $video_link[0]);
							if ($video_t == 'youtube') {
								$thumbnail_img = "http://img.youtube.com/vi/".esc_attr($video_id)."/maxresdefault.jpg";
								$link = "http://www.youtube.com/embed/";
							} else if ($video_t == 'vimeo') {
								$json = json_decode($wp_filesystem->get_contents("https://vimeo.com/api/oembed.json?url=".$video));
								$vimeo_id = !empty($json->video_id) ? $json->video_id : '';
								$thumbnail_img = !empty($json->thumbnail_url) ? $json->thumbnail_url : '';
								$link = "https://player.vimeo.com/video/";
								$video_url = ($video_id != $vimeo_id ? str_replace($video_id, $vimeo_id, $video_url) : $video_url);
							}
							$embed_link = $link.esc_attr($video_url) . ($video_id != $video_url ? '&amp;' : '?') . "autoplay=1";
							$img_url = !empty($thumb_url) ? $thumb_url : $thumbnail_img;
							if (!$popup_grid) {
							 	echo "<div class='video'>";
							}
							if ($popup_grid) {
								echo "<div class='cover_img'>";
									if ( !empty($thumb_url) ) {
										echo "<img src='$img_url' $thumb_url_retina alt />";
									}
									else{
										echo "<img src='$img_url' data-no-retina alt />";
									}
									if ($enable_hover == 1 && !$hover_none && !$hover_none_link) {
										echo "<div class='portfolio_content_wrap'>";
											echo "<a href='$embed_link' class='links video fa fa-play-circle-o fancy fancybox.iframe'></a>";
											ingenious_portfolio_posts_grid_post_hover ($embed_link);
											if ($info_pos == 'inside_img') {
												ingenious_portfolio_posts_grid_post_title ();
												ingenious_portfolio_posts_grid_post_terms ();
												ingenious_portfolio_posts_grid_post_content ();
											}
										echo "</div>";
									}
								echo "</div>";
							} else {
								echo apply_filters('the_content',"[embed width='" . $thumbnail_dims['width'] . "']" .($video_t == 'youtube' ? 'https://youtu.be/'.$video_id : $video ) . "[/embed]");
							}
							if (!$popup_grid) {
							 	echo "</div>";
							}
						}
					} else {

						echo "<div class='" . $hex_classes . " pic' ".( $display_style == 'showcase' ? "style='background-image:url(" . $thumb_url . ")'" : '' ).">";
							if ($display_style !== 'showcase') {
								echo "<img src='$thumb_url' $thumb_url_retina alt />";
							}
							if ( $portfolio_fig_style ) {
								echo "<canvas class='hex_display' " . (!empty($canvas_id) ? $canvas_id : "") . " height='$hex_h' width='$hex_w'></canvas>";
								echo "<canvas class='hex_mob' height='$hex_h_mob' width='$hex_w_mob'></canvas>";
							}
							if ( $display_style == 'showcase' ) {
								echo "<a href='#' class='links' data-pid='{$pid}' data-url-reload='$page_url'></a>";
							} 
						echo "</div>";
					}
					if ($hover_none_link && $enable_hover == 1) {
						ingenious_portfolio_posts_grid_post_hover();
					} else if ($info_pos == 'under_img' && $enable_hover == 1 && !$video_on && !$hover_none && !$slider_on) {
						echo "<div class='portfolio_content_wrap'>";
							ingenious_portfolio_posts_grid_post_hover ();
						echo "</div>";
					} else if ($portfolio_fig_style){
						echo "<div class='portfolio_content_wrap'>";
							ingenious_portfolio_posts_grid_post_hover ();
							ingenious_portfolio_posts_grid_post_title ();
							ingenious_portfolio_posts_grid_post_terms ();
							ingenious_portfolio_posts_grid_post_content ();
						echo "</div>";
					}
				echo "</div>";
}
function ingenious_portfolio_posts_grid_post_hover ( $video_link = '' ){
	$pid = get_the_id ();
	$def_grid_atts = array(
					'layout'						=> '1',
					'display_style'					=> '',
					'area_link'						=> true,
					'link_show'						=> 'popup_link',
				);
	$grid_atts = isset( $GLOBALS['ingenious_posts_grid_atts'] ) ? $GLOBALS['ingenious_posts_grid_atts'] : $def_grid_atts;

	extract( $grid_atts );
	$display_style = esc_attr( $display_style );
	$area_link = (bool)$area_link;
	$display_style = !empty($display_style) ? $display_style : "";
	$portfolio_fig_style = !empty($portfolio_fig_style) ? $portfolio_fig_style : "";
	$portfolio_fig_style = ($display_style == 'hex_style' || $display_style == 'hex_style_2') ? true : false;
	$post_url = esc_url(get_the_permalink());
	$post_meta = get_post_meta( get_the_ID(), 'cws_mb_post' );
	$post_meta = isset( $post_meta[0] ) ? $post_meta[0] : array();
	$custom_url = isset( $post_meta['link_options_url'] ) ? $post_meta['link_options_url'] : "";
	$link_options_fancybox = isset( $post_meta['link_options_fancybox'] ) ? $post_meta['link_options_fancybox'] : false;
	$link_options_single = isset( $post_meta['link_options_single'] ) ? $post_meta['link_options_single'] : false;
	$enable_hover = isset( $post_meta['enable_hover'] ) ? $post_meta['enable_hover'] : false;

	$popup = isset( $post_meta['video_type']['popup'] ) ? $post_meta['video_type']['popup'] : '';
	$popup = (bool)$popup;

	$link_url = $custom_url ? $custom_url : $post_url;
	$thumbnail_props = has_post_thumbnail() ? wp_get_attachment_image_src(get_post_thumbnail_id( ),'full') : array();
	$thumbnail = !empty( $thumbnail_props ) ? $thumbnail_props[0] : '';
	$thumbnail = !empty($video_link) ? $video_link : $thumbnail;
	$shape = ingenious_shape('circle',true);	
	$single = is_single();

	if (!$single) {
		$single = $link_options_single == 1 ? true : false;
	}

	if (!$popup) {
		$popup = $link_options_fancybox == 1 ? true : false;
	}
	$anim_style = !empty($anim_style) ? $anim_style : '';
	$hover_none = ($anim_style == 'hover_none');
	$hover_none_link = ($anim_style == 'hover_none_link');
	if ($display_style != 'showcase') {
		if (!$hover_none && !$hover_none_link) {
			if ($link_show !== 'none') {
				echo "<div class='links_wrap'>";
					if ( $link_show == 'single_link' || $link_options_single == 1){
						echo "<a href='$link_url' class='fa fa-share links'>$shape</a>";
					} else if ( $link_show == 'popup_link' || $link_options_fancybox == 1){
						echo "<a href='" . $thumbnail . "' class='cws-icon-expand-hand-drawn-interface-symbol-of-two-opposite-arrows-outlines links fancy" . (!empty($video_link) ? ' fancybox.iframe' : '') . "'>$shape</a>";
					} 
				echo "</div>";
			}
			if ( $area_link ){
				echo "<a href='" . (!empty($video_link) ? $video_link : $link_url) . "' class='links area" . (!empty($video_link) ? ' fancy fancybox.iframe' : '') . "'></a>";
			} 
			echo "<div class='hover-effect'>" . ($portfolio_fig_style ? ingenious_figure_style() : "") . "</div>";
		} else if ($hover_none_link) {
			echo "<a href='$link_url' class='links area'></a>";
		}
	}
}

function ingenious_portfolio_posts_grid_post_title (){
	$pid = get_the_id ();
	$def_grid_atts = array(
		'layout'						=> '1',
		'portfolio_def_data_to_show'	=> array(),
		'display_style'					=> '',
	);
	$grid_atts = isset( $GLOBALS['ingenious_posts_grid_atts'] ) ? $GLOBALS['ingenious_posts_grid_atts'] : $def_grid_atts;	
	extract( $grid_atts );
	$info_align = !empty($info_align) ? $info_align : 'center';
	$display_style = "";
	$display_style = esc_attr( $display_style );
	$portfolio_fig_style = ($display_style == 'hex_style');
	if ( !$portfolio_fig_style ) {
		if ( in_array( 'title', $portfolio_data_to_show ) ){
			$title = get_the_title();
			$permalink = get_the_permalink();
			echo !empty( $title ) ?	"<h3 class='portfolio_post_title post_title text_align{$info_align}'><a href='$permalink'>" . $title . "</a></h3>" : "";	
		}
	}
}
function ingenious_portfolio_posts_grid_post_content (){
	$pid = get_the_id ();
	$post = get_post( $pid );
	$def_grid_atts = array(
		'layout'						=> '1',
		'portfolio_data_to_show'	=> array(),
		'chars_count'					=> '',
	);
	$grid_atts = isset( $GLOBALS['ingenious_posts_grid_atts'] ) ? $GLOBALS['ingenious_posts_grid_atts'] : $def_grid_atts;	
	extract( $grid_atts );
	$info_align = !empty($info_align) ? $info_align : 'center';
	$out = "";
	if ( in_array( 'excerpt', $portfolio_data_to_show ) ){
		$chars_count = !empty($chars_count) ? $chars_count : ingenious_get_portfolio_chars_count( $layout );
		$out = !empty( $post->post_excerpt ) ? $post->post_excerpt : $post->post_content;
		$out = trim( preg_replace( "/[\s]{2,}/", " ", strip_shortcodes( strip_tags( $out ) ) ) );
		$out = wptexturize( $out );
		$out = substr( $out, 0, $chars_count );
		echo !empty( $out ) ? "<div class='portfolio_posts_grid_post_content post_content text_align{$info_align}'>$out</div>" : "";
	}
}
function ingenious_portfolio_posts_grid_post_terms (){
	$pid = get_the_id ();
	$def_grid_atts = array(
		'layout'						=> '1',
		'portfolio_data_to_show'	=> array(),
		'portfolio_style'				=> '',
		'display_style'					=> '',
	);
	$grid_atts = isset( $GLOBALS['ingenious_posts_grid_atts'] ) ? $GLOBALS['ingenious_posts_grid_atts'] : $def_grid_atts;	
	extract( $grid_atts );	
	$portfolio_style = esc_attr( $portfolio_style );
	$display_style = !empty($display_style) ? $display_style : "";
	$info_align = !empty($info_align) ? $info_align : 'center';
	$display_style = esc_attr( $display_style );
	$portfolio_fig_style = $display_style == 'hex_style';
	if ( in_array( 'cats', $portfolio_data_to_show ) ){
		$p_category_terms = wp_get_post_terms( $pid, 'cwsportfolio-cat' );
		$p_cats = "";
		for ( $i=0; $i < count( $p_category_terms ); $i++ ){
			$p_category_term = $p_category_terms[$i];
			$p_cat_permalink = get_term_link( $p_category_term->term_id, 'cwsportfolio-cat' );
			$p_cat_name = $p_category_term->name;
			$p_cats .= "<a href='$p_cat_permalink'>$p_cat_name</a>";
			$p_cats .= $i < count( $p_category_terms ) - 1 ? esc_html__( ",&#x20;", 'ingenious' ) : "";
		}
		if (!$portfolio_fig_style) {
			echo !empty($p_cats) ? "<div class='portfolio_post_terms post_terms text_align{$info_align}'>&#x20;{$p_cats}</div>" : "";		
		}
	}	
}
function ingenious_portfolio_single_post_post_media ($pid_ajax = null , $ajax_width = ''){
	$figure_style =  ingenious_figure_style() ;
	$post_url = esc_url(get_the_permalink($pid_ajax));
	$post_meta = get_post_meta( ($pid_ajax ? $pid_ajax : get_the_ID()), 'cws_mb_post' );
	$post_meta = isset( $post_meta[0] ) ? $post_meta[0] : array();
	$thumbnail_props = has_post_thumbnail( $pid_ajax ) ? wp_get_attachment_image_src(get_post_thumbnail_id( $pid_ajax ),'full') : array();
	$thumb_id = get_post_thumbnail_id( $pid_ajax );
	$thumbnail = !empty( $thumbnail_props ) ? $thumbnail_props[0] : '';
	$real_thumbnail_dims = array();
	if ( !empty( $thumbnail_props ) && isset( $thumbnail_props[1] ) ) $real_thumbnail_dims['width'] = $thumbnail_props[1];
	if ( !empty(  $thumbnail_props ) && isset( $thumbnail_props[2] ) ) $real_thumbnail_dims['height'] = $thumbnail_props[2];
	$thumbnail_dims = ingenious_get_portfolio_thumbnail_dims( false, $real_thumbnail_dims );
	$crop_thumb = isset( $thumbnail_dims['width'] ) && $thumbnail_dims['width'] > 0;
	if (!empty($ajax_width)) {
		$thumbnail_dims['width'] = $ajax_width;
	}
	if (!empty($thumbnail)) {
		$thumb_obj = ingenious_thumb( $thumbnail, $thumbnail_dims, $thumb_id );
	}
	$thumb_url = isset( $thumb_obj[0] ) ? esc_url($thumb_obj[0]) : "";
	$thumb_url_retina = isset( $thumb_obj[3] ) ? esc_url($thumb_obj[3]) : "";
	$thumb_url_retina = $thumb_url_retina == null ? "data-no-retina" : "data-at2x='$thumb_url_retina'";
	$p_type = isset( $post_meta['p_type'] ) ? $post_meta['p_type'] : '';	
	$full_width = isset( $post_meta['full_width'] ) ? $post_meta['full_width'] : false;	
	$retina_thumb_exists = false;
	$retina_thumb_url = "";		
	$retina_thumb_url = esc_attr($retina_thumb_url);
	$enable_hover = isset( $post_meta['enable_hover'] ) ? $post_meta['enable_hover'] : false;
	$custom_url = isset( $post_meta['link_options_url'] ) ? $post_meta['link_options_url'] : "";
	$fancybox = isset( $post_meta['link_options_fancybox'] ) ? $post_meta['link_options_fancybox'] : false;
	$video_t = isset( $post_meta['video_type']['video_t'] ) ? $post_meta['video_type']['video_t'] : '';
	$video = isset( $post_meta['video_type'][$video_t . '_t']['url'] ) ? $post_meta['video_type'][$video_t . '_t']['url'] : '';
	$video_img = isset( $post_meta['video_type']['img'] ) ? $post_meta['video_type']['img'] : '';
	$popup = isset( $post_meta['video_type']['popup'] ) ? $post_meta['video_type']['popup'] : '';
	if ( $fancybox ){
		wp_enqueue_script( 'fancybox' );
	}
	$popup = (bool)$popup;
	$link_atts = "";
	$link_url = $custom_url ? $custom_url : $thumbnail;
	$link_icon = $fancybox ? ( $custom_url ? 'magic' : 'plus' ) : 'share';
	$link_class = $fancybox ? "fancy {$link_icon}" : "{$link_icon}";
	$link_atts .= !empty( $link_class ) ? " class='$link_class'" : "";
	$link_atts .= !empty( $link_url ) ? " href='$link_url'" : "";
	$link_atts .= !$fancybox ? " target='_blank'" : "";
	$link_atts .= $fancybox && $custom_url ? " data-fancybox-type='iframe'" : "";
		echo "<div class='post_media post_post_media post_posts_grid_post_media'>";
				switch ($p_type) {
					case 'image':
						if ( !empty( $thumb_url ) ){
							echo "<div class='pic" . ( !$enable_hover || ( !$crop_thumb && !$custom_url ) ? " wth_hover" : "" ) . "'>";
								echo "<img src='$thumb_url' $thumb_url_retina alt />";
							echo "</div>";
						}
						break;
					case 'slider':
						$slider_type = isset( $post_meta['slider_type'] ) ? $post_meta['slider_type'] : '';
						if ( !empty( $slider_type) ) {
							$match = preg_match_all("/\d+/",$slider_type['slider_gall'],$images);
							if ($match){
								$images = $images[0];
								$image_srcs = array();

								foreach ( $images as $image ) {
									$image_src = wp_get_attachment_image_src($image,'full');
									$image_url['src'] = $image_src[0];
									$image_url['id'] = $image;
									if (!empty($image_url['src'])){
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
									$thumb_url_retina = isset( $img_obj[3] ) ? esc_url( $img_obj[3] ) : "";
									$retina_thumb_exists = false;
									$retina_thumb_url = "";
									if ( !empty($img_url) ) {
										echo "<div class='pic'>";
											echo "<img src='$img_url' data-no-retina alt />";
										echo "</div>";
									}
								}
								if ($carousel) {
									echo "</div>";
								}
							}
						}
						break;
					case 'rev_slider':
						get_template_part( 'slider' );
						break;
					case 'gallery':
						ingenious_service_filter_gallery();
						remove_all_filters('post_gallery', 10);
						echo do_shortcode($post_meta['gall_type']['gall']);
						break;
					case 'video':
						global $wp_filesystem;
						preg_match('@[^/]*$@', $video, $video_link);
						$clear_url = array("?", "&amp", "watchv=");
						$video_id = str_replace($clear_url, '', preg_replace('/[^?][a-z]*=\w+/', '', $video_link[0]));
						$video_url = str_replace('watch?v=', '', $video_link[0]);				

						if ($video_t == 'youtube') {
							$thumbnail_img = "http://img.youtube.com/vi/".esc_attr($video_id)."/maxresdefault.jpg";
							$link = "http://www.youtube.com/embed/";
						} else if ($video_t == 'vimeo') {
							$json = json_decode($wp_filesystem->get_contents("https://vimeo.com/api/oembed.json?url=".$video));
							$vimeo_id = !empty($json->video_id) ? $json->video_id : '';
							$thumbnail_img = !empty($json->thumbnail_url) ? $json->thumbnail_url : '';
							$link = "https://player.vimeo.com/video/";
							$video_url = ($video_id != $vimeo_id ? str_replace($video_id, $vimeo_id, $video_url) : $video_url);
						}
						$embed_link = $link.esc_attr($video_url) . ($video_id != $video_url ? '&amp;' : '?') . "autoplay=1";
						$img_url = !empty($thumb_url) ? $thumb_url : $thumbnail_img;
						echo "<div class='video'>";
						if ($popup) {
							echo "<div class='cover_img'>";
								if ( $retina_thumb_exists ) {
									echo "<img src='".esc_url($img_url)."' $retina_thumb_url alt />";
								}
								else{
									echo "<img src='".esc_url($img_url)."' data-no-retina alt />";
								}
								echo "<div class='portfolio_content_wrap'>";
									echo "<div class='hover-effect'></div>";
									echo "<a href='".esc_url($embed_link)."' class='links video fa fa-play-circle-o fancy fancybox.iframe'></a>";
									echo "<a class='links area fancy fancybox.iframe' href='".esc_url($embed_link)."'></a>";
								echo "</div>";
							echo "</div>";
						} else {
							echo apply_filters('the_content',"[embed width='" . $thumbnail_dims['width'] . "']" .($video_t == 'youtube' ? 'https://youtu.be/'.$video_id : $video ) . "[/embed]");
						}
						echo "</div>";
						break;
				}
		echo "</div>";
	$GLOBALS['ingenious_portfolio_single_post_floated_media'] = !empty( $thumb_url ) && !$crop_thumb;
}
function ingenious_portfolio_single_post_title ($pid = null){
	$p_meta = get_post_meta( $pid, 'cws_mb_post' );
	$p_meta = isset( $p_meta[0] ) ? $p_meta[0] : array();
	$title = get_the_title($pid);
	$title_align = !empty($p_meta['title_align']) ? $p_meta['title_align'] : '';
	echo !empty( $title ) ?	"<h3 class='portfolio_post_title post_title' " . (!empty($title_align) ? "style='text-align: {$title_align};'" : '') . ">" . $title . "</h3>" : "";	
}
function ingenious_portfolio_single_post_terms ($pid = null){
	$pid = !empty($pid) ? $pid : get_the_id ();
	$p_meta = get_post_meta( $pid, 'cws_mb_post' );
	$p_meta = isset( $p_meta[0] ) ? $p_meta[0] : array();
	$out = "";
	$p_category_terms = wp_get_post_terms( $pid, 'cwsportfolio-cat' );
	$p_cats = "";
	$title_align = !empty($p_meta['title_align']) ? $p_meta['title_align'] : '';
	for ( $i=0; $i < count( $p_category_terms ); $i++ ){
		$p_category_term = $p_category_terms[$i];
		$p_cat_permalink = get_term_link( $p_category_term->term_id, 'cwsportfolio-cat' );
		$p_cat_name = $p_category_term->name;
		$p_cat_name = esc_html( $p_cat_name );
		$p_cats .= "<a href='$p_cat_permalink'>$p_cat_name</a>";
		$p_cats .= $i < count( $p_category_terms ) - 1 ? esc_html__( ",&#x20;", 'ingenious' ) : "";
	}
	if ( !empty( $p_cats ) ){
		echo "<div class='portfolio_post_terms post_terms' " . (!empty($title_align) ? "style='text-align: {$title_align};'" : '') . ">";
			echo "{$p_cats}";
		echo "</div>";
	}
}
function ingenious_portfolio_single_post_content ($pid = null){
	$content =  apply_filters('the_content', get_post_field('post_content', $pid));
	if ( !empty( $content ) ){
		echo "<div class='post_content post_post_content post_single_post_content'>";
			echo sprintf("%s", $content);
		echo "</div>";
	}
}
function ingenious_portfolio_masonry($featured_img_url = '', $dims_from_columns, $p_meta = '', $custom_layout_arr = false){
	$isotope_col_count = (isset($p_meta['isotope_col_count'])) ? intval($p_meta['isotope_col_count']) : 1;
	$isotope_line_count = (isset($p_meta['isotope_line_count'])) ? intval($p_meta['isotope_line_count']) : 1;
	$columns = intval($custom_layout_arr['columns']);
	if (!empty( $featured_img_url )){
		$img_width = $dims_from_columns['width'];
		$img_height = $dims_from_columns['height'];
		if ($img_width <= $img_height){
			$dims['width'] = $img_width;
			$dims['height'] = $img_width;
		} elseif ($img_height <= $img_width) {
			$dims['width'] = $img_height;
			$dims['height'] = $img_height;
		}
		$dims['crop'] = array(
			ingenious_get_option( "crop_x" ),
			ingenious_get_option( "crop_y" )
		);	
	} else {
		$dims['width'] = 0;
		$dims['height'] = 0;
	}

	if (!empty( $featured_img_url ) && $custom_layout_arr['masonry'] == '1') {
		$img_width = $dims_from_columns['width'];
		$img_height = $dims_from_columns['height'];	
		$pd = 20;
		$col_paddings = ($pd * $isotope_col_count);
		$line_paddings = ($pd * $isotope_line_count);
		if ($custom_layout_arr['portfolio_style'] == 'wide_style') {
			$dims['width'] = ($img_width * $isotope_col_count) + $col_paddings;
			$dims['height'] = ($img_width * $isotope_line_count) + $line_paddings;
		} else{	
			switch ($isotope_col_count) {
				case '1':
					$dims['width'] = $img_width * $isotope_col_count;
					break;
				case '2':
					if ( $columns < $isotope_col_count ) {
						$isotope_col_count = $columns;
					}
					$dims['width'] = ($img_width * $isotope_col_count) + $pd;
					break;
				case '3':
					$case = $isotope_col_count - 1;
					if ( $columns < $isotope_col_count ) {
						$isotope_col_count = $columns;
						$case = $isotope_col_count - 1;
					}
					$dims['width'] = ($img_width * $isotope_col_count) + $pd * $case;
					break;
				case '4':
					$case = $isotope_col_count - 1;
					if ( $columns < $isotope_col_count ) {
						$isotope_col_count = $columns;
						$case = $isotope_col_count - 1;
					}
					$dims['width'] = ($img_width * $isotope_col_count) + $pd * $case;
					break;
			}
			switch ($isotope_line_count) {
				case '1':
					$dims['height'] = $img_width * $isotope_line_count;
					break;
				case '2':
					if ( $columns < $isotope_line_count ) {
						$isotope_line_count = $columns;
					}
					$dims['height'] = ($img_width * $isotope_line_count) + $pd * 2;
					break;
				case '3':
					$case = $isotope_line_count - 1;
					if ( $columns < $isotope_line_count ) {
						$isotope_line_count = $columns;
						$case = $isotope_line_count - 1;
					}
					$dims['height'] = ($img_width * $isotope_line_count) + $pd * $case;
					break;
				case '4':
					$case = $isotope_line_count - 1;
					if ( $columns < $isotope_line_count ) {
						$isotope_line_count = $columns;
						$case = $isotope_line_count - 1;
					}
					$dims['height'] = ($img_width * $isotope_line_count) + $pd * $case;
					break;
			}
		}

		$dims['crop'] = array(
			ingenious_get_option( "crop_x" ),
			ingenious_get_option( "crop_y" )
		);
	}
	return array(
		'thumbnail_dims' => $dims,
		'isotope_col_count' => $isotope_col_count,
		'isotope_line_count' => $isotope_line_count
	);
}
function ingenious_service_filter_gallery(){
	return add_filter( 'post_gallery', 'ingenious_single_gallery', 11, 3 );
}

function ingenious_single_gallery( $output, $atts, $instance) {
	$atts = array_merge(array('columns' => 3), $atts);
	$columns = $atts['columns'];
	$columns = preg_replace( '/[^0-9,]+/', '', $columns );
	$columns = intval($columns);
	$itemwidth = $columns > 0 ?  round((100 / $columns) , 2) : 100;
	$images = explode(',', $atts['ids']);
	$selector = "gallery-{$instance}";
	$gallery_id = uniqid( 'cws-portfolio-gallery-' );
	$styles = '';
	echo apply_filters( 'gallery_style', "
		<style type='text/css'>
			#{$selector} {
				margin: auto;
			}
			#{$selector} .gallery-item {
				text-align: center;
				width: {$itemwidth}%;
			}
		</style>");
	$styles = json_encode($styles);
	$i = 0;
	$return = '';
	$return .= "<div id='$selector' data-style='".esc_attr($styles)."' class='single_gallery render_styles'>";
	foreach ($images as $key => $value) {
		if($key == 0){
			$value = str_replace("&quot;", "", $value); 
		}
		$image_attributes = wp_get_attachment_image_src($value, 'full');
		$image_id = $value;
		$real_thumbnail_dims = array();
		if ( !empty( $image_attributes ) && isset( $image_attributes[1] ) ) $real_thumbnail_dims['width'] = $image_attributes[1];
		if ( !empty(  $image_attributes ) && isset( $image_attributes[2] ) ) $real_thumbnail_dims['height'] = $image_attributes[2];
		$thumb_obj = ingenious_thumb($image_attributes[0], $real_thumbnail_dims, $image_id);
		$thumb_path_hdpi = $thumb_obj[3]['retina_thumb_exists'] ? " src='". esc_url($thumb_obj[0]) ."' data-at2x='" . esc_attr($thumb_obj[3]['retina_thumb_url']) ."'" : " src='". esc_url($thumb_obj[0]) . "' data-no-retina";
		$src = $thumb_path_hdpi;
		$return .= '
			<div class="gallery-item col_' . $columns . '">
				<a class="fancy" data-gallery="gallery" data-fancybox-group="'.$gallery_id.'" href="'.$image_attributes[0].'">
					<img '.$src.'>
				</a>
			</div>
		';
		$i++;
	}
	$return .= '</div>';
	return $return;
}

?>