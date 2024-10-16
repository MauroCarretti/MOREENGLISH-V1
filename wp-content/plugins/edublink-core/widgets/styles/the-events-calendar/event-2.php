<?php
echo '<div class="inner">';
    if ( has_post_thumbnail() && get_the_post_thumbnail_url() ) :
        echo '<div class="thumbnail">';
            echo '<a href="' . esc_url( get_the_permalink() ) . '">';
                echo $this->render_image( get_post_thumbnail_id( get_the_id() ), $settings ); 
            echo '</a>';

            if ( $start_time && $end_time ) :
                echo '<div class="event-time">';
                    echo '<span><i class="icon-33"></i>' . esc_html( $start_time . ' - ' . $end_time ) . '</span>';
                echo '</div>';
            endif;
        echo '</div>';
    endif;

    echo '<div class="content">';
        echo '<div class="event-date">';
            echo '<span class="day">' . esc_html( $day ) . '</span>';
            echo '<span class="month">' . esc_html( $month ) . '</span>';
        echo '</div>';

        the_title( '<h5 class="title"><a href="' . esc_url( get_the_permalink() ) . '" class="post-link">', '</a></h5>' );

        if ( $settings['enable_excerpt'] === 'yes' ) : 
            echo wpautop( wp_trim_words( wp_kses_post( get_the_excerpt() ), esc_html( $settings['excerpt_length'] ), esc_html( $settings['excerpt_end'] ) ) );
        endif;

        if ( $location ) :
            echo '<ul class="event-meta">';
                echo '<li><i class="icon-40"></i>' . esc_html( $location ). '</li>';
            echo '</ul>';
        endif;

        if ( $settings['button_text'] ) :
            echo '<div class="read-more-btn">';
                echo '<a class="edu-btn btn-small btn-secondary" href="' . esc_url( get_the_permalink() ) . '">';
                    echo esc_html( $settings['button_text'] ) . '<i class="icon-4"></i>';
                echo '</a>';
            echo '</div>';
        endif;
    echo '</div>';
echo '</div>';