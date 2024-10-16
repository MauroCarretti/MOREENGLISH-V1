<?php

/**
 * A single course loop
 *
 * @since v.1.0.0
 * @author themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */
defined( 'ABSPATH' ) || exit();
use \EduBlink\Filter;

if ( ! isset( $block_data ) ) :
    $block_data = array();
endif;

if ( ! isset( $style ) ) :
    $style = edublink_set_value( 'tutor_course_style', 1 );
endif;

if ( isset( $_GET['course_preset'] ) ) :
    $style = Filter::grid_layout_keys();
endif;

$default_data = array(
	'style' => $style
);

$block_data = wp_parse_args( $block_data, $default_data );

if ( ! isset( $column ) ) :
    $column = apply_filters( 'edublink_course_archive_grid_column', array( 'edublink-col-lg-4 edublink-col-md-6 edublink-col-sm-12' ) );
endif;

tutor_load_template( 'custom.course-block.blocks', compact( 'block_data' ) );