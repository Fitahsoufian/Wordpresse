		<?php
			$pid = get_the_id();
			$p_meta = get_post_meta( $pid, 'cws_mb_post' );
			$p_meta = isset( $p_meta[0] ) ? $p_meta[0] : array();
			$p_meta['hide_footer'] = !empty($p_meta['hide_footer']) ? $p_meta['hide_footer'] : '';
			$p_meta['sb_foot_override'] = !empty($p_meta['sb_foot_override']) ? $p_meta['sb_foot_override'] : '';
			if ($p_meta['sb_foot_override'] == 1) {
				$hide_footer = $p_meta['hide_footer'];
			} else {
				$hide_footer = ingenious_get_option( "hide_footer" );
			}
			$footer_fixed_style = ingenious_get_option( 'footer_fixed_style' );

			$footer_class = '';
			$footer_class.= !ingenious_check_for_plugin( 'cws-to/cws-to.php' ) ? "default_style" : '';
			$footer_class.= $footer_fixed_style == '1' ? " footer-fixed" : "";

			echo "<div id='footer'".(!empty($footer_class) ? " class='".esc_attr($footer_class)."'" : '').">";
				if ($hide_footer == 0) {
					get_template_part( "footer-widgets" );
				}
				get_template_part( "footer-copyrights" );
			echo "</div>";

			$scroll_to_top = ingenious_get_option( "scroll_to_top" );
			if ($scroll_to_top != 'none'){
				echo ingenious_scroll_to_top();
			}

		?>		
		</div>
		<?php wp_footer(); ?>
	</body>
</html>