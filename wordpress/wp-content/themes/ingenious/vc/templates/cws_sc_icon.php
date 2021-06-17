<?php
extract( shortcode_atts( array(
	"icon"				=> "",
	"url"				=> "",
	"new_tab"			=> "",
	"title"				=> "",
	"type"				=> "simple",
	"shape"				=> "square",
	"size"				=> "2x",
	"aligning"			=> "",
	"add_hover"			=> "",
	"customize_colors"	=> "",
	"fill_color"		=> "#fff",
	"font_color"		=> INGENIOUS_THEME_COLOR,
	"el_class"			=> ""
), $atts));
$out = "";
if ( empty( $icon ) ) return $out;
$icon 				= esc_html( $icon );
$url  				= esc_url( $url );
$new_tab			= (bool)$new_tab;
$title 				= esc_html( $title );
$type 				= esc_html( $type );
$shape				= esc_html( $shape );
$size				= esc_html( $size );
$aligning			= esc_html( $aligning );
$add_hover			= (bool)$add_hover;
$customize_colors	= (bool)$customize_colors;
$fill_color			= esc_html( $fill_color );
$font_color			= esc_html( $font_color );
$el_class			= esc_attr( $el_class );
$icon_id = uniqid( "ingenious_icon_" );
$tag = !empty( $url ) ? "a" : "i";
$tag_atts = $tag == 'a' ? "$tag href='$url'" : $tag;
$tag_atts .= " id='$icon_id'";
$classes = "ingenious_icon {$icon} $type fa-$size";
$classes .= $type != "simple" ? " $shape" : "";
$classes .= !empty( $aligning ) ? " align{$aligning}" : "";
$classes .= $add_hover ? " hovered" : "";
$classes .= !empty( $el_class ) ? " $el_class" : "";
$tag_atts .= " class='$classes'";
$tag_atts .= !empty( $url ) && $new_tab ? " target='_blank'" : "";
$tag_atts .= !empty( $title ) ? " title='$title'" : "";
$out .= "<$tag_atts></$tag>";
echo sprintf("%s", $out);
?>