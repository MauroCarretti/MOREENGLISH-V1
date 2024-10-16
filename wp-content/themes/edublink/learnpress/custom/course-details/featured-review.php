<?php

$review_content = get_post_meta( get_the_ID(), '_lp_featured_review', true );

if ( ! $review_content ) {
    return;
}

$user = learn_press_get_current_user();

if ( ! $user ) {
    return;
}

if ( $user->has_enrolled_or_finished( get_the_ID() ) ) {
    return;
}

learn_press_get_template(
    'single-course/featured-review',
    array(
        'review_content' => $review_content,
        'review_value'   => 5,
    )
);