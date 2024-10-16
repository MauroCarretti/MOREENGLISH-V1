<?php

namespace EduBlinkCore\Widgets;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EduBlink Core
 *
 * Elementor widget for course category
 *
 * @since 1.0.0
 */
class Course_Categories extends Widget_Base {
    use \EduBlink_Core\Traits\Slider_Arrows;
    use \EduBlink_Core\Traits\Slider_Dots;
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
        return 'edublink-course-category';
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
        return __( 'Course Category 1', 'edublink-core' );
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
        return [ 'edublink', 'category', 'static', 'taxonomy', 'lms', 'categories' ];
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

    protected $desktop_max_slider     = 6;
    protected $desktop_default_slider = 3;
    protected $desktop_default_grid   = 3;
    protected $tablet_max_slider      = 3;
    protected $tablet_default_slider  = 2;
    protected $tablet_default_grid    = 2;
    protected $mobile_max_slider      = 2;
    protected $mobile_default_slider  = 1;
    protected $mobile_default_grid    = 1;
    protected $taxomy_name            = 'course_category';
    protected $default_display_type, $default_content_type = 'mixed';

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
            'section_category',
            [
                'label' => __( 'Categories', 'edublink-core' )
            ]
        );

        $repeater = new Repeater();

        $repeater->start_controls_tabs( 'category_tabs' );

        $repeater->start_controls_tab( 'content_tab', [ 'label' => __( 'Content', 'edublink-core' ) ] );

        $repeater->add_control(
            'slug', 
            [
                'label'       => __( 'Category Slug', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT
            ]
        );

        $repeater->add_control(
            'custom_title', 
            [
                'label'       => __( 'Category Custom Title', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true
            ]
        );

        $repeater->add_control(
            'custom_description', 
            [
                'label'       => __( 'Category Custom Description', 'edublink-core' ),
                'type'        => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'description' => __( 'Only visible at Style 2', 'edublink-core' )
            ]
        );

        $repeater->add_control(
            'custom_url', 
            [
                'label'       => __( 'Category Custom URL', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true
            ]
        );

        $repeater->add_control(
            'custom_count', 
            [
                'label'       => __( 'Category Custom Count', 'edublink-core' ),
                'type'        => Controls_Manager::NUMBER,
                'description' => __( 'Only visible at Style 2, 4 & 5.', 'edublink-core' )
            ]
        );

        $repeater->add_control(
            'icon', 
            [
                'label'       => __( 'Icon', 'edublink-core' ),
                'type'        => Controls_Manager::ICONS,
                'default'     => [
                    'value'   => 'fas fa-star',
                    'library' => 'fa-solid'
                ],
                'description' => __( 'Not applicable for Style 5.', 'edublink-core' )
            ]
        );

        $repeater->add_control(
            'price_range',
            [
                'label'       => __( 'Price Range', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Form: $50.00' , 'edublink-core' ),
                'description' => __( 'Only applicable for Style 5.', 'edublink-core' )
            ]
        );

        $repeater->add_control(
			'image',
			[
                'label'       => __( 'Category Image', 'edublink-core' ),
                'type'        => Controls_Manager::MEDIA,
                'description' => __( 'Only applicable for Style 5.', 'edublink-core' )
            ]
        );

        $repeater->add_control(
			'flag_image',
			[
                'label'       => __( 'Small Image', 'edublink-core' ),
                'type'        => Controls_Manager::MEDIA,
                'description' => __( 'Only applicable for Style 5.', 'edublink-core' )
            ]
        );
        
        $repeater->end_controls_tab();

        $repeater->start_controls_tab( 'style_tab', [ 'label' => __( 'Style', 'edublink-core' ) ] );

        $repeater->add_responsive_control(
            'icon_size',
            [
                'label'        => __( 'Icon Size', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'size_units'   => [ 'px'],
                'range'        => [
                    'px'       => [
                        'min'  => 20,
                        'max'  => 200,
                        'step' => 2
                    ]
                ],
                'selectors'    => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .edublink-category-1 .icon, {{WRAPPER}} {{CURRENT_ITEM}} .edublink-category-2 .icon, {{WRAPPER}} {{CURRENT_ITEM}} .edublink-category-3 .icon, {{WRAPPER}} {{CURRENT_ITEM}} .edublink-category-4 .icon' => 'font-size: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $repeater->add_control(
            'color_light',
            [
                'label'     => __( 'Color( Light )', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .edublink-category-1, {{WRAPPER}} {{CURRENT_ITEM}} .edublink-category-2, {{WRAPPER}} {{CURRENT_ITEM}} .edublink-category-3 .icon, {{WRAPPER}} {{CURRENT_ITEM}} .edublink-category-4 .icon' => 'background: {{VALUE}};'
                ]
            ]
        );

        $repeater->add_control(
            'color_dark',
            [
                'label'     => __( 'Color( Dark )', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .edublink-category-1 .icon, {{WRAPPER}} {{CURRENT_ITEM}} .edublink-category-2 .icon, {{WRAPPER}} {{CURRENT_ITEM}} .edublink-category-2 .content .course-count, {{WRAPPER}} {{CURRENT_ITEM}} .edublink-category-3 .icon, {{WRAPPER}} {{CURRENT_ITEM}} .edublink-category-4 .icon, {{WRAPPER}} {{CURRENT_ITEM}} .edublink-category-4 .title a:hover, {{WRAPPER}} {{CURRENT_ITEM}} .edublink-category-3 .title a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}} .edublink-category-1:hover, {{WRAPPER}} {{CURRENT_ITEM}} .edublink-category-2:hover, {{WRAPPER}} {{CURRENT_ITEM}} .edublink-category-3:hover .icon, {{WRAPPER}} {{CURRENT_ITEM}} .edublink-category-4:hover .icon' => 'background: {{VALUE}};'
                ]
            ]
        );

        $repeater->add_control(
            'color_semi_light',
            [
                'label'     => __( 'Color( Semi Light )', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .edublink-category-2 .icon, {{WRAPPER}} {{CURRENT_ITEM}} .edublink-category-2 .content .course-count' => 'background: {{VALUE}};'
                ],
                'description' => __( 'Only visible at Style 2, on the background of icon and category count.', 'edublink-core' )
            ]
        );
        
        $repeater->add_control(
            'color_semi_light_2',
            [
                'label'     => __( 'Color( Semi Light ) 2', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .edublink-category-2:hover .icon, {{WRAPPER}} {{CURRENT_ITEM}} .edublink-category-2:hover .content .course-count' => 'background: {{VALUE}};'
                ],
                'description' => __( 'Only visible at Style 2, on the background of icon and category count while hovering.', 'edublink-core' )
            ]
        );

        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $this->add_control(
            'categories',
            [
                'type'        => Controls_Manager::REPEATER,
                'title_field' => '{{slug}}',
                'fields'      => $repeater->get_controls()
            ]   
        );

        $this->add_control(
            'settings_separator_before',
            [
                'type' => Controls_Manager::DIVIDER
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
                    '3'   => __( 'Style 3', 'edublink-core' ),
                    '4'   => __( 'Style 4', 'edublink-core' ),
                    '5'   => __( 'Style 5', 'edublink-core' )
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

        $this->add_control(
            'enable_category_count',
            [
                'type'          => Controls_Manager::SWITCHER,
                'label'         => __( 'Category Count', 'edublink-core' ),
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'       => 'yes',
                'return_value'  => 'yes'
            ]
        );

        $this->add_control(
            'course_label',
            [
                'label'       => __( 'Course Label', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Course' , 'edublink-core' ),
                'description' => __( 'Label for singular course( Only for 1 ).', 'edublink-core' ),
                'condition'   => [
                    'enable_category_count' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'courses_label',
            [
                'label'       => __( 'Courses Label', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Courses' , 'edublink-core' ),
                'description' => __( 'Label for plural courses.', 'edublink-core' ),
                'condition'   => [
                    'enable_category_count' => 'yes'
                ]
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

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'        => 'thumb_size',
                'default'     => 'full',
                'description' => __( 'Only applicable for Style 5.', 'edublink-core' ),
                'condition'   => [
					'style' => '5'
				]
            ]
        );

        $this->end_controls_section();
        
        $this->grid_settings();

        $this->settings();

        $this->arrows();

        $this->dots();

        $this->start_controls_section(
            'grid_container_style',
            [
				'label' => __( 'Content', 'edublink-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
					'display_type' => 'grid'
				]
            ]
        );
        
        $this->add_responsive_control(
			'container_grid_spacing',
			[
				'label'       => __( 'Spacing', 'edublink-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'selectors'   => [
					'{{WRAPPER}} .eb-course-cat-container-grid.edublink-row' => 'margin: 0 calc(-{{SIZE}}px / 2) -{{SIZE}}px;',
					'{{WRAPPER}} .edublink-row>*' => 'margin-bottom: {{SIZE}}px !important; padding: 0 calc({{SIZE}}px / 2);'
				]
			]
		);

        $this->end_controls_section();
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
        $settings   = $this->get_settings_for_display();
        $direction  = is_rtl() ? 'true' : 'false';
        $categories = $settings['categories'];

        $this->add_render_attribute( 'wrapper', 'class', 'eb-course-cat-wrapper' );
        $this->add_render_attribute( 'container', 'class', 'eb-course-cat-container-' . esc_attr( $settings['display_type'] ) );
        $this->add_render_attribute( 'container', 'class', 'eb-course-cat-' . esc_attr( $settings['display_type'] ) );

        if ( 'grid' === $settings['display_type'] ) :
            $this->add_render_attribute( 'container', 'class', 'edublink-row' );
        else :        
            $this->add_render_attribute( 'wrapper', 'class', 'eb-slider-wrapper' );
            $this->add_render_attribute( 'container', 'class', 'swiper swiper-container swiper-container-initialized' );

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

        if ( is_array( $categories ) ) :
            echo '<div ' . $this->get_render_attribute_string( 'wrapper' ) . '>';
                echo '<div ' . $this->get_render_attribute_string( 'container' ) . '>';
                    if ( 'slider' === $settings['display_type'] ) : 
                        echo '<div ' . $this->get_render_attribute_string( 'swiper' ) . '>';
                    endif;
                    foreach ( $categories as $key => $category ) :
                        $link_key = 'link_' . $key;

                        if ( 'grid' === $settings['display_type'] ) :
                            if ( '5' === $settings['desktop_grid_columns'] ) :
                                $grid_desktop_column = 'el-5';
                            else :
                                $grid_desktop_column = 12/$settings['desktop_grid_columns'];
                            endif;
                            $grid_tablet_column  = 12/$settings['tablet_grid_columns'];
                            $grid_mobile_column  = 12/$settings['mobile_grid_columns'];
                            $grid_column = 'edublink-col-lg-' . esc_attr( $grid_desktop_column ) . ' edublink-col-md-' . esc_attr( $grid_tablet_column ) . ' edublink-col-sm-' . esc_attr( $grid_mobile_column );
                            $this->add_render_attribute( $link_key, 'class', $grid_column );
                            if ( 'yes' === $settings['default_scroll_animation'] ) :
                                $this->add_render_attribute( $link_key, 'data-sal' );
                            endif;
                        else :
                            $this->add_render_attribute( $link_key, 'class', 'edublink-slider-item swiper-slide' );
                        endif;

                        $this->add_render_attribute( $link_key, 'class', 'edublink-course-single-cat' );
                        $this->add_render_attribute( $link_key, 'class', 'edublink-course-cat-single-' . esc_attr( $settings['display_type'] ) );

                        $this->add_render_attribute( $link_key, 'class', 'elementor-repeater-item-'. esc_attr( $category['_id'] ) );

                        $term = get_term_by( 'slug', $category['slug'], $this->taxomy_name );
                        $link = $category['custom_url'];
                        $count = 0;
                        $title = $category['custom_title'];
                        $description = $category['custom_description'];

                        if ( $category['custom_count'] ) :
                            $count = $category['custom_count'];
                        endif;

                        if ( $term ) :
                            if ( empty( $link ) ) :
                                $link = get_term_link( $term, $this->taxomy_name );
                            endif;
                            
                            if ( empty( $title ) ) :
                                $title = $term->name;
                            endif;

                            if ( empty( $description ) ) :
                                $description = $term->description;
                            endif;
                            
                            if ( empty( $count ) ) :
                                $count = $term->count;
                            endif;
                        endif;

                        if ( '5' === $settings['style'] ) :
                            $image         = $category['image'];
                            $image_src_url = Group_Control_Image_Size::get_attachment_image_src( $image['id'], 'thumb_size', $settings );

                            if ( empty( $image_src_url ) ) :
                                $image_url = $image['url']; 
                            else :
                                $image_url = $image_src_url;
                            endif;

                            if ( ! empty( $category['flag_image']['url'] ) ) :
                                $flag_image_src = wp_get_attachment_image_src( $category['flag_image']['id'], 'full' );
                                $flag_image_src = $flag_image_src[0];
                            else :
                                $flag_image_src = $image_src_url;
                            endif;
                        endif;

                        echo '<div ' . $this->get_render_attribute_string( $link_key ) . '>';
                            include EDUBLINK_PLUGIN_DIR . 'widgets/styles/course-categories/category-' . $settings['style'] . '.php';
                        echo '</div>';
                    endforeach; 

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
    }
}