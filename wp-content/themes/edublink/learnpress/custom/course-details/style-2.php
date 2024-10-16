<?php
defined( 'ABSPATH' ) || exit();

$tabs = learn_press_get_course_tabs();
if ( empty( $tabs ) ) :
    return;
endif;

echo '<div class="course-tab-panels">';
    foreach ( $tabs as $key => $tab ) :
        echo '<div class="course-tab-panel-' . esc_attr( $key ) . ' course-each-tab-panel" data-sal>';
            if ( isset( $tab['callback'] ) && is_callable( $tab['callback'] ) ) :
                call_user_func( $tab['callback'], $key, $tab );
            else :
                do_action( 'learn-press/course-tab-content', $key, $tab );
            endif;
        echo '</div>';
    endforeach;
echo '</div>';