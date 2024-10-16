<?php

use \EduBlink\Filter;

if ( ! isset( $block_data ) ) :
    $block_data = array();
endif;

if ( ! isset( $style ) ) :
    $style = edublink_set_value( 'ss_course_style', 1 );
endif;

if ( isset( $_GET['course_preset'] ) ) :
    $style = Filter::grid_layout_keys();
endif;

$default_data = array(
    'style' => $style
);

$block_data = wp_parse_args( $block_data, $default_data );

$edublink_course_container = array();
$masonry_status = edublink_set_value( 'ss_course_masonry_layout', false );
$wrapper = 'edublink-lms-courses-grid edublink-row edublink-course-archive';

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

if ( isset( $_GET['active_white_bg'] ) || edublink_set_value( 'ss_course_white_bg' ) ) :
    $edublink_course_container[] = 'active-white-bg';
endif;

$edublink_course_container[] = 'edublink-course-style-' . esc_attr( $style );

$edublink_course_container = array_merge( $edublink_course_container, $column );

$args = array( 
    'post_type'      => 'course',
    'order'          => 'DESC',
    'paged'          => get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1,
    'posts_per_page' => 2 
);

$args = apply_filters( 'edublink_ss_course_archive_args', $args );
$query = new WP_Query( $args );



    // edublink_ss_course_header_top_bar( $query );

    if ( $query->have_posts() ) :
        echo '<div class="' . esc_attr( $wrapper ) . '">';
            while ( $query->have_posts() ) : $query->the_post(); ?>
                <div id="post-<?php the_ID(); ?>" <?php post_class( apply_filters( 'edublink_course_loop_classes', $edublink_course_container ) ); ?> data-sal>
                    <?php
                        get_template_part( 'sensei/custom/course-block/blocks', '', $args );
                    ?>
                </div>
                <?php
            endwhile;
            // wp_reset_postdata();
        echo '</div>';

        the_posts_pagination( array(
            'prev_text' => '<<<',
            'next_text' => '>>>',
        ) );
        
        // $GLOBALS['wp_query']->max_num_pages = $query->max_num_pages;
        // edublink_numeric_pagination();
    else :
        _e( 'Sorry, No Course Found.', 'edublink' );
    endif;


