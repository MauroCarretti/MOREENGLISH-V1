<?php
/**
 * Template for displaying review form.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/course-review/review-form.php.
 *
 * @author ThimPress
 * @package LearnPress/Course-Review/Templates
 * version  3.0.1
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;
?>

<button class="write-a-review edublink-button-item edublink-button-type-fill"><?php _e( 'Write a review', 'edublink' ); ?><span class="dir-part"></span></button>
<div class="course-review-wrapper" id="course-review">
    <div class="review-overlay"></div>
    <div class="review-form" id="review-form">
        <div class="form-overlay-review"></div>
        <form>
            <h3>
				<?php _e( 'Write a review', 'edublink' ); ?>
                <a href="" class="close dashicons dashicons-no-alt"></a>
            </h3>
            <ul class="review-fields">
				<?php do_action( 'learn_press_before_review_fields' ); ?>
                <li>
                    <label><?php _e( 'Title', 'edublink' ); ?> <span class="required">*</span></label>
                    <input type="text" name="review_title"/>
                </li>
                <li>
                    <label><?php _e( 'Content', 'edublink' ); ?><span class="required">*</span></label>
                    <textarea name="review_content"></textarea>
                </li>
                <li>
                    <label><?php _e( 'Rating', 'edublink' ); ?><span class="required">*</span></label>
                    <ul class="review-stars">
						<?php for ( $i = 1; $i <= 5; $i ++ ) { ?>
                            <li class="review-title" title="<?php echo wp_kses_post( $i ); ?>">
                                <span class="dashicons dashicons-star-empty"></span>
                            </li>
						<?php } ?>
                    </ul>
                </li>
				<?php do_action( 'learn_press_after_review_fields' ); ?>
                <li class="review-actions">
                    <button type="button" class="submit-review"
                            data-id="<?php the_ID(); ?>"><?php _e( 'Add review', 'edublink' ); ?></button>
                    <span class="ajaxload"></span>
                    <button type="button" class="close"><?php _e( 'Cancel', 'edublink' ); ?></button>
                    <span class="error"></span>
					<?php wp_nonce_field( 'learn_press_course_review_' . get_the_ID(), 'review-nonce' ); ?>
                    <input type="hidden" name="rating" value="0">
                    <input type="hidden" name="lp-ajax" value="add_review">
                    <input type="hidden" name="comment_post_ID" value="<?php echo esc_attr( get_the_ID() ); ?>">
                </li>
            </ul>
        </form>
    </div>
</div>