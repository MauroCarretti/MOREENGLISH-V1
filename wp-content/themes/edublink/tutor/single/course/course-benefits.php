<?php
/**
 * Template for displaying course benefits
 *
 * @package Tutor\Templates
 * @subpackage Single\Course
 * @author Themeum <support@themeum.com>
 * @link https://themeum.com
 * @since 1.0.0
 */

do_action( 'tutor_course/single/before/benefits' );

$course_benefits = tutor_course_benefits();
if ( empty( $course_benefits ) ) {
	return;
}
?>

<?php if ( is_array( $course_benefits ) && count( $course_benefits ) ) : ?>
	<div class="tutor-course-details-widget">
		<h5 class="tutor-course-details-widget-title eb-tl-course-benefits">
			<?php echo esc_html( apply_filters( 'tutor_course_benefit_title', __( 'What Will You Learn?', 'edublink' ) ) ); ?>
		</h5>
		<ul class="tutor-course-details-widget-list edublink-ul-style-check">
			<?php foreach ( $course_benefits as $benefit ) : ?>
				<li class="tutor-d-flex tutor-mb-12">
					<span><?php echo esc_html( $benefit ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>

<?php do_action( 'tutor_course/single/after/benefits' ); ?>
