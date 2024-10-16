<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
} //Exit if accessed directly ?>


<?php
$course_tabs                 = array();
$course_tabs['description']  = esc_html__( 'Description', 'edublink' );
$course_tabs['curriculum']   = esc_html__( 'Curriculum', 'edublink' );
$course_tabs['faq']          = esc_html__( 'FAQ', 'edublink' );
$course_tabs['announcement'] = esc_html__( 'Announcement', 'edublink' );
$course_tabs['reviews']      = esc_html__( 'Reviews', 'edublink' );

$course_tabs = apply_filters( 'stm_lms_course_tabs', $course_tabs, $course->id );
$active      = array_search( reset( $course_tabs ), $course_tabs, true );
$tabs_length = count( $course_tabs );
$tab_attr    = '#';
$style       = isset( $style ) ? $style : '1';
$with_image  = isset( $with_image ) ? $with_image : false;
$active = apply_filters( 'edublink_ms_course_tab_active_item', $active );

if ( $tabs_length > 0 ) : 
	if ( $style == '2' || $style == '3' || $style == '5' ) :
		?>
		<div class="tab-content">
			<?php foreach ( $course_tabs as $slug => $name ) : ?>
				<div role="tabpanel"
					class="tab-pane active"
					id="<?php echo esc_attr( $slug ); ?>"
					data-sal>
					<?php
						if ( 'curriculum' === $slug ) :
							$slug = 'curriculum/main';
						endif;

						STM_LMS_Templates::show_lms_template(
							'components/course/' . $slug,
							array(
								'course'     => $course,
								'user_id'    => $user_id,
								'with_image' => $with_image,
							)
						);
					?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php else : ?>
		<div class="nav-tabs-wrapper">
			<ul class="nav nav-tabs" role="tablist">
				<?php foreach ( $course_tabs as $slug => $name ) : ?>
					<li role="presentation" class="<?php echo ( $slug === $active ) ? 'active' : ''; ?>">
						<a href="<?php echo esc_attr( $tab_attr . $slug ); ?>"
							data-toggle="tab">
							<?php echo wp_kses_post( $name ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div class="tab-content masterstudy-single-course-tabs__content">
			<?php foreach ( $course_tabs as $slug => $name ) : ?>
				<div role="tabpanel"
					class="tab-pane <?php echo ( $slug === $active ) ? 'active' : ''; ?> "
					id="<?php echo esc_attr( $slug ); ?>">
					<?php
						if ( 'curriculum' === $slug ) :
							$slug = 'curriculum/main';
						endif;

						STM_LMS_Templates::show_lms_template(
							'components/course/' . $slug,
							array(
								'course'     => $course,
								'user_id'    => $user_id,
								'with_image' => $with_image,
							)
						);
					?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif;
endif;
