<?php
defined( 'ABSPATH' ) || exit();
wp_enqueue_script( 'gmap-api-js' );
$event_latitude  = get_post_meta( get_the_ID(), 'edublink_tp_event_latitude', true );
$event_longitude = get_post_meta( get_the_ID(), 'edublink_tp_event_longitude', true );
if ( ( isset( $event_latitude ) && ! empty( $event_latitude ) ) && ( isset( $event_longitude ) && ! empty( $event_longitude ) ) ) :
    echo '<div class="edublink-event-details-map">';
        echo '<div id="edublink-event-contact-map" class="edublink-single-event-google-map" data-latitude="' . esc_attr( $event_latitude ) . '" data-longitude="' . esc_attr( $event_longitude ) . '"></div>';
    echo '</div>';
endif;