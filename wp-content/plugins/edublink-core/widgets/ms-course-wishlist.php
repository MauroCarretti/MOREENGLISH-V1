<?php

namespace EduBlinkCore\MS\Widgets;

use \EduBlinkCore\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * EduBlink Core
 *
 * Elementor widget for MasterStudy Courses.
 *
 * @since 1.0.0
 */
class Wishlist extends \EduBlinkCore\Widgets\Course_Wishlist {

    public function get_name() {
        return 'edublink-ms-course-wishlist';
    }

    public function get_title() {
        return __( 'Courses Wishlist(MasterStudy)', 'edublink-core' );
    }

    public function get_keywords() {
        return [ 'edublink', 'query', 'courses', 'wishlist', 'master', 'study', 'masterstudy' ];
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
        $settings = $this->get_settings_for_display();
        $current_user = \STM_LMS_User::get_current_user( '', false, true );
        $ids = \STM_LMS_User::get_wishlist( $current_user['id'] );
        
        $args = array(
            'post_type'           => 'stm-courses',
            'post__in'            => $ids,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true,
            'posts_per_page'      => - 1
        );

        $query = new \WP_Query( $args );

        if ( is_user_logged_in() ) :
            if ( $query->have_posts() ) :
                echo '<div class="edublink-row">';
                    while ( $query->have_posts() ) : $query->the_post();
                        global $post;
                        $thumb_url = '';
                        if ( has_post_thumbnail() && get_the_post_thumbnail_url() ) :
                            $thumb_url = $this->render_image( get_post_thumbnail_id( $post->ID ), $settings );
                        else :
                            $thumb_url = get_template_directory_uri() . '/assets/images/no-image-found.png';
                        endif;
                        $block_data = [
                            'thumb_url'   => $thumb_url,
                            'style'       => $settings['style']
                        ];

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
                        if ( 'yes' === $settings['default_scroll_animation'] ) :
                            $animation_attribute = ' data-sal';
                        endif;
                        ?>
                        <div id="post-<?php the_ID(); ?>" <?php post_class( $this->grid( $settings ) ); ?>  <?php echo esc_attr( $animation_attribute ); ?>>
                            <?php \STM_LMS_Templates::show_lms_template( 'custom/course-block/blocks', compact( 'block_data' ) ); 
                        echo '</div>';  
                    endwhile;
                echo '</div>';  
            else :
                if ( $settings['no_course_found_text'] ) :
                    echo '<p class="empty-wishlist-text">' . esc_html( $settings['no_course_found_text'] ) . '</p>';
                endif;
            endif;
        else :
            echo '<p class="empty-wishlist-text">' . __( 'Sorry, you need to login first.', 'edublink-core' ) . '</p>';
        endif;
        wp_reset_postdata();
    }
}