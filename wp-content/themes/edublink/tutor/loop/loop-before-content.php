<?php
/**
 * Course Loop End
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$edublink_course_container = array();

if ( ! isset( $column ) ) :
    // $column = apply_filters( 'edublink_course_archive_grid_column', array( 'edublink-col-lg-4 edublink-col-md-6 edublink-col-sm-12' ) );
	$column = tutor_utils()->get_option( 'courses_col_per_row', 3 );
	if ( isset( $column ) )  :
		$column = tutor_utils()->get_option( 'courses_col_per_row', 3 );
		$column = 12/$column;
	else :
		$column = 4;
	endif;
	
	$column = array( 'edublink-col-lg-' . $column . ' edublink-col-md-6 edublink-col-sm-12' );
endif;

$edublink_course_container = array_merge( $edublink_course_container, $column );
?>
	<div id="post-<?php the_ID(); ?>" <?php post_class( apply_filters( 'edublink_course_loop_classes', $edublink_course_container ) ); ?>>