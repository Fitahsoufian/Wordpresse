<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php do_action( 'ingenious_header_meta' ); ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php
		$boxed_layout = ingenious_get_option( "boxed_layout" );
		echo "<div id='document'" . ($boxed_layout ? " class='boxed'" : "") . ">";
			ingenious_header();
	?>