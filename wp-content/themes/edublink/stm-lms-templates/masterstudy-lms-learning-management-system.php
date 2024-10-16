<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
} //Exit if accessed directly
// phpcs:ignoreFile
// stm_lms_register_style( 'course' );
// stm_lms_register_style( 'classic_course' );

STM_LMS_Course::course_views( get_the_ID() );
get_header();
STM_LMS_Templates::show_lms_template( 'modals/preloader' );
$course_data = apply_filters( 'masterstudy_course_page_header', 'default' );
echo '<div class="' . apply_filters( 'stm_lms_wrapper_classes', 'stm-lms-wrapper' ) . '">';
    echo '<div class="container">';
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                $course_details_style = edublink_set_value( 'ms_course_details_style', 1 );
                $course_details_sidebar = edublink_set_value( 'ms_course_details_sidebar_status', true );
                $course_sidebar_sticky = edublink_set_value( 'ms_course_details_sidebar_sticky', true );
                $course_details_column = 'edublink-col-lg-12';
                $siebar_main_content = 'course-summary';
                $course_sidebar_class = 'ed-course-sidebar';

                if ( isset( $_GET['course_details'] ) ) :
                    $course_details_style = in_array( $_GET['course_details'], array( 1, 2, 3, 4, 5, 6 ) ) ? $_GET['course_details'] : 1;
                endif;

                if ( $course_details_sidebar ) :
                    $course_details_column = 'edublink-col-lg-8';
                endif;

                if ( isset( $_GET['disable_sidebar'] ) ) :
                    $course_details_column = 'edublink-col-lg-12';
                    $course_details_sidebar = false;
                endif;

                if ( isset( $_GET['sidebar_sticky'] ) ) :
                    $course_sidebar_sticky = true;
                endif;

                if ( in_array( $course_details_style, array( 3, 4 ) ) ) :
                    if ( $course_sidebar_sticky ) :
                        wp_enqueue_script( 'theia-sticky-sidebar' );
                        $siebar_main_content .= $siebar_main_content . ' ' . 'eb-sticky-sidebar-parallal-content';
                        $course_sidebar_class = $course_sidebar_class . ' ' . 'eb-sidebar-sticky';
                    endif;
                endif;

                $atts = array(
                    'style' => $course_details_style
                );

                edublink_ms_course_details_header( $course_details_style );

                wp_localize_script(
                    'masterstudy-single-course-components',
                    'expired_data',
                    array(
                        'id' => $course_data['course']->id
                    )
                );

                echo '<div class="edublink-course-details-page ms-course-single-page eb-course-single-style-' . esc_attr( $course_details_style ) . '">';
                    echo '<div class="edublink-container">';
                        echo '<div class="edublink-row">';
                            echo '<div class="' . esc_attr( $siebar_main_content ) . ' ' . apply_filters( 'courese_details_columnn', $course_details_column ) . '">';
                                echo '<div class="eb-course-details-page-content eb-ms-course-details">';
                                    // STM_LMS_Templates::show_lms_template( 'course/classic/parts/tabs' );
                                    if ( '4' === $course_details_style ) :
                                        $preview_thumb = edublink_set_value( 'ms_course_preview_thumb', true );
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
                                                            edublink_breadcrumb_ms_course_meta();
                                                        echo '</div>';
                                                    echo '</div>';
                                                echo '</div>';
                                            echo '</div>';
                                        echo '</div>';
                            
                                        if ( $preview_thumb ) :
                                            echo '<div class="eb-course-single-4-preview">';
                                                edublink_ms_course_preview();
                                            echo '</div>';
                                        endif;
                                    endif;
                                    // STM_LMS_Templates::show_lms_template(
                                    //     'components/course/tabs',
                                    //     array(
                                    //         'course'     => $course_data['course'],
                                    //         'user_id'    => $course_data['current_user_id'],
                                    //         'style'      => $course_details_style,
                                    //         'with_image' => true,
                                    //     )
                                    // );
                                    STM_LMS_Templates::show_lms_template(
                                        'course/parts/tabs',
                                        array(
                                            'course'     => $course_data['course'],
                                            'user_id'    => $course_data['current_user_id'],
                                            'style'      => $course_details_style,
                                            'with_image' => true,
                                        )
                                    );
                                echo '</div>';
                            echo '</div>';

                            if ( $course_details_sidebar ) :
                                echo '<div class="' . esc_attr( $course_sidebar_class ) . ' ' . apply_filters( 'courese_details_sidebar_columnn', 'edublink-col-lg-4' ) . '">';
                                    edublink_ms_course_content_sidebar();
                                echo '</div>';
                            endif;
                        echo '</div>';
                    echo '</div>';
                echo '</div>';

                edublink_ms_related_courses();
            endwhile;
        endif;
    echo '</div>';
echo '</div>';

get_footer();

