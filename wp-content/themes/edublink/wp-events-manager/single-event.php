<?php
/**
 * The Template for displaying single events page.
 *
 * Override this template by copying it to yourtheme/wp-events-manager/single-event.php
 *
 * @author        ThimPress, leehld
 * @package       WP-Events-Manager/Template
 * @version       2.1.7
 */
defined( 'ABSPATH' ) || exit;

get_header();

echo '<div class="eb-event-details site-content-inner' . esc_attr( apply_filters( 'edublink_container_class', ' edublink-container' ) ) . '">';
    echo '<div class="edublink-main-content-inner">';
        echo '<div class="main-thumbnail">';
            do_action( 'tp_event_single_event_thumbnail' );
        echo '</div>';
    
        wpems_get_template_part( 'content', 'single-event' );

    echo '</div>';
echo '</div>';

get_footer();