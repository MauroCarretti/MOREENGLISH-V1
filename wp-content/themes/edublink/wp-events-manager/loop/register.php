<?php
/**
 * The Template for displaying register button in single event page.
 *
 * Override this template by copying it to yourtheme/wp-events-manager/loop/register.php
 *
 * @author        ThimPress, leehld
 * @package       WP-Events-Manager/Template
 * @version       2.1.7
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

if ( wpems_get_option( 'allow_register_event' ) == 'no' ) {
	return;
}

$event           = new WPEMS_Event( get_the_ID() );
$user_reg        = $event->booked_quantity( get_current_user_id() );
$date_start      = $event->__get( 'date_start' ) ? date( 'Ymd', strtotime( $event->__get( 'date_start' ) ) ) : '';
$time_start      = $event->__get( 'time_start' ) ? date( 'Hi', strtotime( $event->__get( 'time_start' ) ) ) : '';
$date_end        = $event->__get( 'date_end' ) ? date( 'Ymd', strtotime( $event->__get( 'date_end' ) ) ) : '';
$time_end        = $event->__get( 'time_end' ) ? date( 'Hi', strtotime( $event->__get( 'time_end' ) ) ) : '';
$g_calendar_link = 'http://www.google.com/calendar/event?action=TEMPLATE&text=' . urlencode( $event->get_title() );
$g_calendar_link .= '&dates=' . $date_start . ( $time_start ? 'T' . $time_start : '' ) . '/' . $date_end . ( $time_end ? 'T' . $time_end : '' );
$g_calendar_link .= '&details=' . urlencode( $event->post->post_content );
$g_calendar_link .= '&location=' . urlencode( $event->__get( 'location' ) );
$g_calendar_link .= '&trp=false&sprop=' . urlencode( get_permalink( $event->ID ) );
$g_calendar_link .= '&sprop=name:' . urlencode( get_option( 'blogname' ) );
$time_zone       = get_option( 'timezone_string' ) ? get_option( 'timezone_string' ) : 'UTC';
$g_calendar_link .= '&ctz=' . urlencode( $time_zone );
$register_status = true;

if ( absint( $event->qty ) == 0 || get_post_meta( get_the_ID(), 'tp_event_status', true ) === 'expired' ) {
	$register_status = false;
}

$tp_single_event_heading = edublink_set_value( 'tp_single_event_sidebar_heading' ) ? edublink_set_value( 'tp_single_event_sidebar_heading' ) :  __( 'Event Info', 'edublink' );
$extra_meta = get_post_meta( get_the_ID(), 'edublink_tp_event_extra_meta_fields', true ); 

echo '<div class="eb-event-sidebar sidebar eb-sidebar-get-sticky">';
    echo '<div class="inner">';
        echo '<div class="content">';
            echo '<h4 class="widget-title">' . esc_html( $tp_single_event_heading ) . '</h4>';

            echo '<ul class="event-meta">';
                if ( edublink_set_value( 'tp_single_event_sidebar_meta_cost', true ) ) :
                    $tp_single_event_cost_label = edublink_set_value( 'tp_single_event_sidebar_cost_label' ) ? edublink_set_value( 'tp_single_event_sidebar_cost_label' ) :  __( 'Cost:', 'edublink' );
                    echo '<li>';
                        echo '<span class="label"><i class="icon-60"></i>' . esc_html( $tp_single_event_cost_label ). '</span>';
                        echo '<span class="value price">';
                            printf( '%s', $event->is_free() ? __( 'Free', 'edublink' ) : wpems_format_price( $event->get_price() ) );
                        echo '</span>';
                    echo '</li>';
                endif;

                if ( edublink_set_value( 'tp_single_event_sidebar_meta_total_slot', true ) ) :
                    $tp_single_event_total_slot_label = edublink_set_value( 'tp_single_event_sidebar_total_slot_label' ) ? edublink_set_value( 'tp_single_event_sidebar_total_slot_label' ) :  __( 'Total Slot:', 'edublink' );
                    echo '<li>';
                        echo '<span class="label"><i class="icon-70"></i>' . esc_html( $tp_single_event_total_slot_label ). '</span>';
                        echo '<span class="value">' . esc_html( absint( $event->qty ) ) . '</span>';
                    echo '</li>';
                endif;

                if ( edublink_set_value( 'tp_single_event_sidebar_meta_booked_slot', true ) ) :
                    $tp_single_event_booked_slot_label = edublink_set_value( 'tp_single_event_sidebar_booked_slot_label' ) ? edublink_set_value( 'tp_single_event_sidebar_booked_slot_label' ) :  __( 'Booked Slot:', 'edublink' );
                    echo '<li>';
                        echo '<span class="label"><i class="icon-68"></i>' . esc_html( $tp_single_event_booked_slot_label ). '</span>';
                        echo '<span class="value">' . esc_html( absint( $event->booked_quantity() ) ) . '</span>';
                    echo '</li>';
                endif;

                if ( isset( $extra_meta ) && is_array( $extra_meta ) ) :
                    foreach ( $extra_meta as $key => $meta ) :
                        if ( $meta['label'] ) :
                            $wrapper_class = '';
                            if ( isset( $meta['wrapper_class'] ) && ! empty( $meta['wrapper_class'] ) ) :
                                $wrapper_class = ' ' . $meta['wrapper_class'];
                            endif;

                            echo '<li class="edublink-event-details-features-item' . esc_attr( $wrapper_class ) . '">';
                                echo '<span class="label">';
                                    if (  isset( $meta['icon_class'] ) && ! empty( $meta['icon_class'] ) ) :
                                        echo '<i class="' . esc_attr( $meta['icon_class'] ) . '"></i>';
                                    else :
                                        echo '<i class="ri-check-fill"></i>';
                                    endif;
                                    echo esc_html( $meta['label'] );
                                echo '</span>';

                                if ( ! empty( $meta['value'] ) ) :
                                    echo '<span class="value">' . esc_html( $meta['value'] ) . '</span>';
                                endif;
                            echo '</li>';
                        endif;
                    endforeach;
                endif;
            echo '</ul>';
            ?>
            
            <?php if ( edublink_set_value( 'tp_single_event_sidebar_button', true ) ) :
                $tp_single_event_button_text = edublink_set_value( 'tp_single_event_sidebar_register_button_text' ) ? edublink_set_value( 'tp_single_event_sidebar_register_button_text' ) :  __( 'Book Now', 'edublink' );
                $tp_single_event_button_type = edublink_set_value( 'tp_single_event_sidebar_button_type', 'default' );

                if ( 'default' === $tp_single_event_button_type ) : ?>
                    <?php if ( $register_status ) : ?>
                        <?php if ( is_user_logged_in() ) { ?>
                            <?php
                            $registered_time = $event->booked_quantity( get_current_user_id() );
                            if ( $registered_time && wpems_get_option( 'email_register_times' ) === 'once' && $event->is_free() ) { ?>
                                <p><?php echo __( 'You have registered this event before.', 'edublink' ); ?></p>
                            <?php } else { ?>
                                <a class="event_register_submit event_auth_button event-load-booking-form edu-btn"
                                data-event="<?php echo esc_attr( get_the_ID() ) ?>">
                                    <?php echo esc_html( $tp_single_event_button_text ) . '<i class="icon-4"></i>'; ?>
                                </a>
                            <?php } ?>
                        <?php } else { ?>
                            <a href="<?php echo esc_url( wpems_login_url() ); ?>" class="edu-btn login-redirect">
                                <?php echo esc_html( $tp_single_event_button_text ) . '<i class="icon-4"></i>'; ?>
                            </a>
                            <p class="eb-tp-event-login-msg"><?php echo sprintf( __( 'You must <a href="%s">login</a> before register event.', 'edublink' ), wpems_login_url() ); ?></p>
                        <?php } ?>
                    <?php else : ?>
                        <?php if ( ! edublink_set_value( 'tp_single_event_sidebar_meta_countdown', true ) ) : ?>
                            <p class="tp-event-notice error"><?php echo __( 'This event has expired', 'edublink' ); ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php else :
                    $ep_tp_event_button_link  = get_post_meta( get_the_ID(), 'edublink_tp_event_custom_link', true ); 
                    $ep_tp_event_button_open = apply_filters( 'edublink_tp_event_button_link_open_same_tab', true );
                    if ( $ep_tp_event_button_open ) :
                        $open_tab = '_self';
                    else :
                        $open_tab = '_blank';
                    endif;
                    echo '<a class="edu-btn" href="' . esc_url( $ep_tp_event_button_link ) . '" target="' . esc_attr( $open_tab ). '">';
                        echo esc_html( $tp_single_event_button_text ) . '<i class="icon-4"></i>';
                    echo '</a>';
                endif;
            endif;
            if ( edublink_set_value( 'tp_single_event_sidebar_meta_countdown', true ) ) :
                do_action( 'tp_event_loop_event_countdown' );
            endif;

        echo '</div>';
    echo '</div>';
echo '</div>';