<?php

namespace EduBlinkCore\TL\Widgets;

use \EduBlinkCore\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * EduBlink Core
 *
 * Elementor widget for Tutor LMS Courses.
 *
 * @since 1.0.0
 */
class Courses extends \EduBlinkCore\Widgets\Courses {

    public function get_name() {
        return 'edublink-tl-courses';
    }

    public function get_title() {
        return __( 'Courses( Grid / Carousel / Filter )( Tutor LMS )', 'edublink-core' );
    }

    public function get_keywords() {
        return [ 'edublink', 'query', 'courses', 'lms', 'tutor', 'archive', 'loop', 'grid', 'slider', 'carousel', 'filter' ];
    }

    protected $post_type         = 'courses';
    protected $category_taxonomy = 'course-category';

    /**
     * render the post query
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render_query( $query, $settings, $single_wrapper ) {
        while ( $query->have_posts() ) : $query->the_post();
            global $post;
            $thumb_url = '';
            if ( has_post_thumbnail() && get_the_post_thumbnail_url() ) :
                $thumb_url = $this->render_image( get_post_thumbnail_id( $post->ID ), $settings );
            else :
                $thumb_url = tutor()->url . 'assets/images/placeholder-course.jpg';
            endif;
            $block_data = array(
                'thumb_url' => $thumb_url,
                'style'     => $settings['style']
            );

            if ( 'yes' === $settings['enable_excerpt'] ) :
                $block_data['enable_excerpt'] = true;
                if ( $settings['excerpt_length'] ) :
                    $block_data['excerpt_length'] = $settings['excerpt_length'];
                endif;
                
                if ( $settings['excerpt_end'] ) :
                    $block_data['excerpt_end'] = $settings['excerpt_end'];
                endif;
            else :
                $block_data['enable_excerpt'] = false;
            endif;

            if ( $settings['button_text'] ) :
                $block_data['button_text'] = $settings['button_text'];
            endif;                

            $animation_attribute = '';
            if ( 'slider' !== $settings['display_type'] ) :
                if ( 'yes' === $settings['default_scroll_animation'] ) :
                    $animation_attribute = ' data-sal';
                endif;
            endif;
            ?>
            <div id="post-<?php the_ID(); ?>" <?php edublink_tutor_course_class( $single_wrapper ); ?> <?php post_class( $single_wrapper ); ?> <?php echo esc_attr( $animation_attribute ); ?>>
                <?php tutor_load_template( 'custom.course-block.blocks', compact( 'block_data' ) );
            echo '</div>';  
        endwhile;
        wp_reset_postdata();
    }

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render() {
        $settings         = $this->get_settings_for_display();
        $single_wrapper[] = 'edublink-course-style-' . esc_attr( $settings['style'] );
        $single_wrapper[] = 'edublink-course-' . esc_attr( $settings['style'] ) . '-' . esc_attr( $settings['display_type'] ) . '-item';

        $this->add_render_attribute( 'widget_wrapper', 'class', 'edublink-course-widget-wrapper' );

        if ( 'grid' === $settings['display_type'] ) :
            if ( 'yes' === $settings['enable_filter'] ) :
                $this->add_render_attribute( 'widget_wrapper', 'class', 'edublink-filter-type-cat-filter' );
                $this->add_render_attribute( 'widget_wrapper', 'id', 'edublink-filterable-course-id-' . $this->get_id() );

                $this->add_render_attribute(
                    'container',
                    [
                        'class' => 'edublink-course-filter-type-cat-filter',
                        'id'    =>  'filters-' . esc_attr( $this->get_id() )
                    ]
                );
            endif;

            if ( 'yes' === $settings['enable_masonry'] ) :
                $this->add_render_attribute( 'container', 'class', 'eb-masonry-grid-wrapper' );
                $single_wrapper[] = 'eb-masonry-item';
            endif;
        endif;

        $this->add_render_attribute( 'container', 'class', 'eb-tutor-archive-courses' );
        $this->add_render_attribute( 'container', 'class', 'edublink-course-archive' );
        $this->add_render_attribute( 'container', 'class', 'edublink-lms-courses-' . esc_attr( $settings['display_type'] ) );

        if ( 'yes' === $settings['active_white_bg'] ) :
            $this->add_render_attribute( 'container', 'class', 'active-white-bg' );
        endif;

        if ( 'grid' === $settings['display_type'] ) :
            $single_wrapper[] = $this->grid( $settings );
            $this->add_render_attribute( 'container', 'class', 'edublink-row' );
        else :
            $this->add_render_attribute( 'widget_wrapper', 'class', 'eb-slider-wrapper' );
            $this->add_render_attribute( 'container', 'class', 'swiper swiper-container swiper-container-initialized' );

            if ( 'arrows' === $settings['arrows_and_dots'] || 'both' === $settings['arrows_and_dots'] ) :
                $this->add_render_attribute( 'widget_wrapper', 'class', 'eb-slider-wrapper-arrows-enable' );
            endif;

            if ( 'dots' === $settings['arrows_and_dots'] || 'both' === $settings['arrows_and_dots'] ) :
                $this->add_render_attribute( 'widget_wrapper', 'class', 'eb-slider-wrapper-dots-enable' );
                $this->add_render_attribute( 'container', 'class', 'eb-slider-dots-enable' );
            endif;

            $single_wrapper[] = 'edublink-slider-item';
            $single_wrapper[] = 'swiper-slide';
        endif;

        echo '<div ' . $this->get_render_attribute_string( 'widget_wrapper' ) . '>';
            if ( 'grid' === $settings['display_type'] ) :
                if ( 'yes' === $settings['enable_filter'] ) :
                    echo '<div class="edublink-course-filter-wrapper">';
                        echo '<div class="edublink-filter-course edublink-category-controls-' . esc_attr( $settings['enable_filter'] ) . ' edublink-filter-fullwidth-' . esc_attr( $settings['filter_container_full_width'] ) . '">';
                            $all_filter_text = __( 'All', 'edublink-core' );
                            if ( ! empty( $settings['filter_all_text'] ) ) :
                                $all_filter_text = $settings['filter_all_text'];
                            endif;

                            $cat_args = array(
                                'include'    => $settings['include_categories']
                            );

                            $course_cats = get_terms( $this->category_taxonomy, $cat_args );
                            if ( ! empty( $course_cats ) && ! is_wp_error( $course_cats ) ) :
                                echo '<span data-filter="*" class="filter-item current">' . esc_html( $all_filter_text ) . '</span>';
                                foreach ( $course_cats as $course_cat ) :
                                    echo '<span class="filter-item" data-filter=".' . esc_attr( $course_cat->slug ) . '">' . esc_html( $course_cat->name ) . '</span>';
                                endforeach;
                            endif;
                        echo '</div>';
                    echo '</div>';
                endif;
            endif;
            echo '<div ' . $this->get_render_attribute_string( 'container' ) . '>';
                if ( 'slider' === $settings['display_type'] ) : 
                    $this->slider( $settings );
                    echo '<div ' . $this->get_render_attribute_string( 'swiper' ) . '>';
                endif;

                $wp_query = new \WP_Query( Helper::query_args( $settings, $this->post_type, $this->category_taxonomy ) );
                $this->render_query( $wp_query, $settings, $single_wrapper );

                if ( 'slider' === $settings['display_type'] ) : 
                    echo '</div>';
                endif;

                if ( 'slider' === $settings['display_type'] ) : 
                    if ( 'dots' === $settings['arrows_and_dots'] || 'both' === $settings['arrows_and_dots'] ) :
                        echo '<div class="swiper-pagination"></div>';
                    endif;
                endif;
            echo '</div>';

            if ( 'slider' === $settings['display_type'] ) : 
                if ( 'arrows' === $settings['arrows_and_dots'] || 'both' === $settings['arrows_and_dots'] ) :
                    echo '<div class="swiper-slide-controls slide-prev">';
                        echo '<i class="icon-west"></i>';
                    echo '</div>';
                    echo '<div class="swiper-slide-controls slide-next">';
                        echo '<i class="icon-east"></i>';
                    echo '</div>';
                endif;
            endif;
        echo '</div>';

        if ( ! is_user_logged_in() && ( 1 == $settings['style'] || 14 == $settings['style'] ) ) :
            tutor_load_template_from_custom_path( tutor()->path . '/views/modal/login.php' );
        endif;

        // if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) :
        //     $this->render_editor_script();
        // endif;
    }
}