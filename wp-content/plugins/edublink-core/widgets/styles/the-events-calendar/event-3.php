<?php
echo '<div class="inner">';
    if ( has_post_thumbnail() && get_the_post_thumbnail_url() ) :
        echo '<div class="thumb">';
            echo '<a href="' . esc_url( get_the_permalink() ) . '">';
                echo $this->render_image( get_post_thumbnail_id( get_the_id() ), $settings ); 
            echo '</a>';
        echo '</div>';
    endif;

    echo '<div class="content">';

        if ( $formatted_start_date ) :
            echo '<ul class="event-meta">';
                echo '<li class="date"><i class="icon-27"></i>' . esc_html( $formatted_start_date ). '</li>';
            echo '</ul>';
        endif;
        
        the_title( '<h4 class="title"><a href="' . esc_url( get_the_permalink() ) . '" class="post-link">', '</a></h4>' );

        if ( $location ) :
            echo '<span class="event-location"><i class="icon-40"></i>' . esc_html( $location ). '</span>';
        endif;

        if ( $settings['enable_excerpt'] === 'yes' ) : 
            echo wpautop( wp_trim_words( wp_kses_post( get_the_excerpt() ), esc_html( $settings['excerpt_length'] ), esc_html( $settings['excerpt_end'] ) ) );
        endif;

        if ( $settings['button_text'] ) :
            echo '<div class="read-more-btn">';
                echo '<a class="edu-btn btn-medium curved-medium" href="' . esc_url( get_the_permalink() ) . '">';
                    echo esc_html( $settings['button_text'] ) . '<i class="icon-4"></i>';
                echo '</a>';
            echo '</div>';
        endif;
    echo '</div>';
echo '</div>';