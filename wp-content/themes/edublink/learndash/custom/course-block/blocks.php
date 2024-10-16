<?php

defined( 'ABSPATH' ) || exit();
use \EduBlink\Filter;

if ( ! isset( $args ) ) :
    $args = array();
endif;

$default_data = Filter::LD_Data();
$args = wp_parse_args( $args, $default_data );
get_template_part( 'learndash/custom/course-block/block-' . $args['style'], '', $args );