<?php

namespace EduBlinkCore\LL\Widgets;

use \EduBlinkCore\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * EduBlink Core
 *
 * Elementor widget for LearnPress Courses.
 *
 * @since 1.0.0
 */
class Wishlist extends \EduBlinkCore\Widgets\Course_Wishlist {

    public function get_name() {
        return 'edublink-ll-course-wishlist';
    }

    public function get_keywords() {
        return [ 'edublink', 'query', 'courses', 'wishlist', 'lms', 'lifter lms' ];
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

        $ids = \EduBlink_Wishlist::fetch_wishlist();
        $ids = ( ! empty( $ids ) && is_array( $ids ) ) ? array_merge( array( 0 ), $ids ) : array( 0 );
        $args = array(
            'post_type'           => 'course',
            'post__in'            => $ids,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true,
            'posts_per_page'      => - 1
        );

        $query = new \WP_Query( $args );

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
                    $args = [
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
                        <?php llms_get_template( 'custom/course-block/blocks.php', compact( 'block_data' ) );
                    echo '</div>';  
                endwhile;
            echo '</div>';  
        else :
            if ( $settings['no_course_found_text'] ) :
                echo '<p class="empty-wishlist-text">' . esc_html( $settings['no_course_found_text'] ) . '</p>';
            endif;
        endif;
        wp_reset_postdata();
    }
}