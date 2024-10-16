<?php
defined( 'ABSPATH' ) || exit();

$preview_thumb = edublink_set_value( 'tl_course_preview_thumb', true );

echo '<div class="edublink-course-page-header eb-course-details-header-4">';
    echo '<div class="eb-course-header-breadcrumb-content">';
        echo '<div class="' . esc_attr( apply_filters( 'edublink_breadcrumb_container_class', 'edublink-course-4-header' ) ) . '">';
            echo '<div class="edublink-course-breadcrumb-inner">';
                echo '<div class="edublink-course-title">';
                    echo '<h1 class="entry-title">';
                        the_title(); 
                    echo '</h1>';
                echo '</div>';
                
                echo '<div class="edublink-course-header-meta">';
                    edublink_breadcrumb_tl_course_meta();
                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
echo '</div>';

if ( $preview_thumb ) :
    echo '<div class="eb-course-single-4-preview">';
        edublink_tl_course_preview();
    echo '</div>';
endif;
