<?php

defined( 'ABSPATH' ) || exit();
use \EduBlink\Filter;

if ( ! isset( $block_data ) ) :
    $block_data = array();
endif;

$default_data = Filter::LL_Data();
$button_text = $default_data['button_text'];
$block_data = wp_parse_args( $block_data, $default_data );

llms_get_template( 'custom/course-block/block-' . $block_data['style'] . '.php', compact( 'block_data', 'button_text' ) );