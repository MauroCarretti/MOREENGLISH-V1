<?php

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

extract( $args );

global $post;
$rating = intval( get_comment_meta( $comment->comment_ID, 'ss_rating', true ) );
$commenter = wp_get_current_commenter();
if ( $commenter['comment_author_email'] ) :
	$moderation_note = __( 'Your comment is awaiting moderation.', 'edublink' );
else :
	$moderation_note = __( 'Your comment is awaiting moderation. This is a preview, your comment will be visible after it has been approved.', 'edublink' );
endif;

?>
<li <?php comment_class( 'edublink-comment-item' ); ?> id="li-comment-<?php comment_ID() ?>">
	<article id="comment-<?php comment_ID(); ?>" class="edublink-single-comment <?php echo esc_attr( get_avatar($comment) ? 'edublink-comment-has-avatar' : 'edublink-comment-no-avatar' ); ?>">
		<div class="edublink-comment-each-item">
			<?php if ( get_avatar( $comment ) && 0 != $args['avatar_size'] ): ?>
				<div class="edublink-comment-avatar">
					<a href="<?php echo esc_url( esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ); ?>" class="edublink-media-object">
						<?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
					</a>
				</div>
			<?php endif; ?>

			<div class="edublink-media-body">
				<div class="edublink-comment-header">
					<div class="edublink-media-heading">
						<?php if ( empty($comment->comment_parent) ) : ?>
							<div class="eb-star-rating-content" title="<?php echo sprintf( esc_attr__( 'Rated %d out of 5', 'edublink' ), $rating ) ?>">
								<?php EduBlink_SS_Course_Review::display_review( $rating ); ?>
							</div>
						<?php endif; ?>

						<h4 class="edublink-media-heading"><?php comment_author(); ?></h4> 
						<span class="comment-metadata">
							<a class="edublink-comment-time" href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
								<time datetime="<?php esc_attr( comment_time( 'c' ) ); ?>">
									<?php 
										printf(
											__( '%1$s at %2$s', 'edublink' ), get_comment_date(), get_comment_time()
										);

										edit_comment_link( __( '(Edit)', 'edublink' ), '  ', '' );
									?>
								</time>
							</a>
						</span>
					</div>
				</div>

				<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation label label-info"><?php echo esc_html( $moderation_note ); ?></p>
				<?php endif; ?>

				<div class="comment-content">
					<?php comment_text(); ?>
				</div>

				<div class="edublink-comment-bottom-part">
					<?php 
						echo get_comment_reply_link(
							array(
								'depth'      => $depth,
								'max_depth'  => $args['max_depth'],
								'reply_text' => sprintf( '<i class="ri-reply-all-line"></i> %s', __( 'Reply', 'edublink' ) )
							),
							$comment->comment_ID,
							$comment->comment_post_ID
						);
					?>
				</div>
			</div>
		</div>
	</article>
</li>
