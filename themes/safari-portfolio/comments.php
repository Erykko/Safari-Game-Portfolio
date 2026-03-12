<?php
/**
 * Comments template. Included where comments are allowed.
 *
 * @package Safari_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$safari_portfolio_comment_count = get_comments_number();
			printf(
				/* translators: 1: number of comments */
				esc_html( _n( '%1$s comment', '%1$s comments', $safari_portfolio_comment_count, 'safari-portfolio' ) ),
				(int) $safari_portfolio_comment_count
			);
			?>
		</h2>
		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 60,
			) );
			?>
		</ol>
		<?php the_comments_navigation(); ?>
	<?php endif; ?>
	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'safari-portfolio' ); ?></p>
	<?php endif; ?>
	<?php
	comment_form( array(
		'title_reply'          => esc_html__( 'Leave a Reply', 'safari-portfolio' ),
		'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'safari-portfolio' ),
		'cancel_reply_link'    => esc_html__( 'Cancel Reply', 'safari-portfolio' ),
		'label_submit'         => esc_html__( 'Post Comment', 'safari-portfolio' ),
	) );
	?>
</div>
