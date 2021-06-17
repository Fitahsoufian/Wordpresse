<?php
extract( shortcode_atts( array(
	'title' => '',
	'columns' => '',
	'bullets_nav' => '',
	'pagination' => 'arrow',
	'auto' => 0,
	'time' => '1000',
), $atts));
$has_title = !empty( $title );
$bullets_nav 	= (bool)$bullets_nav;
$auto 			= (bool)$auto;
$section_class = "ingenious_sc_carousel ingenious_module";
$section_class .= $bullets_nav ? " bullets_nav" : "";
$section_class .= $pagination ? " $pagination" : "";
$columns	= esc_html( $columns );
$section_atts = " data-columns='$columns'";
$section_atts .= !empty($auto) ? " data-time='$time'" : "";
$out = "";
if ( !empty( $content ) ){
	$out .= "<div class='$section_class'" . ( !empty( $section_atts ) ? $section_atts : "" ) . ">";
		if ( $has_title ){
			$out .= "<div class='ingenious_sc_carousel_header clearfix'>";
				$out .= "<h2>$title</h2>";				
			$out .= "</div>";
		}
		$out .= "<div class='ingenious_wrapper'>";
			if ( !$bullets_nav && $pagination == 'arrow') {
				$out .= "<div class='carousel_nav'>";
					$out .= "<span class='prev'></span>";
					$out .= "<span class='next'></span>";
				$out .= "</div>";
			}
			$out .= do_shortcode( $content );
		$out .= "</div>";
	$out .= "</div>";
}
wp_enqueue_script( 'owl_carousel' );
echo sprintf("%s", $out);

?>