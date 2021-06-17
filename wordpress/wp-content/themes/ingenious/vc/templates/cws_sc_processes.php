<?php
extract( shortcode_atts( array(
	"title"				=> ""
), $atts));
$out = "";

echo "<div class='cws_sc_processes_wrap'>" . do_shortcode( $content ) . "</div>";

?>