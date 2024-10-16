<?php
if ( $wp_featured_post_query->have_posts() ) :
    while ( $wp_featured_post_query->have_posts() ) : $wp_featured_post_query->the_post();
        echo '<div class="edublink-col-lg-6 featured-post edu-blog">';
            if ( has_post_thumbnail() && get_the_post_thumbnail_url() ) :
                echo '<div ' . $this->get_render_attribute_string( 'featured-wrapper' ) . '>';
                    echo '<div class="inner">';
                        echo '<div class="thumbnail">';
                            echo '<a href="' . esc_url( get_the_permalink() ) . '">';
                                echo $this->render_image_for_featured_post( get_post_thumbnail_id( get_the_id() ), $settings ); 
                            echo '</a>';

                            echo '<div class="content">';
                                echo '<div class="category-wrap">';
                                    echo edublink_category_by_id( get_the_ID() );
                                echo '</div>';

                                echo edublink_get_title( 'h3' );

                                echo '<ul class="blog-meta">';
                                    echo '<li><i class="icon-27"></i>' . esc_html( get_the_date( $date ) ) . '</li>';
                                    echo '<li><i class="icon-28"></i>';
                                        printf( // WPCS: XSS OK.
                                            /* translators: 1: comment count number, 2: title. */
                                            esc_html( _nx( '%2$s %1$s', ' %2$s %1$s', get_comments_number(), 'comments title', 'edublink-core' ) ),
                                            number_format_i18n( get_comments_number() ),
                                            $settings['comment_text'],
                                            '<span>' . get_the_title() . '</span>'
                                        );
                                    echo '</li>';
                                echo '</ul>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            endif;
        echo '</div>';
    endwhile;
    wp_reset_postdata();
endif;

if ( $wp_specific_post_query->have_posts() ) :
    echo '<div class="edublink-col-lg-6 specific-posts">';
        echo '<div class="edublink-row">';
            while ( $wp_specific_post_query->have_posts() ) : $wp_specific_post_query->the_post();
                echo '<div class="edublink-col-lg-6 edublink-col-sm-6">';
                    echo '<div ' . $this->get_render_attribute_string( 'featured-wrapper' ) . '>';
                        echo '<div class="edu-blog">';
                            echo '<div class="inner">';
                                if ( has_post_thumbnail() && get_the_post_thumbnail_url() ) :
                                    echo '<div class="thumbnail">';
                                        echo '<a href="' . esc_url( get_the_permalink() ) . '">';
                                            echo $this->render_image_for_specific_post( get_post_thumbnail_id( get_the_id() ), $settings ); 
                                        echo '</a>';

                                        echo '<div class="category-wrap">';
                                            echo edublink_category_by_id( get_the_ID() );
                                        echo '</div>';
                                    echo '</div>';
                                endif;

                                echo '<div class="content">';
                                    echo edublink_get_title();

                                    echo '<ul class="blog-meta">';
                                        echo '<li><i class="icon-27"></i>' . esc_html( get_the_date( $date ) ) . '</li>';
                                        echo '<li><i class="icon-28"></i>';
                                            printf( // WPCS: XSS OK.
                                                /* translators: 1: comment count number, 2: title. */
                                                esc_html( _nx( 'Com %1$s', ' Com %1$s', get_comments_number(), 'comments title', 'edublink-core' ) ),
                                                number_format_i18n( get_comments_number() ),
                                                '<span>' . get_the_title() . '</span>'
                                            );
                                        echo '</li>';
                                    echo '</ul>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            endwhile;
            wp_reset_postdata();
        echo '</div>';
    echo '</div>';
endif;