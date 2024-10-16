<?php
/**
 * Template part for displaying sfwd-courses content in archive.php.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package EduBlink
 * @since   1.0.0
 */
defined( 'ABSPATH' ) || exit();
use \EduBlink\Filter;

if ( ! isset( $block_data ) ) :
    $block_data = array();
endif;

if ( ! isset( $style ) ) :
    $style = edublink_set_value( 'ld_course_style', 1 );
endif;

if ( isset( $_GET['course_preset'] ) ) :
    $style = Filter::grid_layout_keys();
endif;

$default_data = array(
    'style' => $style
);

$edublink_course_container = array();
$masonry_status = edublink_set_value( 'ld_course_masonry_layout', false );
$wrapper = 'edublink-lms-courses-grid edublink-row edublink-course-archive';

if ( $masonry_status || isset( $_GET['masonry'] ) ) :
	$wrapper = $wrapper . ' ' . 'eb-masonry-grid-wrapper';
    $edublink_course_container[] = 'eb-masonry-item';
endif;

if ( ! isset( $column ) ) :
    $column = apply_filters( 'edublink_course_archive_grid_column', array( 'edublink-col-lg-6 edublink-col-md-6 edublink-col-sm-12' ) );
endif;

$edublink_course_container = array_merge( $edublink_course_container, $column );

$args = wp_parse_args( $block_data, $default_data );
if ( have_posts() ) :
	echo '<div class="' . esc_attr( $wrapper ) . '">';
        while ( have_posts() ) : the_post(); 
            ?>
            <div id="post-<?php the_ID(); ?>" <?php post_class( apply_filters( 'edublink_course_loop_classes', $edublink_course_container ) ); ?>>
                <?php get_template_part( 'learndash/custom/course-block/blocks', '', $args );
            echo '</div>';
        endwhile;
	echo '</div>';
else :
	get_template_part( 'template-parts/content', 'none' );
endif;
