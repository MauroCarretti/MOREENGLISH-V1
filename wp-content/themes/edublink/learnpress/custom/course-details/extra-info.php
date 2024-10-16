<?php

$course = LP_Course::get_course( get_the_ID() );
if ( ! $course ) {
    return;
}

$boxes = apply_filters(
    'learn-press/course-extra-boxes-data',
    array(
        array(
            'title' => __( 'Requirements', 'edublink' ),
            'items' => $course->get_extra_info( 'requirements' ),
        ),
        array(
            'title' => __( 'Features', 'edublink' ),
            'items' => $course->get_extra_info( 'key_features' ),
        ),
        array(
            'title' => __( 'Target audiences', 'edublink' ),
            'items' => $course->get_extra_info( 'target_audiences' ),
        ),
    )
);

$is_checked = 0;
foreach ( $boxes as $box ) {

    if ( ! isset( $box['items'] ) || ! $box['items'] ) {
        continue;
    }

    if ( ! $is_checked ) {
        $box['checked'] = true;
        $is_checked     = true;
    }

    learn_press_get_template( 'single-course/extra-info', $box );
}