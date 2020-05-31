<?php
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php comments_number( '0 comment.', '1 comment.', '% comments.' ); ?>
		</h3>

		<ol class="comment-list">
			<?php wp_list_comments( array( 'avatar_size' => 60 ) ); ?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav id="comment-nav-below" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'dw-kido' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'dw-kido' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'dw-kido' ) ); ?></div>
		</nav>
		<?php endif; ?>

	<?php endif; ?>

	<?php if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'dw-kido' ); ?></p>
	<?php endif; ?>

	<?php
		comment_form( array(
			'format' => 'html5',
			'comment_notes_after' => '',
			'title_reply' => __( 'Leave a comment.', 'dw-kido' ),
			'title_reply_to' => __( 'Leave a comment to %s', 'dw-kido' ),
			'comment_field' =>  '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . ' <span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true">' . '</textarea></p>',
		) );
	?>

</div>
