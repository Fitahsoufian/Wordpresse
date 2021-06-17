<?php

if ( post_password_required() ) {
	return;
}
$p_id = get_queried_object_id ();
ob_start();
	if ( have_comments() ) {
		$comments_number = number_format_i18n( get_comments_number() );
		echo "<h2 class='comments_title'>" . esc_html__( 'Comments', 'ingenious' ) . " ($comments_number)</h2>";

		wp_list_comments( array(
			'walker' => new Ingenious_Walker_Comment(),
			'avatar_size' => 90,
		) );

		ingenious_comment_nav();

	} // have_comments()

	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( !comments_open( $p_id ) && get_comments_number() && post_type_supports( get_post_type(), 'comments' )) {
		$comments_closed = "
		<div class='ingenious_msg_box ingenious_module info closable with-icon'>
			<div class='icon_part'>
			<i class='msg_icon'></i>
				<div class='icon_shape shadow'>
					<svg viewBox='-1 0 68 67'><linearGradient gradientTransform='rotate(65)' id='shape-gradient'><stop offset='0%' stop-color='#fefefe'></stop><stop offset='100%' stop-color='#f9f8f8'></stop></linearGradient><defs><filter id='shape_5a16a10988fbc'><feGaussianBlur in='SourceAlpha' stdDeviation='4'></feGaussianBlur> <feOffset dx='2' dy='2'></feOffset><feComponentTransfer><feFuncA type='gamma' amplitude='4' exponent='7' offset='0'></feFuncA></feComponentTransfer><feMerge><feMergeNode></feMergeNode><feMergeNode in='SourceGraphic'></feMergeNode></feMerge></filter></defs><path filter='url(#shape_5a16a10988fbc)' d='M215,159.45A29.92,29.92,0,1,1,185,189.37,29.92,29.92,0,0,1,215,159.45Z' transform='translate(-183 -156.99)'></path></svg>
				</div>
			</div>
			<div class='content_part'>
				<div class='title'>".esc_html__( 'Comments are closed.', 'ingenious' )."</div>
				<p>".esc_html__( 'You are not allowed to comment on this post', 'ingenious' )."</p>
			</div>
		<a class='close_button'><span class='cross'></span></a>
		</div>
		";

		echo apply_filters( 'the_content', $comments_closed );
	}

	$comment_form_args = array(
		'label_submit' => esc_html__( 'Submit', 'ingenious' ),
		'title_reply_before' => "<h2 id='reply_title' class='comment_reply_title'>",
		'title_reply_after'	=> "</h2>"
	);
	ob_start();
	comment_form( $comment_form_args );
	$comment_form = trim( ob_get_clean() );
	echo sprintf("%s", $comment_form);

$comments_section_content = ob_get_clean();
echo !empty( $comments_section_content ) ? "<section id='comments' class='comments-area'>$comments_section_content</section>" : "";
?>
