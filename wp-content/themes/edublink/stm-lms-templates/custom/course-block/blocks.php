<?php

defined( 'ABSPATH' ) || exit();
use \EduBlink\Filter;

if ( ! isset( $block_data ) ) :
    $block_data = array();
endif;

$default_data = Filter::MS_Data();
$block_data = wp_parse_args( $block_data, $default_data );
STM_LMS_Templates::show_lms_template( 'custom/course-block/block-' . $block_data['style'], compact( 'block_data' ) );