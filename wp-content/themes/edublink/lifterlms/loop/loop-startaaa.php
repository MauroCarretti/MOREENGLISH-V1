<?php
/**
 * LifterLMS Loop Start Wrapper
 *
 * @package LifterLMS/Templates
 *
 * @since   1.0.0
 * @version 3.0.0
 */
defined( 'ABSPATH' ) || exit;

echo '<div class="edublink-ll-course-wrapper">';
    echo '<div id="container" class="site-content-inner' . esc_attr( apply_filters( 'edublink_container_class', ' edublink-container' ) ) . '"role="main">';
        echo '<div class="edublink-row">';
