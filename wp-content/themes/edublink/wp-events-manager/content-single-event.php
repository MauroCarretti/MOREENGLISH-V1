<?php
/**
 * The Template for displaying content single event.
 *
 * Override this template by copying it to yourtheme/wp-events-manager/content-single-event.php
 *
 * @author        ThimPress, leehld
 * @package       WP-Events-Manager/Template
 * @version       2.1.7
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$eb_tp_content_column = 'edublink-col-lg-8';
if ( wpems_get_option( 'allow_register_event' ) == 'no' || ! edublink_set_value( 'tp_single_event_sidebar' ) ) :
	$eb_tp_content_column = 'edublink-col-lg-12';
endif;

echo '<div class="eb-event-contaner-wrapper">';
	echo '<div class="edublink-row">';
		echo '<div class="' . esc_attr( $eb_tp_content_column ) . '">';
			the_content();

			if ( edublink_set_value( 'tp_single_event_google_map', true ) ) :
				wpems_get_template_part( 'custom/google', 'map' );
			endif;
		echo '</div>';
		
		if ( edublink_set_value( 'tp_single_event_sidebar', true ) ) :
			echo '<div class="edublink-col-lg-4">';
				do_action( 'tp_event_after_single_event' );
			echo '</div>';
		endif;
	echo '</div>';

	if ( edublink_set_value( 'tp_single_event_speaker', true ) ) :
		wpems_get_template_part( 'custom/event', 'speaker' );
	endif;

	if ( edublink_set_value( 'tp_single_event_comment_form', false ) && ( comments_open() || get_comments_number() ) ) :
		comments_template();
	endif;
echo '</div>';