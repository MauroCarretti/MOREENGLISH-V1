<?php

namespace EduBlinkCore\Events\Widgets;

use \EduBlinkCore\Helper;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EduBlink Core
 *
 * Elementor widget for WP Events Manager Plugin.
 *
 * @since 1.0.0
 */
class WP_Events_Manager extends Widget_Base {
    use \EduBlink_Core\Traits\Slider_Arrows;
    use \EduBlink_Core\Traits\Slider_Dots;
    use \EduBlink_Core\Traits\Posts;
    use \EduBlink_Core\Traits\Grid, \EduBlink_Core\Traits\Slider {
        \EduBlink_Core\Traits\Slider::settings insteadof \EduBlink_Core\Traits\Grid;
        \EduBlink_Core\Traits\Grid::settings as grid_settings;
    }

    /**
     * Retrieve the widget name.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'edublink-wp-events-manager';
    }

    /**
     * Retrieve the widget title.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'Event( WP Events Manager )', 'edublink-core' );
    }

    /**
     * Retrieve the widget icon.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'edublink-elementor-icon eicon-sitemap';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return [ 'edublink', 'events', 'meetup', 'online', 'conversation', 'WP Events Manager' ];
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'edublink_elementor_widgets' ];
    }

    protected $post_type            = 'tp_event';
    protected $category_taxonomy    = 'tp_event_category';
    protected $desktop_max_slider     = 6;
    protected $desktop_default_slider = 3;
    protected $desktop_default_grid   = 3;
    protected $tablet_max_slider      = 3;
    protected $tablet_default_slider  = 2;
    protected $tablet_default_grid    = 2;
    protected $mobile_max_slider      = 2;
    protected $mobile_default_slider  = 1;
    protected $mobile_default_grid    = 1;
    protected $default_content_type, $default_display_type;

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function register_controls() {

        $this->start_controls_section(
            'section_posts',
            [
                'label' => __( 'Event', 'edublink-core' )
            ]
        );

        $this->add_control(
            'style',
            [
                'label'      => __( 'Style', 'edublink-core' ),
                'type'       => Controls_Manager::SELECT,
                'default'    => '1',
                'options'    => [
                    '1'   => __( 'Style 1', 'edublink-core' ),
                    '2'   => __( 'Style 2', 'edublink-core' ),
                    '3'   => __( 'Style 3', 'edublink-core' )
                ]
            ]
        );

        $this->add_control(
            'display_type',
            [
                'label'      => __( 'Display Type', 'edublink-core' ),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'grid',
                'options'    => [
                    'grid'   => __( 'Grid', 'edublink-core' ),
                    'slider' => __( 'Slider', 'edublink-core' )
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'thumb_size',
                'default'   => 'edublink-post-thumb'
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label'        => __( 'Image Height', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'size_units'   => [ 'px' ],
                'range'        => [
                    'px'       => [
                        'min'  => 100,
                        'step' => 10,
                        'max'  => 600
                    ]
                ],
                'selectors'    => [
                    '{{WRAPPER}} .edublink-event-two-item-single .event-image img' => 'height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'button_text',
            [
                'type'         => Controls_Manager::TEXT,
                'label'        => __( 'Button Text', 'edublink-core' ),
                'default'      => __( 'Learn More', 'edublink-core' )
            ]
        );

        $this->add_control(
            'default_scroll_animation',
            [
                'type'         => Controls_Manager::SWITCHER,
                'label'        => __( 'Default Scroll Animation', 'edublink-core' ),
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'yes',
                'return_value' => 'yes',
                'condition'    => [
                    'display_type' => 'grid'
                ]
            ]
        );

        $this->add_control(
            'enable_masonry',
            [
                'type'         => Controls_Manager::SWITCHER,
                'label'        => __( 'Masonry Layout', 'edublink-core' ),
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'no',
                'return_value' => 'yes',
                'condition'    => [
                    'display_type' => 'grid'
                ]
            ]
        );

        $this->add_control(
            'container_alert_text',
            [
                'type'            => Controls_Manager::RAW_HTML,
                'raw'             => __( '<strong>The Masonry Layout might not work on the Elementor Editor Page. But, it\'ll definitely work on the FrontEnd of your site.</strong>', 'edublink-core' ),
                'content_classes' => 'edublink-elementor-widget-alert elementor-panel-alert elementor-panel-alert-info',
                'condition'       => [
                    'display_type'   => 'grid',
                    'enable_masonry' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->query();

        $this->grid_settings();

        $this->settings();

        $this->arrows();

        $this->dots();
    }

    /**
     * return post featured image
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render_image( $image_id, $settings ) {
        $image_size = $settings['thumb_size_size'];

        if ( 'custom' === $image_size ) :
            $image_src = Group_Control_Image_Size::get_attachment_image_src( $image_id, 'thumb_size', $settings );
        else :
            $image_src = wp_get_attachment_image_src( $image_id, $image_size );
            $image_src = $image_src[0];
        endif;
        
        return '<img src="' . esc_url( $image_src ). '" alt="' . esc_attr( edublink_thumbanil_alt_text( $image_id ) ) . '" />';
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
        $settings      = $this->get_settings_for_display();
        $direction     = is_rtl() ? 'true' : 'false';

        $this->add_render_attribute( 'wrapper', 'class', 'eb-events-wrapper' );
        $this->add_render_attribute( 'container', 'class', 'eb-events-items' );
        $this->add_render_attribute( 'container', 'class', 'eb-events-container-' . esc_attr( $settings['display_type'] ) );
        $this->add_render_attribute( 'container', 'class', 'eb-events-' . esc_attr( $settings['display_type'] ) );
        $this->add_render_attribute( 'single', 'class', 'eb-event-single-item' );

        if ( 'grid' === $settings['display_type'] ) :
            $this->add_render_attribute( 'container', 'class', 'edublink-row' );
            if ( '5' === $settings['desktop_grid_columns'] ) :
                $grid_desktop_column = 'el-5';
            else :
                $grid_desktop_column = 12/$settings['desktop_grid_columns'];
            endif;
            $grid_tablet_column  = 12/$settings['tablet_grid_columns'];
            $grid_mobile_column  = 12/$settings['mobile_grid_columns'];
            $grid_column = 'edublink-col-lg-' . esc_attr( $grid_desktop_column ) . ' edublink-col-md-' . esc_attr( $grid_tablet_column ) . ' edublink-col-sm-' . esc_attr( $grid_mobile_column );

            $this->add_render_attribute( 'single', 'class', $grid_column );
            if ( 'yes' === $settings['default_scroll_animation'] ) :
                $this->add_render_attribute( 'single', 'data-sal' );
            endif;

            if ( 'yes' === $settings['enable_masonry'] ) :
                $this->add_render_attribute( 'container', 'class', 'eb-masonry-grid-wrapper' );
                $this->add_render_attribute( 'single', 'class', 'eb-masonry-item' );
            endif;
        else :        
            $this->add_render_attribute( 'wrapper', 'class', 'eb-slider-wrapper' );
            $this->add_render_attribute( 'container', 'class', 'swiper swiper-container swiper-container-initialized' );
            $this->add_render_attribute( 'single', 'class', 'edublink-slider-item swiper-slide' );

            $this->add_render_attribute( 
                'swiper', 
                [
                    'class'                   => 'swiper-wrapper',
                    'data-slidestoshow'       => intval( esc_attr( $settings['desktop_columns']['size'] ) ),
                    'data-tablet-items'       => intval( esc_attr( $settings['tablet_columns']['size'] ) ),
                    'data-mobile-items'       => intval( esc_attr( $settings['mobile_columns']['size'] ) ), 
                    'data-small-mobile-items' => intval( esc_attr( $settings['small_mobile_columns']['size'] ) ),
                    'data-speed'              => intval( esc_attr( $settings['transition_duration'] ) ),
                    'data-direction'          => esc_attr( $direction )
                ]
            );
    
            if ( 'yes' === $settings['autoplay'] ) :
                $this->add_render_attribute( 'swiper', 'data-autoplay', 'true' );
                $this->add_render_attribute( 'swiper', 'data-autoplayspeed', intval( esc_attr( $settings['autoplay_speed'] ) ) );
            endif;
    
            if ( 'yes' === $settings['loop'] ) :
                $this->add_render_attribute( 'swiper', 'data-loop', 'true' );
            endif;

            if ( 'arrows' === $settings['arrows_and_dots'] || 'both' === $settings['arrows_and_dots'] ) :
                $this->add_render_attribute( 'wrapper', 'class', 'eb-slider-wrapper-arrows-enable' );
            endif;

            if ( 'dots' === $settings['arrows_and_dots'] || 'both' === $settings['arrows_and_dots'] ) :
                $this->add_render_attribute( 'wrapper', 'class', 'eb-slider-wrapper-dots-enable' );
                $this->add_render_attribute( 'container', 'class', 'eb-slider-dots-enable' );
            endif;
        endif;

        $wp_query = new \WP_Query( Helper::query_args( $settings, $this->post_type, $this->category_taxonomy ) );
        
        if ( $wp_query->have_posts() ) : 
            echo '<div ' . $this->get_render_attribute_string( 'wrapper' ) . '>';
                echo '<div ' . $this->get_render_attribute_string( 'container' ) . '>';
                    if ( 'slider' === $settings['display_type'] ) : 
                        echo '<div ' . $this->get_render_attribute_string( 'swiper' ) . '>';
                    endif;

                    while ( $wp_query->have_posts() ) : $wp_query->the_post();
                        global $post;
                        $the_id    = get_the_ID();
                        $start_time = get_post_meta( $the_id, 'tp_event_date_start', true ) ? strtotime( get_post_meta( $the_id, 'tp_event_date_start', true ) ) : '';
                        $location = get_post_meta( $the_id, 'tp_event_location', true ) ? get_post_meta( $the_id, 'tp_event_location', true ) : '';

                        $time_start = wpems_event_start( get_option( 'time_format' ) );
				        $time_end   = wpems_event_end( get_option( 'time_format' ) );
				        $starting_date   = wp_date( 'd/M/Y', $start_time );
				        $start_date   = explode( '/', $starting_date );

                        if ( 'default' === $settings['date_format'] ) :
                            $date_format = get_option( 'date_format' );
                        elseif ( 'custom' === $settings['date_format'] ) :
                            $date_format = $settings['custom_date_format'];
                        else :
                            $date_format = $settings['date_format'];
                        endif;

                        echo '<div ' . $this->get_render_attribute_string( 'single' ) . '>';
                            echo '<div class="eb-event-item eb-event-style-' . esc_attr( $settings['style'] ). '">';
                                include EDUBLINK_PLUGIN_DIR . 'widgets/styles/wp-event-manager/event-' . $settings['style'] . '.php';
                            echo '</div>';
                        echo '</div>';
                    endwhile;

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
        endif;
        wp_reset_postdata();
    }
}