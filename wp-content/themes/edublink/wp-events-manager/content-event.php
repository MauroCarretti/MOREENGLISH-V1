<?php
/**
 * The Template for displaying content events.
 *
 * Override this template by copying it to yourtheme/wp-events-manager/content-event.php
 *
 * @author        ThimPress, leehld
 * @package       WP-Events-Manager/Template
 * @version       2.1.7
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$edublink_tp_event_thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'edublink-post-thumb' );
if ( isset( $edublink_tp_event_thumb_src ) && ! empty( $edublink_tp_event_thumb_src ) ) :
    $edublink_tp_event_thumb_url = $edublink_tp_event_thumb_src[0];
else :
    $edublink_tp_event_thumb_url = '';
endif;

$eb_tp_event_start_time = get_post_meta( get_the_ID(), 'tp_event_date_start', true ) ? strtotime( get_post_meta( get_the_ID(), 'tp_event_date_start', true ) ) : '';
$eb_tp_event_location = get_post_meta( get_the_ID(), 'tp_event_location', true ) ? get_post_meta( get_the_ID(), 'tp_event_location', true ) : '';
$eb_tp_event_time_start = wpems_event_start( get_option( 'time_format' ) );
$eb_tp_event_time_end   = wpems_event_end( get_option( 'time_format' ) );
$eb_tp_event_starting_date   = wp_date( 'd/M/Y', $eb_tp_event_start_time );
$eb_tp_event_start_date   = explode( '/', $eb_tp_event_starting_date );
$eb_tp_event_button_text = edublink_set_value( 'tp_event_button_text', __( 'Learn More', 'edublink' ) ) ? edublink_set_value( 'tp_event_button_text' ) : __( 'Learn More', 'edublink' );

echo '<div class="eb-event-item eb-event-style-1">';
    echo '<div class="inner">';
        if ( has_post_thumbnail() && get_the_post_thumbnail_url() ) :
            echo '<div class="thumbnail">';
                echo '<a href="' . esc_url( get_the_permalink() ) . '">';
                    echo '<img src="' . esc_url( $edublink_tp_event_thumb_url ). '" alt="' . esc_attr( edublink_thumbanil_alt_text( get_post_thumbnail_id( get_the_id() ) ) ). '" >';
                echo '</a>';

                if ( $eb_tp_event_start_time ) :
                    echo '<div class="event-time">';
                        echo '<span><i class="icon-33"></i>' . esc_html( $eb_tp_event_time_start . ' - ' . $eb_tp_event_time_end ) . '</span>';
                    echo '</div>';
                endif;
            echo '</div>';
        endif;

        echo '<div class="content">';
            echo '<div class="event-date">';
                echo '<span class="day">' . esc_html( $eb_tp_event_start_date[0] ) . '</span>';
                echo '<span class="month">' . esc_html( $eb_tp_event_start_date[1] ) . '</span>';
            echo '</div>';

            the_title( '<h5 class="title"><a href="' . esc_url( get_the_permalink() ) . '" class="post-link">', '</a></h5>' );

            echo wpautop( wp_trim_words( wp_kses_post( get_the_excerpt() ), 15 ) );

            if ( $eb_tp_event_location ) :
                echo '<ul class="event-meta">';
                    echo '<li><i class="icon-40"></i>' . esc_html( $eb_tp_event_location ). '</li>';
                echo '</ul>';
            endif;

            echo '<div class="read-more-btn">';
                echo '<a class="edu-btn btn-small btn-secondary" href="' . esc_url( get_the_permalink() ) . '">';
                    echo esc_html( $eb_tp_event_button_text ) . '<i class="icon-4"></i>';
                echo '</a>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
echo '</div>';