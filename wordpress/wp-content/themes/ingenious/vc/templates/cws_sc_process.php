<?php
extract( shortcode_atts( array(
	'title'						=> '',
	'icon_lib'					=> '',
	'use_custom_title_color'	=> '',
	'cws_svg_icon'				=> '',
	'custom_title_color'		=> '#ffffff',
	'use_custom_bg_color'		=> '',
	'custom_bg_color'			=> '#51aea4',
	'custom_bg_color_2'			=> '#51aea4',
	'use_custom_icon_color'		=> '',
	'custom_icon_color'			=> INGENIOUS_THEME_COLOR,
	'number'					=> '',
	'use_custom_number_color'	=> '',
	'custom_number_color'		=> '#ff8447',
), $atts));
$icon_lib 					= esc_attr( $icon_lib );
$icon 						= ingenious_vc_sc_get_icon( $atts );
$icon 						= esc_attr( $icon );
$title 						= esc_html( $title );
$use_custom_title_color 	= (bool)$use_custom_title_color;
$custom_title_color			= esc_attr( $custom_title_color );
$use_custom_bg_color 		= (bool)$use_custom_bg_color;
$custom_bg_color			= esc_attr( $custom_bg_color );
$custom_bg_color_2			= esc_attr( $custom_bg_color_2 );
$use_custom_icon_color 		= (bool)$use_custom_icon_color;
$custom_icon_color			= esc_attr( $custom_icon_color );
$number 					= esc_html( $number );
$use_custom_number_color 	= (bool)$use_custom_number_color;
$custom_number_color 		= esc_attr( $custom_number_color );
$desc 						= apply_filters( 'the_content', $content );
$out = "";

$section_id = uniqid( 'ingenious_process_column_' );
$process_number = !empty( $number ) ? "<span class='process_number'" . ( $use_custom_number_color ? " style=' color: $custom_number_color;'" : "" ) . ">$number</span>" : "";
$process_number_top = !empty( $number ) ? "<div class='process_number_wrap'" . ( $use_custom_number_color ? " style=' background: $custom_number_color;'" : "" ) . "><span class='process_number'>$number</span></div>" : "";
$title_part = $desc_part = "";
$title_part .= !empty( $title ) ? "<h3 class='ingenious_process_title'" . ( $use_custom_title_color ? " style=' color: $custom_title_color;'" : "" ) . ">$title $process_number</h3>" : "";
$desc_part .= !empty( $desc ) ? "<div class='ingenious_process_desc clearfix'>$desc</div>" : "";
$cws_svg_icon = str_replace('``', '"', $cws_svg_icon);
$svg = json_decode($cws_svg_icon);
/* styles */
ob_start();
echo "#{$section_id} .ingenious_process_icon_wrap .figure_wrap > svg{
			fill: $custom_bg_color;
			stroke: $custom_bg_color_2;
		}";
/* \styles */
$styles = ob_get_clean();
$styles = json_encode($styles);

echo "<div id='$section_id' class='ingenious_process_column ingenious_module render_styles' data-style='" . esc_attr($styles) . "'>";
	echo "<div class='ingenious_process_item'>";
		echo "<div class='ingenious_process_icon_wrap'>";
			echo "<div class='ingenious_process_icon'" . ( $use_custom_icon_color ? " style=' color: $custom_icon_color;'" : "" ) . ">";
				if ( $icon_lib !== 'cws_svg' ) {
					echo "<i class='fa $icon'></i>";
				} else{
					echo cwssvg_shortcode($svg);
				}	
			echo "</div>";
			echo ingenious_figure_style();
			echo "<div class='ingenious_process_column_line'>" . $process_number_top . "</div>";
		echo  "</div>";
		echo "<div class='ingenious_process_content'>";
			echo sprintf("%s", $desc_part);
		echo "</div>";
	echo "</div>";
echo "</div>";

?>