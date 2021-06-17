<?php
extract( shortcode_atts( array(
	'icon'				=> '',
	'number'			=> '',
	'title'				=> '',
	'speed'				=> '',
	'alt'				=> '',
	'use_custom_color'	=> '',
	'custom_color'		=> '',
	'el_class'			=> ''
), $atts));
$icon 				= esc_attr( $icon );
$number				= esc_html( $number );
$title 				= esc_html( $title );
$speed				= esc_html( $speed );
$alt 				= (bool)$alt;
$use_custom_color 	= (bool)$use_custom_color;
$custom_color 		= esc_attr( $custom_color );
$el_class			= esc_attr( $el_class );
$out = "";
if ( empty( $number ) || !is_numeric( $number ) ) return $out;
wp_enqueue_script( 'odometer' );
$out .= "<div class='ingenious_milestone ingenious_module" . ( !empty( $el_class ) ? " $el_class" : "" ) . ( $alt ? " milestone-alt" : "" ) . "'" . ">";
	$out .= "<div class='ingenious_milestone_background'" . ( $use_custom_color && !empty( $custom_color ) && $alt ? " style='fill: $custom_color;'" : "" ) . ">" . ingenious_figure_style( $alt ) . "</div>";
	$out .= "<div class='ingenious_milestone_content'>";
		$out .= !empty( $icon ) ? "<div class='ingenious_milestone_icon'" . ( $use_custom_color && !empty( $custom_color ) && !$alt ? " style='background: transparent; color: $custom_color;'" : "" ) . "><i class='$icon'></i></div>" : "";
		$out .= "<div class='ingenious_milestone_number'" . ( !empty( $speed ) && is_numeric( $speed ) ? " data-speed='$speed'" : "" ) . ">$number</div>";
		$out .= !empty( $title ) ? "<h6 class='ingenious_milestone_title'>$title</h6>" : "";
	$out .= "</div>";	
$out .= "</div>";
echo sprintf("%s", $out);
?>