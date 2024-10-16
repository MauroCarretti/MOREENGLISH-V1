<?php
get_header();

echo '<div class="site-content-inner' . esc_attr( apply_filters( 'edublink_container_class', ' edublink-container' ) ) . '">';
    do_action( 'edublink_before_content' );
    if ( have_posts() ) :
        echo '<div class="eb-event-archive-wrapper edublink-row">';
            while ( have_posts() ) : the_post();
                echo '<div class="eb-event-single-item edublink-col-lg-4 edublink-col-md-6 edublink-col-sm-12" data-sal>';
                    wpems_get_template_part( 'content', 'event' );
                echo '</div>';
            endwhile;
            wp_reset_postdata();
        echo '</div>';

        edublink_numeric_pagination();
    else :
        _e( 'No Event Found.', 'edublink' );
    endif;

    do_action( 'edublink_after_content' );
echo '</div>';
    
get_footer();