<?php
	get_header();
	$home_url = get_site_url();
	?>
	<div id='page'>
		<div class='ingenious_layout_container'>
			<main id='page_content'>
				<section id='banner_404_section'>
					<div class='ingenious_layout_container'>
						<div id='banner_404'>
							<span id='banner_404_top'><?php echo esc_html__( '404', 'ingenious' ); ?></span>
							<h3 id='banner_404_title'>
								<?php echo esc_html__( 'Page not found', 'ingenious' ); ?>
							</h3>
							<p><?php echo esc_html__( "The page you are looking for does not exist. It may have been moved, or removed altogether. Perhaps you can return back to the site's homepage and see if you can find what you are looking for.", "ingenious" ); ?></p>
							<div id='banner_404_away'>
								<?php echo "<a href='$home_url' class='ingenious_button regular'>" . esc_html__( 'Homepage', 'ingenious' ) . "</a>"; ?>
							</div>
						</div>
					</div>
				</section>
			</main>
		</div>
	</div>
	<?php
	get_footer();
?>