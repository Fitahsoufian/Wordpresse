<?php
if ( is_page() ){
	$footer_sb = ingenious_get_page_meta_var ( array( 'footer', 'footer_sb_top' ) );
}
else{
	$footer_sb = ingenious_get_option( 'footer_sb' );
}
if ( is_active_sidebar( $footer_sb ) ){
	echo "<section id='footer_widgets'>";
		echo "<div class='footer_wrapper'></div>";
		echo "<div class='ingenious_layout_container'>";
			echo "<ul id='footer_widgets_container'>";
				dynamic_sidebar( $footer_sb );
			echo "</ul>";
		echo "</div>";
	echo "</section>";
}
?>