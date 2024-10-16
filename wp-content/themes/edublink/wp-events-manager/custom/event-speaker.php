<?php
$eb_tp_event_speakers = get_the_terms( get_the_ID(), 'tp_event_speaker' );

if ( is_array( $eb_tp_event_speakers ) ) :
    echo '<div class="eb-event-speaker-section">';
        $tp_single_event_speaker_heading = edublink_set_value( 'tp_single_event_speaker_heading' ) ? edublink_set_value( 'tp_single_event_speaker_heading' ) :  __( 'Event Speakers', 'edublink' );
        echo '<h3 class="heading-title">' . esc_html( $tp_single_event_speaker_heading ) . '</h3>';

        echo '<div class="eb-team-wrapper eb-slider-wrapper">';
            echo '<div class="eb-team-container eb-event-speaker-carousel eb-swiper-carousel-activator swiper swiper-container swiper-container-initialized" data-lg-items="4" data-md-items="3" data-sm-items="2" data-xs-items="2">';
                echo '<div class="swiper-wrapper">';
                    foreach ( $eb_tp_event_speakers as $key => $term ) :
                        $designation = get_term_meta( $term->term_id, 'edublink_tp_event_speaker_designation', true );
                        $image_url   = get_term_meta( $term->term_id, 'edublink_tp_event_speaker_image', true );
                        $fb_profile  = get_term_meta( $term->term_id, 'edublink_tp_event_speaker_fb_profile', true );
                        $tw_profile  = get_term_meta( $term->term_id, 'edublink_tp_event_speaker_tw_profile', true );
                        $lk_profile  = get_term_meta( $term->term_id, 'edublink_tp_event_speaker_lk_profile', true );
                        echo '<div class="edublink-team-1-widget edublink-slider-item swiper-slide">';
                            echo '<div class="edublink-team-item">';

                                if ( $image_url ) :
                                    echo '<div class="thumbnail-wrap">';
                                        echo '<div class="thumbnail">';
                                            echo '<a href="#" target="_blank">';
                                                echo '<img src="' . esc_url( $image_url ) . '" alt="">';
                                            echo '</a>';
                                        echo '</div>';

                                        if ( $fb_profile || $tw_profile || $lk_profile ) :
                                            echo '<ul class="team-share-info">';
                                                echo '<li>';
                                                    echo '<a href="#">';
                                                        echo '<i class="icon-share-alt"></i>';
                                                    echo '</a>';
                                                echo '</li>';

                                                if ( $fb_profile ) :
                                                    echo '<li>';
                                                        echo '<a href="' . esc_url( $fb_profile ) . '" target="_blank">';
                                                            echo '<i class="icon-facebook"></i>';
                                                        echo '</a>';
                                                    echo '</li>';
                                                endif;

                                                if ( $tw_profile ) :
                                                    echo '<li>';
                                                        echo '<a href="' . esc_url( $tw_profile ) . '" target="_blank">';
                                                            echo '<i class="ri-twitter-x-fill"></i>';
                                                        echo '</a>';
                                                    echo '</li>';
                                                endif;

                                                if ( $lk_profile ) :
                                                    echo '<li>';
                                                        echo '<a href="' . esc_url( $lk_profile ) . '" target="_blank">';
                                                            echo '<i class="icon-linkedin2"></i>';
                                                        echo '</a>';
                                                    echo '</li>';
                                                endif;
                                            echo '</ul>';
                                        endif;
                                    echo '</div>';
                                endif;

                                echo '<div class="content">';
                                    if ( $term->name ) :
                                        echo '<h5 class="title">';
                                            echo '<a href="#" target="_blank">' . esc_html( $term->name ) . '</a>';
                                        echo '</h5>';
                                    endif;

                                    if ( $designation ) :
                                        echo '<span class="designation">' . esc_html( $designation ). '</span>';
                                    endif;
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    endforeach;
                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
endif;