<?php

echo '<div class="edu-blog blog-style-6">';
	echo '<div class="inner">';
        if ( has_post_thumbnail() && get_the_post_thumbnail_url() ) :
            echo '<div class="thumbnail">';
                echo '<a href="' . esc_url( get_the_permalink() ) . '">';
                    echo $this->render_image( get_post_thumbnail_id( get_the_id() ), $settings ); 
                echo '</a>';

                echo '<span class="date">' . esc_html( get_the_date( $date ) ) . '</span>';
            echo '</div>';
        endif;

		echo '<div class="content position-top">';
            echo '<div class="read-more-btn">';
                echo '<a class="btn-icon-round" href="' . esc_url( get_the_permalink() ) . '"><i class="icon-4"></i></a>';
            echo '</div>';
            
            if ( $cat_item ) :
                echo '<div class="category-wrap">';
                    echo wp_kses_post( $cat_item );
                echo '</div>';
            endif;

            echo edublink_get_title( 'h5' );

            if ( $settings['enable_excerpt'] === 'yes' ) : 
                echo wpautop( wp_trim_words( wp_kses_post( get_the_excerpt() ), esc_html( $excerpt_length ), esc_html( $settings['excerpt_end'] ) ) );
            endif;
		echo '</div>';
	echo '</div>';
echo '</div>';