<?php
/**
 * The Template for displaying all single courses.
 *
 * @package LifterLMS/Templates
 *
 * @since 1.0.0
 * @version 3.14.0
 */

defined( 'ABSPATH' ) || exit;

$edublink_course_container = array();
$masonry_status = edublink_set_value( 'll_course_masonry_layout', false );
$wrapper = 'edublink-lms-courses-grid edublink-row edublink-course-archive';
$edublink_course_container[] = 'llms-loop-item';

if ( $masonry_status || isset( $_GET['masonry'] ) ) :
	$wrapper = $wrapper . ' ' . 'eb-masonry-grid-wrapper';
    $edublink_course_container[] = 'eb-masonry-item';
endif;


if ( ! isset( $column ) ) :
    $column = apply_filters( 'edublink_course_archive_grid_column', array( 'edublink-col-lg-4 edublink-col-md-6 edublink-col-sm-12' ) );
endif;

if ( isset( $_GET['column'] ) ) :
    if ( $_GET['column'] == 2 ) :
        $column = array( 'edublink-col-lg-6 edublink-col-md-6 edublink-col-sm-12' );
    endif;
endif;

if ( isset( $_GET['active_white_bg'] ) || edublink_set_value( 'll_course_white_bg' ) ) :
    $edublink_course_container[] = 'active-white-bg';
endif;

$edublink_course_container[] = 'edublink-course-style-' . esc_attr( $style );

$edublink_course_container = array_merge( $edublink_course_container, $column );
?>

<div id="post-<?php the_ID(); ?>" <?php post_class( apply_filters( 'edublink_course_loop_classes', $edublink_course_container ) ); ?> data-sal>
    <?php
        $post_type = get_post_type();

        if ( 'llms_membership' == $post_type ) :
            ?>
            <div class="llms-loop-item-content">
                <?php
                    /**
                     * Hook: lifterlms_before_loop_item
                     *
                     * @hooked lifterlms_loop_featured_video - 8
                     * @hooked lifterlms_loop_link_start - 10
                     */
                    do_action( 'lifterlms_before_loop_item' );
                ?>

                <?php
                    /**
                     * Hook: lifterlms_before_loop_item_title
                     *
                     * @hooked lifterlms_template_loop_thumbnail - 10
                     * @hooked lifterlms_template_loop_progress - 15
                     */
                    do_action( 'lifterlms_before_loop_item_title' );
                ?>

                <h4 class="llms-loop-title"><?php the_title(); ?></h4>

                <footer class="llms-loop-item-footer">
                    <?php
                        /**
                         * Hook: lifterlms_after_loop_item_title
                         *
                         * @hooked lifterlms_template_loop_author - 10
                         * @hooked lifterlms_template_loop_length - 15
                         * @hooked lifterlms_template_loop_difficulty - 20
                         * @hooked lifterlms_template_loop_lesson_count - 22
                         *
                         * On Student Dashboard & "Mine" Courses Shortcode
                         * @hooked lifterlms_template_loop_enroll_status - 25
                         * @hooked lifterlms_template_loop_enroll_date - 30
                         */
                        do_action( 'lifterlms_after_loop_item_title' );
                    ?>
                </footer>

                <?php
                    /**
                     * Hook: lifterlms_after_loop_item
                     *
                     * @hooked lifterlms_loop_link_end - 5
                     */
                    do_action( 'lifterlms_after_loop_item' );
                ?>

                </div><!-- .llms-loop-item-content -->
            <?php
        
        elseif ( 'course' == $post_type ) :
            llms_get_template( 'custom/course-block/blocks.php', compact( 'block_data' ) );
        endif;

    ?>
</div>