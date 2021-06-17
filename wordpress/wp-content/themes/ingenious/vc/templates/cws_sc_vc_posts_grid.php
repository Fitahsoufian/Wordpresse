<?php
$defaults = array(
	'title'				=> '',
	'title_align'		=> 'left',
	'post_type'			=> '',
	'total_items_count'	=> esc_html( get_option( 'posts_per_page' ) ),
	'display_style'		=> 'grid',
	'items_pp'			=> esc_html( get_option( 'posts_per_page' ) ),
	'el_class'			=> '',
);
$proc_atts = shortcode_atts( $defaults, $atts );
extract( $proc_atts );
$out = "";
if ( empty( $post_type ) ) return $out;
$portfolio_layout = isset( $atts['portfolio_layout'] ) && !empty( $atts['portfolio_layout'] ) ? $atts['portfolio_layout'] : 'def';
$portfolio_show_data_override = isset( $atts['portfolio_show_data_override'] ) && !empty( $atts['portfolio_show_data_override'] ) ? $atts['portfolio_show_data_override'] : false;
$portfolio_data_to_show = isset( $atts['portfolio_data_to_show'] ) && !empty( $atts['portfolio_data_to_show'] ) ? $atts['portfolio_data_to_show'] : "";
$staff_layout = isset( $atts['staff_layout'] ) && !empty( $atts['staff_layout'] ) ? $atts['staff_layout'] : 'def';
$staff_hide_meta_override = isset( $atts['staff_hide_meta_override'] ) && !empty( $atts['staff_hide_meta_override'] ) ? $atts['staff_hide_meta_override'] : false;
$staff_data_to_hide = isset( $atts['staff_data_to_hide'] ) && !empty( $atts['staff_data_to_hide'] ) ? $atts['staff_data_to_hide'] : "";
$tax = isset( $atts[$post_type . '_tax'] ) ? $atts[$post_type . '_tax'] : '';
$terms = isset( $atts["{$post_type}_{$tax}_terms"] ) ? $atts["{$post_type}_{$tax}_terms"] : "";
$proc_atts = array_merge( $proc_atts, array(
	'portfolio_layout'						=> $portfolio_layout,
	'portfolio_show_data_override'			=> $portfolio_show_data_override,
	'portfolio_data_to_show'				=> $portfolio_data_to_show,
	'staff_layout'							=> $staff_layout,
	'staff_hide_meta_override'				=> $staff_hide_meta_override,	
	'staff_data_to_hide'					=> $staff_data_to_hide,
	'tax'									=> $tax,
	'terms'									=> $terms
));
$out .= function_exists( "ingenious_posts_grid" ) ? ingenious_posts_grid( $proc_atts ) : "";
echo sprintf("%s", $out);
?>