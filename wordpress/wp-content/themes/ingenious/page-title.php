<?php
$p_id = get_queried_object_id ();
$post_type = get_post_type ( $p_id );
$pid = get_the_id();
$p_meta = get_post_meta( $pid, 'cws_mb_post' );
$p_meta = isset( $p_meta[0] ) ? $p_meta[0] : array();
$title = ingenious_get_page_title($post_type);
ob_start();
ingenious_dimox_breadcrumbs();
$breadcrumbs = ob_get_clean();
$page_title_content = "";
if ( !empty( $title ) ){
	$page_title_spacings = ingenious_get_option( 'page_title_spacings' );
	if (function_exists('is_woocommerce')) {
		if (is_woocommerce()) {
			$page_title_spacings = ingenious_get_option( 'woo_page_title_spacings' );
		}
	}
	$page_title_content_styles = "";
	if ( is_array( $page_title_spacings ) ){
		foreach ( $page_title_spacings as $key => $value ){
			$page_title_content_styles .= $value !== '' && is_numeric($value) ? "padding-$key:{$value}px; " : '';
		}
	}
	$page_title_content .= "<h1 id='page_title'>";
		$page_title_content .= esc_html( $title );
	$page_title_content .= "</h1>";
}
if ( !empty( $breadcrumbs ) ){
	$page_title_content .= $breadcrumbs;
}
$p_meta['hide_title'] = !empty($p_meta['hide_title']) ? $p_meta['hide_title'] : '';
$p_meta['header_override'] = !empty($p_meta['header_override']) ? $p_meta['header_override'] : '';
$p_meta['header_sep'] = !empty($p_meta['header_sep']) ? $p_meta['header_sep'] : '';
$header_sep = !empty($p_meta['header_override']) ? $p_meta['header_sep'] : ingenious_get_option('header_sep');
if ($p_meta['header_override'] == 1) {
	$hide_title = $p_meta['hide_title'];
} else {
	$hide_title = ingenious_get_option( "hide_title" );
}
if (function_exists('is_woocommerce')) {
		if (is_woocommerce()) {
		$hide_title = ingenious_get_option( "woo_hide_title" );
	}
}
$header_left_overlay = '';
$header_right_overlay = '';
$header_left_layer = '';
$header_right_layer = '';
$clip_bg = '';
if ($header_sep == 1) {
	if ($p_meta['header_sep'] == 1) {
		$header_crossing = !empty($p_meta['header_crossing']) ? $p_meta['header_crossing'] : '50';
		$header_crop = !empty($p_meta['header_crop']) ? $p_meta['header_crop'] : array('left_crop');
		$header_left_crop = in_array( 'left_crop', $header_crop) ? true : false;
		$header_right_crop = in_array( 'right_crop', $header_crop) ? true : false;
		$header_center_crop = in_array( 'center_crop', $header_crop) ? true : false;
		$header_left_overlay = ($p_meta['header_left_overlay'] == 1) ? true : false;
		$header_right_overlay = ($p_meta['header_right_overlay'] == 1) ? true : false;
		$header_left_layer = ($p_meta['header_left_layer'] == 1) ? true : false;
		$header_right_layer = ($p_meta['header_right_layer'] == 1) ? true : false;
		if ($header_left_overlay) {
			$header_left_overlay_color = $p_meta['header_left_overlay_color'];
			$header_left_overlay_opacity = $p_meta['header_left_overlay_opacity'];
		}
		if ($header_right_overlay) {
			$header_right_overlay_color = $p_meta['header_right_overlay_color'];
			$header_right_overlay_opacity = $p_meta['header_right_overlay_opacity'];
		}
		if ($header_left_layer) {
			$left_points = $p_meta['header_left_layer_box']['points'];
			$top_left_crossing_x = '50';
			$bot_left_crossing_x = $header_crossing;
			$bot_left_crossing_y = 'calc(100% - 60px)';
			if ($left_points == 1) {
				$left_top_point = $p_meta['header_left_layer_box']['top_point'];
				$left_bot_point = $p_meta['header_left_layer_box']['bot_point'];
				$top_left_crossing_x = $left_top_point;
				$bot_left_crossing_x = $left_bot_point;
				$bot_left_crossing_y = '100%';
			}
			$left_bg_type = $p_meta['header_left_layer_box']['bg'];
			if ($left_bg_type == 'color') {
				$left_color = $p_meta['header_left_layer_box']['color'];
				$left_color_opacity = $p_meta['header_left_layer_box']['color_opacity'];
			} else{
				$left_from_color = $p_meta['header_left_layer_box']['gradient_from'];
				$left_from_opacity = $p_meta['header_left_layer_box']['from_opacity'];
				$left_to_color = $p_meta['header_left_layer_box']['gradient_to'];
				$left_to_opacity = $p_meta['header_left_layer_box']['to_opacity'];
				$left_angle = !empty($p_meta['header_left_layer_box']['gradient_angle']) ? $p_meta['header_left_layer_box']['gradient_angle'] : '45';
			}
		}
		if ($header_right_layer) {
			$right_points = $p_meta['header_right_layer_box']['points'];
			$top_right_crossing_x = '50';
			$bot_right_crossing_x = $header_crossing;
			$bot_right_crossing_y = 'calc(100% - 60px)';
			if ($right_points == 1) {
				$right_top_point = $p_meta['header_right_layer_box']['top_point'];
				$right_bot_point = $p_meta['header_right_layer_box']['bot_point'];
				$top_right_crossing_x = $right_top_point;
				$bot_right_crossing_x = $right_bot_point;
				$bot_right_crossing_y = '100%';
			}
			$right_bg_type = $p_meta['header_right_layer_box']['bg'];
			if ($right_bg_type == 'color') {
				$right_color = $p_meta['header_right_layer_box']['color'];
				$right_color_opacity = $p_meta['header_right_layer_box']['color_opacity'];
			} else{
				$right_from_color = $p_meta['header_right_layer_box']['gradient_from'];
				$right_from_opacity = $p_meta['header_right_layer_box']['from_opacity'];
				$right_to_color = $p_meta['header_right_layer_box']['gradient_to'];
				$right_to_opacity = $p_meta['header_right_layer_box']['to_opacity'];
				$right_angle = !empty($p_meta['header_right_layer_box']['gradient_angle']) ? $p_meta['header_right_layer_box']['gradient_angle'] : '45';
			}
		}
	} else if (ingenious_get_option('header_sep') == 1) {
		$header_crossing = ingenious_get_option('header_crossing');
		$header_crossing = !empty($header_crossing) ? $header_crossing : '50';
		$header_crop = ingenious_get_option('header_crop');
		$header_crop = !empty($header_crop) ? $header_crop : array('left_crop');
		$header_left_crop = in_array( 'left_crop', $header_crop) ? true : false;
		$header_right_crop = in_array( 'right_crop', $header_crop) ? true : false;
		$header_center_crop = in_array( 'center_crop', $header_crop) ? true : false;
		$header_left_overlay = (ingenious_get_option('header_left_overlay') == 1) ? true : false;
		$header_right_overlay = (ingenious_get_option('header_right_overlay') == 1) ? true : false;
		$header_left_layer = (ingenious_get_option('header_left_layer') == 1) ? true : false;
		$header_right_layer = (ingenious_get_option('header_right_layer') == 1) ? true : false;
		if ($header_left_overlay) {
			$header_left_overlay_color = ingenious_get_option('header_left_overlay_color');
			$header_left_overlay_opacity = ingenious_get_option('header_left_overlay_opacity');
		}
		if ($header_right_overlay) {
			$header_right_overlay_color = ingenious_get_option('header_right_overlay_color');
			$header_right_overlay_opacity = ingenious_get_option('header_right_overlay_opacity');
		}
		if ($header_left_layer) {
			$left_points = ingenious_get_option('header_left_layer_box')['points'];
			$top_left_crossing_x = '50';
			$bot_left_crossing_x = $header_crossing;
			$bot_left_crossing_y = 'calc(100% - 60px)';
			if ($left_points == 1) {
				$left_top_point = ingenious_get_option('header_left_layer_box')['top_point'];
				$left_bot_point = ingenious_get_option('header_left_layer_box')['bot_point'];
				$top_left_crossing_x = $left_top_point;
				$bot_left_crossing_x = $left_bot_point;
				$bot_left_crossing_y = '100%';
			}
			$left_bg_type = ingenious_get_option('header_left_layer_box')['bg'];
			if ($left_bg_type == 'color') {
				$left_color = ingenious_get_option('header_left_layer_box')['color'];
				$left_color_opacity = ingenious_get_option('header_left_layer_box')['color_opacity'];
			} else{
				$left_from_color = ingenious_get_option('header_left_layer_box')['gradient_from'];
				$left_from_opacity = ingenious_get_option('header_left_layer_box')['from_opacity'];
				$left_to_color = ingenious_get_option('header_left_layer_box')['gradient_to'];
				$left_to_opacity = ingenious_get_option('header_left_layer_box')['to_opacity'];
				$gradient_angle = ingenious_get_option('header_left_layer_box')['gradient_angle'];
				$left_angle = !empty($gradient_angle) ? $gradient_angle : '45';
			}
		}
		if ($header_right_layer) {
			$right_points = ingenious_get_option('header_right_layer_box')['points'];
			$top_right_crossing_x = '50';
			$bot_right_crossing_x = $header_crossing;
			$bot_right_crossing_y = 'calc(100% - 60px)';
			if ($right_points == 1) {
				$right_top_point = ingenious_get_option('header_right_layer_box')['top_point'];
				$right_bot_point = ingenious_get_option('header_right_layer_box')['bot_point'];
				$top_right_crossing_x = $right_top_point;
				$bot_right_crossing_x = $right_bot_point;
				$bot_right_crossing_y = '100%';
			}
			$right_bg_type = ingenious_get_option('header_right_layer_box')['bg'];
			if ($right_bg_type == 'color') {
				$right_color = ingenious_get_option('header_right_layer_box')['color'];
				$right_color_opacity = ingenious_get_option('header_right_layer_box')['color_opacity'];
			} else{
				$right_from_color = ingenious_get_option('header_right_layer_box')['gradient_from'];
				$right_from_opacity = ingenious_get_option('header_right_layer_box')['from_opacity'];
				$right_to_color = ingenious_get_option('header_right_layer_box')['gradient_to'];
				$right_to_opacity = ingenious_get_option('header_right_layer_box')['to_opacity'];
				$gradient_angle = ingenious_get_option('header_right_layer_box')['gradient_angle'];
				$right_angle = !empty($gradient_angle) ? $gradient_angle : '45';
			}
		}
	}
	if ($header_left_layer) {
		$left_color_opacity = isset($left_color_opacity) ? strval( (int)$left_color_opacity / 100 ) : "";
		$left_from_opacity = isset($left_from_opacity) ? strval( (int)$left_from_opacity / 100 ) : "";
		$left_to_opacity = isset($left_to_opacity) ? strval( (int)$left_to_opacity / 100 ) : "";
		if ($left_bg_type == 'color') {
			$clip_bg_left_color = "background:rgba(" . ingenious_Hex2RGBA( $left_color, $left_color_opacity ) . ")";
		} else {
			$clip_bg_left_color = "background:linear-gradient(" . $left_angle . "deg, rgba(" . ingenious_Hex2RGBA( $left_from_color, $left_from_opacity ) . "), rgba(" . ingenious_Hex2RGBA( $left_to_color, $left_to_opacity ) . "))";
		}
		$clip_bg_left = "clip-path: polygon( 0 0, " . $top_left_crossing_x . "% 0, " . $bot_left_crossing_x . "% " . $bot_left_crossing_y . ", 0 100% );";
	}
	if ($header_right_layer) {
		$right_color_opacity = isset($right_color_opacity) ? strval( (int)$right_color_opacity / 100 ) : "";
		$right_from_opacity = isset($right_from_opacity) ? strval( (int)$right_from_opacity / 100 ) : "";
		$right_to_opacity = isset($right_to_opacity) ? strval( (int)$right_to_opacity / 100 ) : "";
		if ($right_bg_type == 'color') {
			$clip_bg_right_color = "background:rgba(" . ingenious_Hex2RGBA( $right_color, $right_color_opacity ) . ")";
		} else {
			$clip_bg_right_color = "background:linear-gradient(" . $right_angle . "deg, rgba(" . ingenious_Hex2RGBA( $right_from_color, $right_from_opacity ) . "), rgba(" . ingenious_Hex2RGBA( $right_to_color, $right_to_opacity ) . "))";
		}
		$clip_bg_right = "clip-path: polygon(" . $top_right_crossing_x . "% 0, 100% 0, 100% 100%, " . $bot_right_crossing_x . "% " . $bot_right_crossing_y . ");";
	}
	$p_3 = '100% 100%';
	$p_4 = $header_crossing . '% calc(100% - 60px)';
	$p_5 = '0% 100%';
	if ($header_left_crop){
		$p_3 = '100% 100%';
		$p_5 = '0% calc(100% - 120px)';
	}
	if ($header_right_crop){
		$p_3 = '100% calc(100% - 120px)';
		$p_5 = '0% 100%';
	}
	if ($header_left_crop && $header_right_crop) {
		$p_3 = '100% calc(100% - 120px)';
		$p_5 = '0% calc(100% - 120px)';
	}
	$clip_bg = "style='clip-path: polygon( 0 0, 100% 0, $p_3, $p_4, $p_5);padding-bottom:60px; -webkit-clip-path: polygon( 0 0, 100% 0, $p_3, $p_4, $p_5);padding-bottom:60px;'";
	if ($header_left_overlay) {
		$left_overlay_opacity = strval( (int)$header_left_overlay_opacity / 100 );
		$clip_left = "clip-path: polygon(0% calc(100% - 120px), " . $header_crossing . "% calc(100% - 60px), 0% 100%); -webkit-clip-path: polygon(0% calc(100% - 120px), " . $header_crossing . "% calc(100% - 60px), 0% 100%);";
		$clip_left_color = " background-color:rgba(" . ingenious_Hex2RGBA( $header_left_overlay_color, $left_overlay_opacity ) . ");";
	}
	if ($header_right_overlay) {
		$right_overlay_opacity = strval( (int)$header_right_overlay_opacity / 100 );
		$clip_right = "clip-path: polygon(" . $header_crossing . "% calc(100% - 60px), 100% calc(100% - 120px), 100% 100%); -webkit-clip-path: polygon(" . $header_crossing . "% calc(100% - 60px), 100% calc(100% - 120px), 100% 100%);";
		$clip_right_color = " background-color:rgba(" . ingenious_Hex2RGBA( $header_right_overlay_color, $right_overlay_opacity ) . ");";
	}
}
if ($hide_title == 0) {
	if ( !empty( $page_title_content ) ){
		echo "<section id='page_title_section'>";
			if ($header_left_overlay) {
				echo "<div class='cws-triangle-overlay' style='$clip_left $clip_left_color padding-bottom:60px;'></div>";
			}
			echo "<div id='header_img_bg'".(!ingenious_check_for_plugin( 'cws-to/cws-to.php' ) ? " class='default_style'" : '' )." $clip_bg>";
				if ($header_left_layer) {
					echo "<div class='cws-triangle-overlay' style='$clip_bg_left $clip_bg_left_color'></div>";
				}
				if ($header_right_layer) {
					echo "<div class='cws-triangle-overlay' style='$clip_bg_right $clip_bg_right_color'></div>";
				}
			echo "</div>";
			if ($header_right_overlay) {
				echo "<div class='cws-triangle-overlay' style='$clip_right $clip_right_color padding-bottom:60px;'></div>";
			}
			echo "<div class='ingenious_layout_container'>";
				echo "<div class='page_title_content'" . ( !empty( $page_title_content_styles ) ? " style='$page_title_content_styles'" : "" ) . ">";
					echo sprintf("%s", $page_title_content);
				echo "</div>";
			echo "</div>";
		echo "</section>";
	}
}
?>