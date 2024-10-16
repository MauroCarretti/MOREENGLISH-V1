<?php

echo '<div class="edu-blog blog-style-5">';
	echo '<div class="inner">';
        if ( has_post_thumbnail() && get_the_post_thumbnail_url() ) :
            echo '<div class="thumbnail">';
                echo '<a href="' . esc_url( get_the_permalink() ) . '">';
                    echo $this->render_image( get_post_thumbnail_id( get_the_id() ), $settings ); 
                echo '</a>';

                if ( $cat_item ) :
                    echo '<div class="category-wrap">';
                        echo wp_kses_post( $cat_item );
                    echo '</div>';
                endif;
            echo '</div>';
        endif;

		echo '<div class="content">';
			echo '<ul class="blog-meta">';
				echo '<li><i class="icon-27"></i>' . esc_html( get_the_date( $date ) ) . '</li>';
                if ( comments_open() ) :
                    echo '<li><i class="icon-28"></i>';
                        printf( // WPCS: XSS OK.
                            /* translators: 1: comment count number, 2: title. */
                            esc_html( _nx( '%2$s %1$s', ' %2$s %1$s', get_comments_number(), 'comments title', 'edublink-core' ) ),
                            number_format_i18n( get_comments_number() ),
                            $settings['comment_text'],
                            '<span>' . get_the_title() . '</span>'
                        );
                    echo '</li>';
                endif;
            echo '</ul>';
                    
            echo edublink_get_title( 'h5' );

            if ( $settings['button_text'] ) :
                echo '<div class="read-more-btn">';
                    echo '<a class="blog-btn" href="' . esc_url( get_the_permalink() ) . '">';
                        echo esc_html( $settings['button_text'] );
                        echo '<i class="icon-4"></i>';
                    echo '</a>';
                echo '</div>';
            endif;
		echo '</div>';
	echo '</div>';
echo '</div>';