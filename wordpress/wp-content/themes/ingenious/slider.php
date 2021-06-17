<?php
	$is_revslider_active = ingenious_check_for_plugin( 'revslider/revslider.php' );
	$slider_type = 'none';
	if ( is_front_page() ) {
		$slider_type = ingenious_get_option( 'home_slider_type' );
		switch ( $slider_type ) {
			case 'img_slider':
				if ( is_page() ) {
					$slider_settings = ingenious_get_page_meta_var( 'slider' );
					if ( isset( $slider_settings['slider_override'] ) && $slider_settings['slider_override'] ) {
						$slider_shortcode = isset( $slider_settings['slider_shortcode'] ) ? $slider_settings['slider_shortcode'] : "";
					} else {
						$slider_shortcode = ingenious_get_option( 'home_slider_shortcode' );
					}
				} else{
					$slider_shortcode = ingenious_get_option( 'home_slider_shortcode' );
				}
				if ( !empty( $slider_shortcode ) ){
					echo "<div id='main_slider'>";
						echo do_shortcode( wp_specialchars_decode( $slider_shortcode, ENT_QUOTES ) );
					echo "</div>";
				}
				break;
			case 'video_slider':
				$video_settings = ingenious_get_option( 'video_section' );
				extract( shortcode_atts( array(
					'slider_switch' => false,
					'slider_shortcode' => '',
					'set_video_header_height' => false,
					'video_header_height' => '600',
					'video_type' => 'self_hosted',
					'sh_source' => array(),
					'youtube_source' => '',
					'vimeo_source' => '',
					'use_pattern' => false,
					'pattern_image' => array(),
					'overlay_type' => 'none',
					'overlay_color' => '',
					'overlay_opacity' => '40',
					'overlay_gradient_settings' => array()
				), $video_settings));
				$sh_source = isset( $sh_source['src'] ) && ! empty( $sh_source['src'] ) ? esc_url( $sh_source['src'] ) : '';
				$overlay_opacity = (int)$overlay_opacity / 100;				
				$has_video_src = false;
				$header_video_atts = '';
				$header_video_class = 'video_bg';
				$header_video_html = '';
				$uniqid = uniqid( 'video-' );
				$uniqid_esc = esc_attr( $uniqid );
				switch ( $video_type ) {
					case 'self_hosted':
						if ( ! empty( $sh_source ) ) {
							$has_video_src = true;
							$header_video_class .= ' cws_self_hosted_video';
							$header_video_html .= "<video class='self_hosted_video' src='$sh_source' autoplay='autoplay' loop='loop' muted='muted'></video>";
						}
						break;
					case 'youtube':
						if ( ! empty( $youtube_source ) ) {
							$has_video_src = true;
							$header_video_class .= ' cws_Yt_video_bg loading';
							$header_video_atts .= " data-video-source='$youtube_source' data-video-id='$uniqid_esc'";
							$header_video_html .= "<div id='$uniqid_esc'></div>";
						}
						break;
					case 'vimeo':
						if ( ! empty( $vimeo_source ) ) {
							$has_video_src = true;
							$header_video_class .= ' cws_Vimeo_video_bg';
							$header_video_atts .= " data-video-source='$vimeo_source' data-video-id='$uniqid'";
							$header_video_html .= "<iframe id='$uniqid_esc' src='" . esc_url( $vimeo_source . "?api=1&player_id=$uniqid"  ) . "' ></iframe>";
						}
						break;
				}
				if ( $use_pattern && ! empty( $pattern_image ) && isset( $pattern_image['url'] ) && !empty( $pattern_image['url'] ) ) {
					$pattern_img_src = esc_url( $pattern_image['url'] );
					$header_video_html .= "<div class='bg_layer' style='background-image:url(" . $pattern_img_src . ")'></div>";
				}
				if ( $overlay_type == 'color' ){
					$header_video_html .= "<div class='bg_layer' style='background-color:" . esc_attr( $overlay_color ) . ';' . ( ! empty( $overlay_opacity ) ? "opacity:$overlay_opacity;" : '' ) . "'></div>";
				}
				else if ( $overlay_type == 'gradient' ){
					$gradient_rules = ingenious_render_gradient_rules (
						array(
							'settings' => $overlay_gradient_settings
					));
					if ( !empty( $gradient_rules ) ){
						$header_video_html .= "<div class='bg_layer' style='" . esc_attr( $gradient_rules ) . ( ! empty( $overlay_opacity ) ? "opacity:$overlay_opacity;" : '' ) . "'></div>";
					}
				}
				$header_video_atts .= ! empty( $header_video_class ) ? " class='" .  trim( $header_video_class ) . "'" : '';
				if ( !empty( $slider_shortcode ) && $has_video_src && $slider_switch == 1 ) {
					echo "<div id='main_slider_video'>";
					if ( $is_revslider_active ) {
						echo  do_shortcode( wp_specialchars_decode( $slider_shortcode, ENT_QUOTES ) );
						echo '<div ' . $header_video_atts . '>';
							echo sprintf("%s", $header_video_html);
						echo '</div>';
					} else {
						echo do_shortcode( "[cws_sc_msg_box type='warn' is_closable='1']Install and activate Slider Revolution plugin[/cws_sc_msg_box]" );
					}
					echo '</div>';
				} elseif ( $has_video_src && ( $slider_switch == 0 || empty( $slider_shortcode ) ) ) {
					$video_height_coef = 960 / $video_header_height;
					echo "<div id='main_slider_video' style='height:" . esc_attr( $video_header_height ) . "px' data-wrapper-height='" . esc_attr( $video_height_coef ) . "'>";
					echo '<div ' . $header_video_atts . '>';
					echo sprintf("%s", $header_video_html);
					echo '</div>';
					echo '</div>';
					$header_after_slider = true;
				} elseif ( !empty( $slider_shortcode ) && $slider_switch == 1 && !$has_video_src ) {
					if ( $is_revslider_active ) {
						echo  do_shortcode( wp_specialchars_decode( $slider_shortcode, ENT_QUOTES ) );
					} else {
						echo do_shortcode( "[cws_sc_msg_box type='warn' is_closable='1']Install and activate Slider Revolution plugin[/cws_sc_msg_box]" );
					}
					$header_after_slider = true;
				}
					break;
			case 'stat_img_slider':
				$image_options = ingenious_get_option( 'static_img_section' );
				extract( shortcode_atts( array(
					'static_img' => array()
				), $image_options));
				$stat_img_atts = " id='main_slider_img'";
				$img_src = !empty( $static_img['src'] ) ? $static_img['src'] : "";
				if ( !empty( $img_src ) ) {
					$img_src = esc_url( $img_src );
					echo "
						<div" . ( !empty( $stat_img_atts ) ? $stat_img_atts : "" ) . ">
                            <img src='$img_src' alt />
						</div>";
				}
				break;
		}
	} else if ( is_page() ) {
		$slider_settings = ingenious_get_page_meta_var( "slider" );
		$slider_override = $slider_settings['slider_override'];
		$slider_shortcode = $slider_settings['slider_shortcode'];
		if ( $slider_override && !empty( $slider_shortcode ) ){
			echo "<div id='main_slider'>";
				echo do_shortcode( wp_specialchars_decode( $slider_shortcode, ENT_QUOTES ) );
			echo "</div>";
		}
	} else if ( is_single() ) {
		$post_meta = get_post_meta( get_the_ID(), 'cws_mb_post' );
		$post_meta = isset( $post_meta[0] ) ? $post_meta[0] : array();
		$rev_url = isset( $post_meta['rev_slider_type']['rev_url'] ) ? $post_meta['rev_slider_type']['rev_url'] : '';
		if ( !empty( $rev_url ) ){
			echo "<div id='single_slider'>";
				echo do_shortcode( wp_specialchars_decode( $rev_url, ENT_QUOTES ) );
			echo "</div>";
		}
	}
	
?>