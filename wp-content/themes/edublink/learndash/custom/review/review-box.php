<?php

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

if ( ! comments_open() ) :
	return;
endif;

global $post;
$all_rating = EduBlink_LD_Course_Review::get_average_ratings( $post->ID );
$ratings = EduBlink_LD_Course_Review::get_detail_ratings( $post->ID );
$all = EduBlink_LD_Course_Review::get_all_reviews( $post->ID );
?>
<div id="reviews" class="eb-course-review-content">
	<h3 class="rating-title"><?php echo __( 'Course Rating', 'edublink' ); ?></h3>
	<?php 
		echo '<span class="eb-rating-sub-title">' . esc_html( number_format( ( float ) $all_rating, 1, '.', '' ) );
			echo ' ' . __( 'average rating based on', 'edublink' ) . ' ';
			$all ? printf( _n( '%1$s rating', '%1$s ratings', $all, 'edublink' ), number_format_i18n( $all ) ) : esc_html_e( '0 rating', 'edublink' );
		echo '</span>';
	?>

	<div class="eb-rating-detail-box">
		<div class="edublink-row">
			<div class="edublink-col-sm-4">
				<div class="edublink-rating-left-box">
					<div class="course-rating-number"><?php echo number_format( ( float ) $all_rating, 1, '.', '' ); ?></div>
					<div class="course-rating-star">
						<?php EduBlink_LD_Course_Review::display_review( $all_rating ); ?>
					</div>
					<div class="course-all-rating">
						<?php $all ? printf( _n( '%1$s review', '%1$s reviews', $all, 'edublink' ), number_format_i18n( $all ) ) : esc_html_e( '0 review', 'edublink' ); ?>
					</div>
				</div>
			</div>

			<div class="edublink-col-sm-8">
				<div class="edublink-review-wrapper">
					<?php for ( $i = 5; $i >= 1; $i -- ) :
						echo '<div class="edublink-each-review">';
							echo '<div class="edublink-rating-text">';
								echo '<span class="number">' . esc_html( $i ) . '</span>'; 
								echo '<i class="icon-23"></i>';
							echo '</div>';

							echo '<div class="eb-rating-progress-bar-inner"><div class="eb-rating-progress-bar-gray"></div><div class="eb-rating-progress-bar-color" style="' . esc_attr( ( $all && ! empty( $ratings[$i]->quantity ) ) ? esc_attr( 'width: ' . number_format( ( $ratings[$i]->quantity / $all * 100 ), 0 ) . '%' ) : 'width: 0%' ) . '"></div></div>';

							echo '<div class="edublink-rating-value">';
								echo trim( ( $all && ! empty( $ratings[$i]->quantity ) ) ? number_format( ( $ratings[$i]->quantity / $all * 100 ), 0 ) . '%' : '0%' );
							echo '</div>';
						echo '</div>';
					endfor; ?>
				</div>
			</div>
		</div>
	</div>

	<?php if ( have_comments() ) : ?>
		<div id="comments" class="rating-comment comments-area edublink-comments-area">
			<h2 class="comments-title"><?php echo sprintf( _n( __( 'Review', 'edublink' ) . ' <span class="total-ratings-received">(%s)</span>', __(' Reviews', 'edublink' ) . ' <span class="total-ratings-received">(%s)</span>', $all ), $all ); ?></h2>

			<ol class="edublink-comment-list review-comment">
				<?php wp_list_comments( array( 'callback' => array( 'EduBlink_LD_Course_Review', 'ld_course_comments' ) ) ); ?>
			</ol>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="edublink-pagination-wrapper">';
					paginate_comments_links( apply_filters( 'edublink_comment_pagination_args', array(
						'prev_text' => is_rtl() ? '&rarr;' : '&larr;',
						'next_text' => is_rtl() ? '&larr;' : '&rarr;',
						'type'      => 'list',
					) ) );
				echo '</nav>';
			endif; ?>
		</div>
	<?php endif; ?>

	<?php $commenter = wp_get_current_commenter(); ?>
	<div id="review_form_wrapper" class="comments-area edublink-comments-area">
		<div class="reply_comment_form hidden">
			<?php
				$comment_form = array(
					'title_reply'          => __( 'Reply comment', 'edublink' ),
					'title_reply_to'       => __( 'Leave a Reply to %s', 'edublink' ),
					'comment_notes_before' => '',
					'comment_notes_after'  => '',
					'fields'               => array(
						'author' => '<div class="edublink-row"><div class="edublink-col-lg-6"><div class="form-group">'.
						            '<input id="author" class="form-control" placeholder="' . esc_attr__( 'Name', 'edublink' ) . '" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></div></div>',
						'email'  => '<div class="edublink-col-lg-6"><div class="form-group">' .
						            '<input id="email" placeholder="'.esc_attr__( 'Email', 'edublink' ).'" class="form-control" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></div></div>',
						            'url' => '<div class="edublink-col-lg-6 edublink-d-none"><div class="form-group"><label>'.__( 'Website', 'edublink' ).'</label>
                                            <input id="url" name="url" placeholder="'.esc_attr__( 'Your Website', 'edublink' ).'" class="form-control" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '"  />
                                       	</div></div></div>',
					),
					'label_submit'  => __( 'Submit Reply', 'edublink' ),
					'logged_in_as'  => '',
					'comment_field' => '',
					'title_reply_before' => '<h4 class="title comment-reply-title">',
					'title_reply_after'  => '</h4>',
					'class_form'  => 'edublink-comment-form',
					'class_submit' => 'edublink-comment-btn'
				);

				$comment_form['comment_field'] .= '<div class="form-group"><label class="your-feedback">' . esc_attr__( 'Your Reply', 'edublink' ) . '</label><textarea placeholder="' . esc_attr__( 'Your Reply', 'edublink' ) . '" id="comment" class="form-control" name="comment" cols="45" rows="5" aria-required="true" placeholder="' . esc_attr__( 'Your Reply', 'edublink' ) . '"></textarea></div>';
				
				$comment_form['must_log_in'] = '<p class="must-log-in">' .  __( 'You must be logged in to reply this review.', 'edublink' ) . '</p>';
				
				edublink_hidden_comment_form($comment_form);
			?>
		</div>

		<div id="eb-review-form" class="comments-area">
			<?php

				$comment_form = array(
					'class_form'         => 'edublink-comment-form form media-body',
					'class_submit'       => 'edublink-comment-btn',
					'title_reply'          => have_comments() ? __( 'Write a Review', 'edublink' ) : sprintf( __( 'Be the first to review &ldquo;%s&rdquo;', 'edublink' ), get_the_title() ),
					'title_reply_to'       => __( 'Leave a Reply to %s', 'edublink' ),
					'comment_notes_before' => '',
					'comment_notes_after'  => '',
					'fields'               => array(
						'author' => '<div class="edublink-row"><div class="edublink-col-lg-6"><div class="form-group">'.
						            '<input id="author" placeholder="' . esc_attr__( 'Name', 'edublink' ) . '" class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></div></div>',
						'email'  => '<div class="edublink-col-lg-6"><div class="form-group">' .
						            '<input id="email" placeholder="' . esc_attr__( 'Email', 'edublink' ) . '" class="form-control" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></div></div>',
						            'url' => '<div class="edublink-col-lg-6 edublink-d-none"><div class="form-group"><label>'.__( 'Website', 'edublink' ).'</label>
                                            <input id="url" placeholder="'.esc_attr__( 'Your Website', 'edublink' ).'" name="url" class="form-control" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '"  />
                                       	</div></div></div>',
					),
					'label_submit'  => __( 'Submit Review', 'edublink' ),
					'logged_in_as'  => '',
					'comment_field' => '',
					'title_reply_before' => '<h4 class="title comment-reply-title">',
					'title_reply_after'  => '</h4>',
				);

				$comment_form['comment_field'] = '
				<div class="eb-course-rating-content rating-with-label">
					<label for="rating" class="rating-label">' . __( 'Rating Here', 'edublink' ) .'</label>
					<div class="eb-course-review-wrapper">
						<div class="eb-custom-rating-form">
							<ul class="eb-course-review">
								<li><span class="icon-23"></span></li>
								<li><span class="icon-23"></span></li>
								<li><span class="icon-23"></span></li>
								<li><span class="icon-23"></span></li>
								<li><span class="icon-23"></span></li>
							</ul>
							<ul class="eb-course-review eb-review-filled">
								<li><span class="icon-23"></span></li>
								<li><span class="icon-23"></span></li>
								<li><span class="icon-23"></span></li>
								<li><span class="icon-23"></span></li>
								<li><span class="icon-23"></span></li>
							</ul>
							<input type="hidden" value="5" name="rating" id="edublink_input_rating">
						</div>
					</div>
				</div>';

				$comment_form['must_log_in'] = '<div class="must-log-in">' .  __( 'You must be logged in to post a review.', 'edublink' ) . '</div>';
				
				$comment_form['comment_field'] .= '<div class="form-group"><textarea id="comment" class="form-control" placeholder="' . esc_attr__( 'Review summary', 'edublink' ) . '" name="comment" cols="45" rows="5" aria-required="true"></textarea></div>';
				
				edublink_hidden_comment_form( $comment_form );
			?>
		</div>
	</div>
</div>