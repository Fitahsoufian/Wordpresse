<?php
$copyrights_text = ingenious_get_option( "copyrights_text" );
$social_location = ingenious_get_option( 'social_location' );
$social_links = ingenious_render_social_links ();
$show_social_in_cprs = in_array( $social_location, array( 'bottom', 'both' ) ) && !empty( $social_links );
$is_wpml_active = ingenious_is_wpml_active ();
$show_flags_in_footer = ingenious_show_flags_in_footer ();
$show_wpml_footer = ( ingenious_is_wpml_active() ) ? true : false;
$copyrights_text = empty($copyrights_text) ? esc_html__( "Ingenious - Smart Home Automation WordPress Theme", 'ingenious' ) : $copyrights_text;

$flags = '';
if ( function_exists('wpml_init_language_switcher') ) {
	global $wpml_language_switcher;
	$slot = $wpml_language_switcher->get_slot( 'statics', 'footer' ); 
	$template = $slot->get_model();
	$flags = $slot->is_enabled();
}
echo "<footer id='site_footer'".(!ingenious_check_for_plugin( 'cws-to/cws-to.php' ) ? " class='default_style'" : '').">";
	echo "<div class='ingenious_layout_container clearfix'>";

		if ( $show_wpml_footer ){

			$class_wpml = '';
			if(isset($template['template']) && !empty($template['template'])){
				if($template['template'] == 'wpml-legacy-vertical-list'){
					$class_wpml = 'wpml_language_switch lang_bar '. $template['template'];
				}
				else{
					$class_wpml = 'wpml_language_switch horizontal_bar '.$template['template'];
				}      
			} else{
				$class_wpml = 'lang_bar';
			}
			ob_start();
				do_action( 'wpml_footer_language_selector');				
			$wpml_footer_result = ob_get_clean();

			if ( $show_wpml_footer && !empty($flags) && !empty($wpml_footer_result) ) : ?>
				<div class="<?php echo esc_attr($class_wpml);?>">
					<?php 
					echo sprintf("%s", $wpml_footer_result);

					?>
				</div>
			<?php endif;
		}
		if ( $social_location !== 'none') {
			echo !empty($show_social_in_cprs) ? "<div id='footer_social' class='ingenious_social'>" . wp_kses( $social_links, array(
				'a' 	=> array(
			    	'class'	=> array(),					
				    'href'	=> array(),
				    'title' => array()
			    ),
			    'i' 	=> array(
			    	'class'	=> array()
			    )
			)) . "</div>" : "";
		}
		echo !empty( $copyrights_text ) ? "<div id='site_copyrights'>" . wp_kses( $copyrights_text, array(
			'a' 	=> array(
			    'href'	=> array(),
			    'title' => array()
		    ),
		    'span' 	=> array(),
		    'p' 	=> array(),
		    'i' 	=> array(
		    	'class'	=> array()
		    ),
		    'br' 	=> array(),
		    'center' 	=> array(),
		    'em' 	=> array(),
		    'strong'=> array(),
		)) . "</div>" : "";
	echo "</div>";
echo "</footer>";


?>