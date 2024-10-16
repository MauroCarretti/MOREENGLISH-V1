<?php

namespace EduBlinkCore\Widgets;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EduBlink Core
 *
 * Elementor widget for post.
 *
 * @since 1.0.0
 */
class Courses extends Widget_Base {
    use \EduBlink_Core\Traits\Posts;
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
        return 'edublink-courses';
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
        return __( 'Courses( Grid / Carousel / Filter )', 'edublink-core' );
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
        return 'eicon-posts-grid edublink-elementor-icon';
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
    protected $post_type              = LP_COURSE_CPT;
    protected $category_taxonomy      = 'course_category';
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
            'section_courses',
            [
                'label' => __( 'Courses', 'edublink-core' )
            ]
        );

        $this->add_control(
            'style',
            [
                'label'     => __( 'Style', 'edublink-core' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => '1',
                'options'   => [
                    '1'     => __( 'One', 'edublink-core' ),
                    '2'     => __( 'Two', 'edublink-core' ),
                    '3'     => __( 'Three', 'edublink-core' ),
                    '4'     => __( 'Four', 'edublink-core' ),
                    '5'     => __( 'Five', 'edublink-core' ),
                    '6'     => __( 'Six', 'edublink-core' ),
                    '7'     => __( 'Seven', 'edublink-core' ),
                    '8'     => __( 'Eight', 'edublink-core' ),
                    '9'     => __( 'Nine', 'edublink-core' ),
                    '10'    => __( 'Ten', 'edublink-core' ),
                    '11'    => __( 'Eleven', 'edublink-core' ),
                    '12'    => __( 'Twelve', 'edublink-core' ),
                    '13'    => __( 'Thirteen', 'edublink-core' ),
                    '14'    => __( 'Fourteen', 'edublink-core' ),
                    '15'    => __( 'Fifteen', 'edublink-core' ),
                    '16'    => __( 'Sixteen', 'edublink-core' ),
                    '17'    => __( 'Seventeen', 'edublink-core' ),
                    'quran' => __( 'Quran', 'edublink-core' )
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
            'enable_filter',
            [
                'label'        => __( 'Filter', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,    
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
            'masonry_alert_text',
            [
                'type'            => Controls_Manager::RAW_HTML,
                'raw'             => __( '<strong>The Filtering might not work on the Elementor Editor Page. But, it\'ll definitely work on the FrontEnd of your site.</strong>', 'edublink-core' ),
                'content_classes' => 'edublink-elementor-widget-alert elementor-panel-alert elementor-panel-alert-info',
                'condition'         => [
                    'enable_filter' => 'yes',
                    'display_type'  => 'grid'
                ]
            ]
        );

        $all_text_condition = [
            'enable_filter' => 'yes',
            'display_type'    => 'grid'
        ];
        if ( 'edublink-lp-courses' === $this->get_name() ) :
            $this->add_control(
                'filter_type',
                [
                    'label'             => __( 'Filter Type', 'edublink-core' ),
                    'type'              => Controls_Manager::SELECT,
                    'label_block'       => true,
                    'default'           => 'cat-filter',
                    'options'           => [
                        'cat-filter'    => __( 'Category Filtering', 'edublink-core' ),
                        'tab-filter'    => __( 'Filter by New/ Featured/ Popular',   'edublink-core' )
                    ],
                    'condition'         => [
                        'enable_filter' => 'yes',
                        'display_type'  => 'grid'
                    ]
                ]
            );
            $all_text_condition = [
                'enable_filter' => 'yes',
                'display_type'    => 'grid',
                'filter_type'     => 'cat-filter'
            ];
        endif;

        $this->add_control(
            'filter_all_text',
            [   
                'label'     => __( 'Text for All Courses', 'edublink-core' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'All', 'edublink-core' ),
                'condition' => $all_text_condition
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'thumb_size',
                'default'   => 'edublink-post-thumb'
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

        $this->add_control(
            'button_text',
            [
                'label'       => __( 'Button Text', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => false
            ]
        );

        $this->add_control(
			'active_white_bg', [
				'label'        => __( 'Active White Background', 'edublink-core' ),
				'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
				'default'      => 'no',
				'return_value' => 'yes'
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'control_style',
            [
                'label'     => __( 'Control', 'edublink-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'enable_filter' => 'yes',
                    'display_type'  => 'grid'
                ]
            ]
        );

        $this->add_responsive_control(
            'control_alignment',
            [
                'label'          => __( 'Control Alignment', 'edublink-core' ),
                'type'           => Controls_Manager::CHOOSE,
                'options'        => [
                    'flex-start'       => [
                        'title'  => __( 'Left', 'edublink-core' ),
                        'icon'   => 'eicon-text-align-left'
                    ],
                    'center'     => [
                        'title'  => __( 'Center', 'edublink-core' ),
                        'icon'   => 'eicon-text-align-center'
                    ],
                    'flex-end'      => [
                        'title'  => __( 'Right', 'edublink-core' ),
                        'icon'   => 'eicon-text-align-right'
                    ]
                ],
                'selectors'      => [
                    '{{WRAPPER}} .edublink-filter-course' => 'justify-content: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'control_margin',
            [
                'label'        => __( 'Margin', 'edublink-core' ),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => [ 'px', 'em', '%' ],
                'selectors'    => [
                    '{{WRAPPER}} .edublink-filter-course' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );  

        $this->end_controls_section();

        $this->query();

        $this->grid_settings();

        $this->settings();
    }

    /**
     * return course featured image
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
        return $image_src;
    }

    /**
     * return number of courses to show for load more button
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function load_more_button_page_number( $settings ) {
        global $wp_query;
        $number_of_posts = $settings['per_page']['size'];
        return $wp_query->$number_of_posts;
    }

    /**
     * return grid columns
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function grid( $settings ) {
        if ( '5' === $settings['desktop_grid_columns'] ) :
            $grid_desktop_column = 'el-5';
        else :
            $grid_desktop_column = 12/$settings['desktop_grid_columns'];
        endif;
        $grid_tablet_column  = 12/$settings['tablet_grid_columns'];
        $grid_mobile_column  = 12/$settings['mobile_grid_columns'];
        $grid_column = 'edublink-col-lg-' . esc_attr( $grid_desktop_column ) . ' edublink-col-md-' . esc_attr( $grid_tablet_column ) . ' edublink-col-sm-' . esc_attr( $grid_mobile_column );

        return $grid_column;
    }

    /**
     * render slider settings
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function slider( $settings ) {
        $direction  = is_rtl() ? 'true' : 'false';

        $this->add_render_attribute( 'swiper', 'class', 'swiper-wrapper' );
        
        $this->add_render_attribute( 
            'swiper', 
            [
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
    }

    /**
     * print jquery script for course filter
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render_editor_script() { 
        ?>
        <script type="text/javascript">
            jQuery( document ).ready( function($) {
                if ( $.isFunction( $.fn.isotope ) ) {
                    $( '.edublink-filter-type-cat-filter' ).each( function() {
                        let wrapper = $( this ).find( '.edublink-course-filter-type-cat-filter' ),
                        courseItem  = '#' + $(this).attr( 'id' );
                        wrapper.isotope( {
                            filter: '*',
                            animationOptions: {
                                queue: true
                            }
                        } );

                        $( courseItem + ' .edublink-category-controls-yes span' ).click(function(){
                            $( courseItem + ' .edublink-category-controls-yes span.current' ).removeClass( 'current' );
                            $(this).addClass( 'current' );
                     
                            let selector = $(this).attr( 'data-filter' );
                            wrapper.isotope( {
                                filter: selector,
                                animationOptions: {
                                    queue: true
                                }
                            } );
                            return false;
                        } );
                    } );
                }
            } );
        </script>
        <?php
    }
}