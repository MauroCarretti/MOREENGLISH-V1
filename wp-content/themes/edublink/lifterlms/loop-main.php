<?php
/**
 * LifterLMS Loop main template
 *
 * @since 5.8.0
 * @version 5.8.0
 */

defined( 'ABSPATH' ) || exit;
use \EduBlink\Filter;
get_header();

if ( ! isset( $block_data ) ) :
    $block_data = array();
endif;

if ( ! isset( $style ) ) :
    $style = edublink_set_value( 'll_course_style', 1 );
endif;

if ( isset( $_GET['course_preset'] ) ) :
    $style = Filter::grid_layout_keys();
endif;

$default_data = array(
    'style' => $style
);

$block_data = wp_parse_args( $block_data, $default_data );

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

$post_type = get_post_type();
$posts_per_page = get_option( 'lifterlms_shop_courses_per_page' );
if ( 'llms_membership' == $post_type ) :
    $posts_per_page = apply_filters( 'edublink_llms_membership_archive_per_page', -1 );
endif;

$args = array( 
    'post_type'      => $post_type,
    'order'          => 'DESC',
    'paged'          => get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1,
    'posts_per_page' => $posts_per_page
);

$args = apply_filters( 'edublink_ll_course_archive_args', $args );
$query = new WP_Query( $args );

echo '<div class="edublink-ll-course-wrapper">';
    echo '<div id="container" class="site-content-inner' . esc_attr( apply_filters( 'edublink_container_class', ' edublink-container' ) ) . '"role="main">';
        // edublink_ll_course_header_top_bar( $query );

        if ( $query->have_posts() ) :
            echo '<div class="' . esc_attr( $wrapper ) . '">';
                while ( $query->have_posts() ) : $query->the_post(); ?>
                    <div id="post-<?php the_ID(); ?>" <?php post_class( apply_filters( 'edublink_course_loop_classes', $edublink_course_container ) ); ?> data-sal>
                        <?php
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
                    <?php
                endwhile;
                wp_reset_postdata();
            echo '</div>';
            edublink_numeric_pagination();
        else :
            _e( 'Sorry, No Course Found.', 'edublink' );
        endif;
    echo '</div>';
echo '</div>';

get_footer();
